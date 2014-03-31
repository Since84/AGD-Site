<?php

/*
	Plugin Name: Dynamite Slide
	Description: Media Slider for multiple types of Media including video/text/images/etc.
	Author: *~==
	Version: 0.1
*/

	
	function dynamite_enqueue_scripts(){
	// Scripts
		wp_enqueue_script( 'jquery_widget', plugins_url( 'js/jquery-ui-1.10.4.custom.min.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'imagesloaded', plugins_url( 'js/imagesloaded-master/imagesloaded.pkgd.min.js', __FILE__ ), array('jquery'));
		wp_enqueue_script( 'dynamite_slide_widget', plugins_url( 'js/dynamite-slide.js', __FILE__ ), array('jquery', 'jquery_widget', 'imagesloaded'));
	
	// Styles
		wp_enqueue_style( 'dynamite_slide_screen', plugins_url( 'styles/stylesheets/screen.css', __FILE__ ) );

	}
	add_action( 'wp_enqueue_scripts', 'dynamite_enqueue_scripts' );


	// HTML Block for Slider
	require_once('includes/functions.php');

	// Post Types, Taxonomies and Meta
	require_once('includes/custom-content.php');

?>