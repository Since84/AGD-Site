<?php 
/*
*
*	Plugin Name: 	Dynamite Portfolio 1.0
*	Author: 		Damon Hastings
*	Version:		1.0
*
*/

/* styles */
wp_enqueue_style( 'news-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700', $media = 'all' );
wp_enqueue_style( 'dscreen', plugins_url( 'dynamite-portfolio/styles/stylesheets/screen.css'), $media = 'screen' );
wp_enqueue_style( 'dprint', plugins_url( 'dynamite-portfolio/styles/stylesheets/print.css'), $media = 'print' );

/* scripts */
wp_enqueue_script( 'main', plugins_url( 'dynamite-portfolio/js/script.js'), array('jquery'), false , true );

/* post types */
include('post-types-taxonomies.php');

/* menus and widgets */ 
include('menus-widgets.php');

/* functions */
include('functions.php');

?>