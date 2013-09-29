<?php
/*
*
	Plugin Name: Dynamite - Card Gallery
*
*/

function enqueueScripts(){
	wp_enqueue_script('isotope', plugins_url('/dynamite-cardgallery/js/isotope/jquery.isotope.min.js', dirname(__FILE__)),array('jquery'));
	wp_enqueue_script('jqueryui', plugins_url('/dynamite-cardgallery/js/jquery-ui-1.10.3.custom.min.js', dirname(__FILE__)),array('jquery'));
	wp_enqueue_script('cardgallery', plugins_url('/dynamite-cardgallery/js/dynamite.cardgallery.js', dirname(__FILE__)),array('jquery'));

	wp_enqueue_style( 'galleryMain',plugins_url( '/dynamite-cardgallery/stylesheets/screen.css', dirname(__FILE__) ) );

}


add_action('init','enqueueScripts');