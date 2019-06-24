<?php
// Custom columns
function set_custom_edit_promesse_columns($columns) {
	/* Désactivation de certaines colonnes qui ne seront pas utilisées */
	unset( $columns['date'] );
	unset( $columns['comments'] );
	unset( $columns['author'] );
	/* Création de nouvelles colonne qui contiendont informations personnalisées */
	$columns['title'] 	= __( 'Promesse', 'biyametre' ); // (La colonne Title est remplacée par Promesse
	$columns['domaine_daction'] = __( 'Domaine d\'action', 'biyametre' );
	$columns['sources'] = __( 'Source(s)', 'biyametre' );
	$columns['statut'] 	= __( 'Statut', 'biyametre' );
	$columns['actions'] = __( 'Actions', 'biyametre' );
	$columns['date'] 	= __( 'Date', 'biyametre' );
	
	return $columns;
}

function custom_promesse_column( $column, $post_id ) {
	/* Les contenus personnalisés sont associés aux colonnes créées plus haut */
	
	switch ( $column ) {

		case 'sources' :
			$terms = get_the_term_list( $post_id , 'sources' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Source inconnue', 'biyametre' );
			break;
		
		case 'domaine_daction' :
			$terms = get_the_term_list( $post_id , 'domaine_daction' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Domaine d\'action inconnu', 'biyametre' );
			break;

		case 'statut' :
			$terms = get_the_term_list( $post_id , 'statut' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Statut inconnu', 'biyametre' );
			break;
		
		case 'actions' :
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
			
			$terms = $get_actions_query->post_count;
			if ( is_int( $terms ) )
				echo $terms . ' actions ';
			else
				_e( '0', 'biyametre' );
			break;
		/*
		case 'author' :
			echo get_post_meta( $post_id , 'author' , true ); 
			break;
		*/
	}
}

add_filter( 'manage_promesse_posts_columns', 'set_custom_edit_promesse_columns' );
add_action( 'manage_promesse_posts_custom_column' , 'custom_promesse_column', 10, 2 );

// Custom columns
function set_custom_edit_actions_columns($columns) {
	/* Désactivation de certaines colonnes qui ne seront pas utilisées */
	unset( $columns['date'] );
	$columns['title'] 	= __( 'Action', 'biyametre' ); // (La colonne Title est remplacée par Action
	$columns['promesse'] = __( 'Promesse', 'biyametre' );
	$columns['progression'] = __( 'Progression', 'biyametre' );
	// $columns['statut'] 	= __( 'Statut', 'biyametre' );
	$columns['date'] 	= __( 'Date', 'biyametre' );
	
	return $columns;
}

function custom_actions_column( $column, $post_id ) {
	/* Les contenus personnalisés sont associés aux colonnes créées plus haut */
	
	switch ( $column ) {
		
		case 'promesse' :
			
			$the_meta = get_post_meta( $post_id );
			$promesse_id = $the_meta['prefix-promesse'][0];
			$promesse = get_post( $promesse_id );

			if ( is_string( $promesse->post_title ) )
				echo $promesse->post_title;
			else
				_e( 'Promesse introuvable', 'biyametre' );
		break;
		
		case 'progression' :
			$terms = get_the_term_list( $post_id , 'progression' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Progression inconnue', 'biyametre' );
		break;
		
		case 'date' :
			$terms = get_the_meta_list( $post_id , 'date' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Date inconnue', 'biyametre' );
		break;
		/*
		case 'author' :
			echo get_post_meta( $post_id , 'author' , true ); 
			break;
		*/
	}
}

add_filter( 'manage_action_posts_columns', 'set_custom_edit_actions_columns' );
add_action( 'manage_action_posts_custom_column' , 'custom_actions_column', 10, 2 );

##################################################################################################### Custom columns

function set_custom_docs_columns($columns) {
	/* Désactivation de certaines colonnes qui ne seront pas utilisées */
	unset( $columns['date'] );
	$columns['title'] = __( 'Document', 'biyametre' ); // (La colonne Title est remplacée par Action
	$columns['document'] = __( 'Fichier', 'biyametre' );
	// $columns['progression'] = __( 'Progression', 'biyametre' );
	// $columns['statut'] 	= __( 'Statut', 'biyametre' );
	$columns['date'] 	= __( 'Date', 'biyametre' );
	
	return $columns;
}

function custom_docs_column( $column, $post_id ) {
	/* Les contenus personnalisés sont associés aux colonnes créées plus haut */
	
	switch ( $column ) {
		/*
		case 'promesse' :
			
			$the_meta = get_post_meta( $post_id );
			$promesse_id = $the_meta['prefix-promesse'][0];
			$promesse = get_post( $promesse_id );

			if ( is_string( $promesse->post_title ) )
				echo $promesse->post_title;
			else
				_e( 'Promesse introuvable', 'biyametre' );
		break;
		case 'progression' :
			$terms = get_the_term_list( $post_id , 'progression' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Progression inconnue', 'biyametre' );
		break;
		*/
		
		case 'document' :
			$the_meta = get_post_meta( $post_id );
			
			// var_dump($the_meta);
			
			$promesse_id = $the_meta['biyametre-file_advanced_3'][0];
			$promesse = get_post( $promesse_id );

			if ( is_string( $promesse->post_title ) )
				echo $promesse->post_title;
			else
				_e( 'Document introuvable', 'biyametre' );
		break;
		/*
		case 'author' :
			echo get_post_meta( $post_id , 'author' , true ); 
			break;
		*/
	}
}

add_filter( 'manage_document_posts_columns', 'set_custom_docs_columns' );
add_action( 'manage_document_posts_custom_column' , 'custom_docs_column', 10, 2 );
