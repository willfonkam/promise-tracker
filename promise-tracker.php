<?php
/**
* Plugin Name: Promise tracker
* Description: This plugin allows you to add new promises and to use the different tools provided to track and evaluate them following a system of annotation that goes from 'Realized' to 'Failed' through 'Ongoing'
* Author: Mboa Coders
* Version: 1.0
*/

if( !defined( 'ABSPATH' ) ) die( 'Restricted Area' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/cpt-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/cpt-columns-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/cpt-metaboxes-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/stats-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/taxonomy-functions.php' );
