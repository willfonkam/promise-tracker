<?php
// META BOXES
function meta_boxes_promesses( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = array(
		'id' => 'dtailssupplmentaires',
		'title' => esc_html__( 'Informations requises', 'biyametre' ),
		'post_types' => array('promesse' ),
		'context' => 'after_title',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => $prefix . 'source',
				'type' => 'taxonomy',
				'name' => esc_html__( 'Sources', 'biyametre' ),
				'desc' => esc_html__( 'Sources desquelles sont extraites les promesses', 'biyametre' ),
				'placeholder' => esc_html__( 'Choisissez une source', 'biyametre' ),
				'taxonomy' => 'sources',
				'field_type' => 'select',
			),
			array(
				'id' => $prefix . 'domaine_action',
				'type' => 'taxonomy',
				'name' => esc_html__( 'Domaine d\'action', 'biyametre' ),
				'std' => 'Choisissez un domaine d\'action',
				'desc' => esc_html__( 'Domaine d\'action auquel se rattache la promesse', 'biyametre' ),
				'taxonomy' => 'domaine_daction',
				'field_type' => 'select_advanced',
			),
			array(
				'id' => $prefix . 'statut',
				'type' => 'taxonomy',
				'name' => esc_html__( 'Statut', 'biyametre' ),
				'desc' => esc_html__( 'Indiquez le statut actuel de la promesse', 'biyametre' ),
				'placeholder' => esc_html__( 'Indiquez le statut de la promesse', 'biyametre' ),
				'taxonomy' => 'statut',
				'field_type' => 'radio_list',
				'std' => 'En attente',
			),
			/*
			array(
				'id' => $prefix . 'details',
				'name' => esc_html__( 'Détails', 'biyametre' ),
				'type' => 'wysiwyg',
				'desc' => esc_html__( 'Détails supplémentaires', 'biyametre' ),
			),
			*/
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'meta_boxes_promesses' );

####################################################################

function meta_boxes_action( $meta_boxes ) {
	$prefix = 'prefix-';

	$meta_boxes[] = array(
		'id' => 'promesse',
		'title' => esc_html__( 'Détails', 'biyametre' ),
		'post_types' => array('action' ),
		'context' => 'after_title',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => $prefix . 'date',
				'type' => 'date',
				'name' => esc_html__( 'Date', 'biyametre' ),
				'desc' => esc_html__( 'Indiquez le date de l\'action', 'biyametre' ),
			),
			array(
				'id' => $prefix . 'promesse',
				'type' => 'post',
				'name' => esc_html__( 'Promesse', 'biyametre' ),
				'std' => 'Choisissez une promesse',
				'desc' => esc_html__( 'Promesse à laquelle se rattache l\'action', 'biyametre' ),
				'post_type' => 'promesse',
				'field_type' => 'select_advanced',
			),
			array(
				'id' => $prefix . 'progression',
				'type' => 'taxonomy',
				'name' => esc_html__( 'Progression', 'biyametre' ),
				'desc' => esc_html__( 'Indiquez la progression de la promesse', 'biyametre' ),
				'placeholder' => esc_html__( 'Indiquez la progression de la promesse', 'biyametre' ),
				'taxonomy' => 'progression',
				'field_type' => 'radio_list',
				'std' => 'En attente',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'meta_boxes_action' );

####################################################################

function meta_boxes_docs( $meta_boxes ) {
	$prefix = 'biyametre-';

	$meta_boxes[] = array(
		'id' => 'untitled',
		'title' => esc_html__( 'Ajouter un document', 'biyametre' ),
		'post_types' => array( 'document' ),
		'context' => 'after_title',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => $prefix . 'file_advanced_3',
				'type' => 'file_advanced',
				'name' => esc_html__( 'Document', 'biyametre' ),
				// 'max_file_uploads' => 1,
				'max_status' => 'false',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'meta_boxes_docs' );