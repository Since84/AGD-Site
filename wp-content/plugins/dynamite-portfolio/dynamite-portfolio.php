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

	wp_register_style( 'smoothscrollcss', plugins_url( 'dynamite-portfolio/js/smooth-div-scroll/css/smoothDivScroll.css') );	

	wp_enqueue_style( 'news-font' );
	wp_enqueue_style( 'smoothscrollcss' );
	wp_enqueue_style( 'dscreen' );
	wp_enqueue_style( 'dprint' );

	/* scripts */
	// wp_register_script( 'isotope', plugins_url( 'dynamite-portfolio/js/isotope/jquery.isotope.min.js'), array('jquery') );
	
	wp_register_script( 'cycle', plugins_url( 'dynamite-portfolio/js/jquery.cycle2.min.js'), array('jquery') );
	wp_register_script( 'cycle-swipe', plugins_url( 'dynamite-portfolio/js/jquery.cycle2.swipe.min.js'), array('jquery', 'cycle') );
	wp_register_script( 'cycle-iOSfix', plugins_url( 'dynamite-portfolio/js/ios6fix.js'), array('jquery', 'cycle', 'cycle-swipe') );
	wp_register_script( 'imagesloaded', plugins_url( 'dynamite-portfolio/js/imagesloaded-master/imagesloaded.pkgd.min.js'), array('jquery'));
	wp_register_script( 'main', plugins_url( 'dynamite-portfolio/js/script.js'), array('jquery', 'jqueryui', 'imagesloaded') );

	wp_register_script( 'kinetic', plugins_url( 'dynamite-portfolio/js/smooth-div-scroll/jquery.kinetic.min.js' ), array('jqueryui') );
	wp_register_script( 'mousewheel', plugins_url( 'dynamite-portfolio/js/smooth-div-scroll/jquery.mousewheel.min.js' ), array('jqueryui') );
	wp_register_script( 'smoothscroll', plugins_url( 'dynamite-portfolio/js/smooth-div-scroll/jquery.smoothdivscroll-1.3-min.js' ), array('jqueryui') );


	// wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'cycle' );
	wp_enqueue_script( 'cycle-swipe' );
	wp_enqueue_script( 'cycle-iOSfix' );
	wp_enqueue_script( 'kinetic' );
	wp_enqueue_script( 'mousewheel' );
	wp_enqueue_script( 'smoothscroll' );
	wp_enqueue_script( 'imagesloaded' );

	wp_enqueue_script( 'main' );

}
add_action( 'wp_enqueue_scripts', 'register_styles_scripts' );


/* post types */
include('post-types-taxonomies.php');

/* menus and widgets */ 
include('menus-widgets.php');

/* folio company settings */
include('company-info.php');

/* images */
include('images.php');

// /* functions */
include('functions.php');

// /* THE WIDGET */
include('dfolio.php');
?>