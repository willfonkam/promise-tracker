<?php
#########################################################
#                 	PROMESSES			#
#########################################################
function create_promesse_cpts() {
	$labels = array(
        'name'                  => _x( 'Promesses', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Promesse', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Promesses', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Promesse', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Ajouter', 'textdomain' ),
        'add_new_item'          => __( 'Nouvelle promesse', 'textdomain' ),
        'new_item'              => __( 'Nouvelle promesse', 'textdomain' ),
        'edit_item'             => __( 'Modifier la promesse', 'textdomain' ),
        'view_item'             => __( 'Voir la promesse', 'textdomain' ),
        'all_items'             => __( 'Toutes les promesses', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'promesse' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        // 'show_in_rest'       => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'menu_icon' 	     => 'dashicons-megaphone',
        'supports'           => array( 'title', 'excerpt' ),
	);
	
	register_post_type('promesse', $args);
	
	$labels_sources = array(
        'name'              => _x( 'Sources', 'biyametre' ),
        'singular_name'     => _x( 'Source', 'biyametre' ),
        'search_items'      => __( 'Rechercher dans les sources', 'biyametre' ),
        'all_items'         => __( 'Toutes les sources', 'biyametre' ),
        'parent_item'       => __( 'Source parente', 'biyametre' ),
        'parent_item_colon' => __( 'Source parente' , 'biyametre' ),
        'edit_item'         => __( 'Modifier la source', 'biyametre' ),
        'update_item'       => __( 'Mettre à jour', 'biyametre' ),
        'add_new_item'      => __( 'Ajouter une source', 'biyametre' ),
        'new_item_name'     => __( 'Nouvelle source', 'biyametre' ),
        'menu_name'         => __( 'Sources', 'biyametre' ),
    );
	
	register_taxonomy(
		'sources',
		'promesse',
		array(
			'labels' 		=> $labels_sources,
			'hierarchical'	=> true,
			'show_in_rest' 	=> true,
			'show_ui'		=> true,
		)
	);
	
	$labels_domaine = array(
        'name'              => _x( 'Domaines d\'action', 'biyametre' ),
        'singular_name'     => _x( 'Domaine d\'action', 'biyametre' ),
        'search_items'      => __( 'Rechercher dans les domaines d\'action', 'biyametre' ),
        'all_items'         => __( 'Tous les domaines d\'action', 'biyametre' ),
        'parent_item'       => __( 'Domaine d\'action parent', 'biyametre' ),
        'parent_item_colon' => __( 'Domaines d\'action parent' , 'biyametre' ),
        'edit_item'         => __( 'Modifier le domaine d\'action', 'biyametre' ),
        'update_item'       => __( 'Mettre à jour', 'biyametre' ),
        'add_new_item'      => __( 'Ajouter un domaine d\'action', 'biyametre' ),
        'new_item_name'     => __( 'Nouveau domaine d\'action', 'biyametre' ),
        'menu_name'         => __( 'Domaines d\'action', 'biyametre' ),
    );
	
	register_taxonomy(
		'domaine_daction',
		'promesse',
		array(
			'labels' 			=> $labels_domaine,
			'hierarchical' 		=> true,
			'show_in_rest' 		=> true,
			// 'show_admin_column' => true,
			'query_var'         => true,
		)
	);
	
	register_taxonomy(
		'statut',
		'promesse',
		array(
			'hierarchical' => true,
			'label' => 'Statut',
			'show_in_rest' => true,
			// 'show_admin_column' => true,
			'query_var'         => true,
		)
	);
}

add_action('init', 'create_promesse_cpts');

#####################################################
#                 		ACTIONS						#
#####################################################

function create_actions_cpts() {
	$labels = array(
        'name'                  => _x( 'Actions', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Action', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Actions', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Action', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Ajouter', 'textdomain' ),
        'add_new_item'          => __( 'Nouvelle action', 'textdomain' ),
        'new_item'              => __( 'Nouvelle action', 'textdomain' ),
        'edit_item'             => __( 'Modifier l\'action', 'textdomain' ),
        'view_item'             => __( 'Voir l\'action', 'textdomain' ),
        'all_items'             => __( 'Toutes les actions', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'action' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'menu_icon' 	     => 'dashicons-image-filter',
        'supports'           => array( 'title', 'excerpt' ),
	);
	
	register_post_type('action', $args);
	
	register_taxonomy(
		'progression',
		'action',
		array(
			'hierarchical' => true,
			'label' => 'Progression',
			'show_in_rest' => true,
			// 'show_admin_column' => true,
		)
	);
}

add_action('init', 'create_actions_cpts');

#####################################################
#                 	DOCUMENTS						#
#####################################################

function create_document_cpts() {
	$labels = array(
        'name'                  => _x( 'Documents', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Document', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Documents', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Document', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Ajouter', 'textdomain' ),
        'add_new_item'          => __( 'Nouveau document', 'textdomain' ),
        'new_item'              => __( 'Nouveau document', 'textdomain' ),
        'edit_item'             => __( 'Modifier le document', 'textdomain' ),
        'view_item'             => __( 'Voir le document', 'textdomain' ),
        'all_items'             => __( 'Tous les documents', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'document' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'menu_icon' 	     => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor' ),
	);
	
	register_post_type('document', $args);
}

add_action('init', 'create_document_cpts');
