<?php
/*
Function fetches and retrieves data on promises tracked.
@params : promise ID
*/
function pr_get_all_stats($post_id) {
	
	$domaine = get_the_terms( $post_id, 'domaine_daction' );
	$source = get_the_terms( $post_id, 'sources' );
	$statut = get_the_terms( $post_id, 'statut' );
	
	$all_actions_args = array(
		'post_type' 	=>	'action',
		'post_status'	=>	'publish',
		'meta_query' 	=>	array(
			array(
				'key' 	  =>	'prefix-promesse',
				'value'   =>	$post_id,
				'compare' =>	'=',		
			),
		)
	);
	$ongoing_actions_args = array(
		'post_type' 	=>	'action',
		'post_status'	=>	'publish',
		'meta_query' 	=>	array(
			array(
				'key' 	  =>	'prefix-promesse',
				'value'   =>	$post_id,
				'compare' =>	'=',		
			),
		),
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'progression',			
				'field'    =>	'slug',			
				'terms'    =>	'en-cours',			
			)
		),
	);
	$complete_actions_args = array(
		'post_type' 	=>	'action',
		'post_status'	=>	'publish',
		'meta_query' 	=>	array(
			array(
				'key' 	  =>	'prefix-promesse',
				'value'   =>	$post_id,
				'compare' =>	'=',		
			),
		),
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'progression',			
				'field'    =>	'slug',			
				'terms'    =>	'terminee',			
			)
		),
	);
	
	$all_actions_query = new WP_Query( $all_actions_args );
	$ongoing_actions_query = new WP_Query( $ongoing_actions_args );
	$complete_actions_query = new WP_Query( $complete_actions_args );
	
	$all_actions_count = $all_actions_query->post_count;
	$ongoing_actions_count = $ongoing_actions_query->post_count;
	$complete_actions_count = $complete_actions_query->post_count;
	
	return array(
		'promesse' 	=>	array(
			'domaine' => $domaine[0]->name,
			'source' =>	$source[0]->name,
			'statut' =>	$statut[0]->name,
			'desc' =>	$statut[0]->description,
		),
		'data' => array(
			'all_actions' => $all_actions_count,
			'ongoing_actions' => $ongoing_actions_count,
			'complete_actions' => $complete_actions_count,
		),
	);
}

/**
Retrieves the actions related to a promise and displays them chronologically
*/
function pr_get_promise_actions( $post_id ) {

	$get_actions_args = array(
		'post_type' 	=>	'action',
		'post_status'	=>	'publish',
		'meta_query' 	=>	array(
			array(
				'key' 	  =>	'prefix-promesse',
				'value'   =>	$post_id,
				'compare' =>	'=',		
			),
		)
	);	
	
	$get_actions_query = new WP_Query( $get_actions_args );
	
	echo '
	<h3 class="mt-5 text-center">Chronologie des actions prises</h3>
	
	<div class="container mt-5 mb-5">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<ul class="timeline">';
			for($i = 0; $i < sizeof($get_actions_query->posts); $i++ ) {
				
				$progression = get_the_terms( $get_actions_query->posts[$i]->ID, 'progression' );
				
				$action_meta = get_post_meta( $get_actions_query->posts[$i]->ID );
				$action_date = ($action_meta['prefix-date'][0]);
				// $action_date = date_create($action_meta['prefix-date'][0]);
				// var_dump($progression);
				
				switch ( $progression[0]->name) {
					case 'Terminée';
					$badge_class = 'badge-success';
					break;
					
					case 'En cours';
					$badge_class = 'badge-warning text-light';
					break;
					
					default;
					$badge_class = 'badge-danger text-light';
					break;
				}
				
				echo '
					<li>
						<div class="text-rose">'.date_i18n(get_option("date_format"), strtotime($action_date)).' <span class="font-weight-light badge badge-pill '.$badge_class.'">'.$progression[0]->name.'</span></div>
						<h4 class="">'.$get_actions_query->posts[$i]->post_title.'</h4>
						<p>
						'.$get_actions_query->posts[$i]->post_content.'
						<div class="text-muted small">'.$progression[0]->description.'</div>
						</p>
					</li>';
		
			}
			echo '
				</ul>
			</div>
		</div>
	</div>';
}

/*
Function displays the data in a table
@params :
	domaine
	statut
	description
	source
	total actions
	ongoing actions
	complete ctions
*/
function pr_show_stats($pr_domaine, $pr_statut, $pr_desc, $pr_source, $all_actions, $ongoing_actions, $complete_actions) {
	
	// Calculate % actions completed
	$prcnt_completed = ( $complete_actions == 0 ) ? 0 : ( $complete_actions * 100 )/$all_actions;
	$prcnt_ongoing =  ( $ongoing_actions == 0 ) ? 0 : ( $ongoing_actions * 100 )/$all_actions;
	
	?>
	<div class="container" style="background-color: #efefef">
		<div class="row">
			<div class="col-md-6">
				<div class="my-4">
					<div class="text-uppercase small text-center" style="letter-spacing: 12px; color: #df2176;">Statistiques</div>
					<div class="container">
						<div class="row">
							<div class="col-4 text-center">
								<div class="display-1" style="font-weight:500; color:#bfbfbf"><?php echo $all_actions ?></div>
								<div class="text-uppercase small">Actions</div>
							</div>
							<div class="col-4 text-center">
								<div class="display-1" style="font-weight:500; color:#bfbfbf"><?php echo $ongoing_actions ?></div>
								<div class="text-uppercase small">En cours</div>
							</div>
							<div class="col-4 text-center">
								<div class="display-1" style="font-weight:500; color:#bfbfbf"><?php echo $complete_actions ?></div>
								<div class="text-uppercase small">Terminées</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="my-4">
					<div class="text-uppercase small text-center" style="letter-spacing: 12px; color: #df2176;">Progression</div>
					<div class="container">
						<div class="row">
							<div class="col my-3">
								<div class="small d-flex justify-content-between">
									<div class="">Actions en cours</div>
									<div class=""><?php echo number_format( $prcnt_ongoing, 2, ',', '' ) ?>%</div>
								</div>
								<div class="progress" style="height: 5px;">
									<div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $prcnt_ongoing ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prcnt_ongoing ?>%"></div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col my-3">
								<div class="small d-flex justify-content-between">
									<div class="">Actions terminées</div>
									<div class=""><?php echo number_format( $prcnt_completed, 2, ',', '' ) ?>%</div>
								</div>
								<div class="progress" style="height: 5px;">
									<div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $prcnt_completed ?>" aria-valuemin="0" aria-valuemax="0" style="width: <?php echo $prcnt_completed ?>%"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 
			COLUMN 2
			-->
			<div class="col-md-6">
				<div class="my-4">
					<div class="text-uppercase small mb-3" style="letter-spacing: 12px; color: #df2176;">Domaine</div>
					<h3 style="color: #bfbfbf"><?php echo $pr_domaine ?></h3>
				</div>
				<div class="my-4">
					<div class="text-uppercase small mb-3" style="letter-spacing: 12px; color: #df2176;">Statut</div>
					<h3 style="color: #bfbfbf"><?php echo $pr_statut ?></h3>
					<div class="" style="color: #bfbfbf"><?php echo $pr_desc ?></div>
				</div>
				
				<div class="my-4">
					<div class="text-uppercase small mb-3" style="letter-spacing: 12px; color: #df2176;">Source</div>
					<div class="text-muted"><?php echo $pr_source ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}