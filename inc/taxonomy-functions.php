<?php
/*
Function fetches and retrieves promises according to their domain.
@params : term_id
*/
function pr_get_domain_promises($term_id) {
	
	$promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'domaine',			
				'field'    =>	'term_id',			
				'terms'    =>	$term_id,			
			)
		),
	);
	
	return new WP_Query( $promises_args );
}

/*
Function fetches and retrieves data on a specific domain.
@params : 
*/
function pr_get_tax_stats($term_id) {
	
	$all_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'domaine',			
				'field'    =>	'term_id',			
				'terms'    =>	$term_id,			
			)
		),
	);
	$ongoing_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			'relation'	=> 	'AND',
			array(
				'taxonomy' =>	'domaine',			
				'field'    =>	'term_id',			
				'terms'    =>	$term_id,			
			),
			array(
				'taxonomy' =>	'statut',			
				'field'    =>	'slug',			
				'terms'    =>	'en-cours',			
			),
		),
	);
	$complete_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			'relation'	=> 	'AND',
			array(
				'taxonomy' =>	'domaine',			
				'field'    =>	'term_id',			
				'terms'    =>	$term_id,			
			),
			array(
				'taxonomy' =>	'statut',			
				'field'    =>	'slug',			
				'terms'    =>	'terminee',			
			)
		),
	);
	
	$all_promises_query = new WP_Query( $all_promises_args );
	$ongoing_promises_query = new WP_Query( $ongoing_promises_args );
	$complete_promises_query = new WP_Query( $complete_promises_args );
	
	$all_promises_count = $all_promises_query->post_count;
	$ongoing_promises_count = $ongoing_promises_query->post_count;
	$complete_promises_count = $complete_promises_query->post_count;
	
	return array(
		'data' => array(
			'all_promises' => $all_promises_count,
			'ongoing_promises' => $ongoing_promises_count,
			'complete_promises' => $complete_promises_count,
		),
	);
}

/*
Function displays the data in a table
@params :
*/
function pr_show_all_stats() {
	
	$all_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
	);
	$all_actions_args = array(
		'post_type' 	=>	'action',
		'post_status'	=>	'publish',
	);
	$ongoing_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'statut',			
				'field'    =>	'slug',			
				'terms'    =>	'en-cours',			
			),
		),
	);
	$completed_promises_args = array(
		'post_type' 	=>	'promesse',
		'post_status'	=>	'publish',
		'tax_query' 	=>	array(
			array(
				'taxonomy' =>	'statut',			
				'field'    =>	'slug',			
				'terms'    =>	'realisee',			
			),
		),
	);
	
	$all_promises_query = new WP_Query( $all_promises_args );
	$ongoing_promises_query = new WP_Query( $ongoing_promises_args );
	$completed_promises_query = new WP_Query( $completed_promises_args );
	$all_actions_query = new WP_Query( $all_actions_args );
	
	$all_promises_count = $all_promises_query->found_posts;
	$ongoing_promises_count = $ongoing_promises_query->found_posts;
	$completed_promises_count = $completed_promises_query->found_posts;
	$all_actions_count = $all_actions_query->found_posts;
	$all_domains_count = wp_count_terms('domaine', array('hide_empty' => true));
	
	// Calculate % actions completed
	$prcnt_completed = ( $complete_promises_count == 0 ) ? 0 : ( $completed_promises_count * 100 )/$all_promises_count;
	$prcnt_ongoing =  ( $ongoing_promises_count == 0 ) ? 0 : ( $ongoing_promises_count * 100 )/$all_promises_count;
	
	?>
	
	<script>
	function drawPieChart(divID, percent=0, title='En cours') {
	// function drawPieChart(data={}) {
		var canvas = document.getElementById(divID);
		var ctx = canvas.getContext("2d");
		
		ctx.beginPath();
		ctx.arc(Math.floor(canvas.width / 2), Math.floor(canvas.height / 2), 110, 0, 2 * Math.PI); 		// arc(x, y, r, startangle, endangle)
		ctx.strokeStyle = "#dedede"; 
		ctx.lineWidth = 14;
		ctx.stroke();

		ctx.beginPath();
		ctx.arc(Math.floor(canvas.width / 2), Math.floor(canvas.height / 2), 110, 0, ((percent * 2) / 100) * Math.PI); 	// arc(x, y, r, startangle, endangle)
		ctx.strokeStyle = "#df2176"					// "#005091";
		ctx.fillStyle = "#005091"					// "#005091";
		ctx.lineWidth = 14;
		ctx.lineCap = "square";
		ctx.stroke();
		ctx.closePath();
		// ctx.fill();
		
		var text = percent+'%';
		ctx.font = "48pt helvetica";
		ctx.textAlign = "center";
		ctx.textBaseLine = "middle";
		ctx.fillStyle = "#bfbfbf";
		ctx.fillText(text, Math.floor(canvas.width / 2), Math.floor(canvas.height / 2));
		
		var text = title;
		ctx.font = "14pt helvetica";
		ctx.textAlign = "center";
		ctx.textBaseLine = "middle";
		ctx.fillStyle = "#bfbfbf";
		ctx.fillText(text, Math.floor(canvas.width / 2), 150);
	};
	</script>

	
	<div class="container mb-4" style="background-color: #efefef">
		<div class="row">
			<div class="col-lg-6">
				<div class="my-4">
					<div class="container">
						<div class="row my-4">
							<div class="col-6 text-center">
								<div class="display-2" style="font-weight:500; color:#bfbfbf"><?php echo $all_promises_count ?></div>
								<div class="text-uppercase small">Promesses</div>
							</div>
							<div class="col-6 text-center">
								<div class="display-2" style="font-weight:500; color:#bfbfbf;"><?php echo $all_domains_count ?></div>
								<div class="text-uppercase small text-truncate">Domaines d'action</div>
							</div>
						</div>
						
						<div class="row my-4">
							<div class="col-6 text-center">
								<div class="display-2" style="font-weight:500; color:#bfbfbf"><?php echo $ongoing_promises_count ?></div>
								<div class="text-uppercase small">En cours</div>
							</div>
							<div class="col-6 text-center" style="">
								<div class="display-2" style="font-weight:500; color:#bfbfbf"><?php echo $all_actions_count ?></div>
								<div class="text-uppercase small">Actions prises</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 
			COLUMN 2
			-->
			<div class="col-lg-6">
				<div class="row">
					<div class="col-sm-6 text-center mt-4 mb-2">
						<canvas id="ongoing" width="240" height="240"></canvas>
					</div>
					<!-- 
					COLUMN 2
					-->
					<div class="col-sm-6 text-center mt-4 mb-4">
						<canvas id="realized" width="240" height="240"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	echo '
	<script>
		drawPieChart("ongoing", '.number_format($prcnt_ongoing, 1).', "En cours");
		drawPieChart("realized", '.number_format($prcnt_completed, 1).', "Réalisées");
	</script>';
}
