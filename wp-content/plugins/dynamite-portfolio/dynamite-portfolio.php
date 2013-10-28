<?php 
/*
*
*	Plugin Name: 	Dynamite Portfolio 1.0
*	Author: 		Damon Hastings
*	Version:		1.0
*
*/

function register_styles_scripts(){
	/* styles */
	wp_register_style( 'news-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' );
	wp_register_style( 'dscreen', plugins_url( 'dynamite-portfolio/styles/stylesheets/screen.css') );
	wp_register_style( 'dprint', plugins_url( 'dynamite-portfolio/styles/stylesheets/print.css') );

	wp_enqueue_style( 'news-font' );
	wp_enqueue_style( 'dscreen' );
	wp_enqueue_style( 'dprint' );

	/* scripts */
	// wp_register_script( 'isotope', plugins_url( 'dynamite-portfolio/js/isotope/jquery.isotope.min.js'), array('jquery') );
	
	wp_register_script( 'main', plugins_url( 'dynamite-portfolio/js/script.js'), array('jquery', 'jqueryui') );

	// wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'main' );

}
add_action( 'wp_enqueue_scripts', 'register_styles_scripts' );


/* post types */
include('post-types-taxonomies.php');

/* menus and widgets */ 
include('menus-widgets.php');

/* folio company settings */
include('company-info.php');

// /* functions */
include('functions.php');

// /* THE WIDGET */
include('dfolio.php');
?>