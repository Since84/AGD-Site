<?php
/*
*
	Plugin Name: Dynamite - Card Gallery
*
*/

function enqueueScripts(){
	wp_enqueue_script('isotope', plugins_url('/dynamite-cardgallery/js/isotope/jquery.isotope.min.js', dirname(__FILE__)),array('jquery'));
}


add_action('init','enqueueScripts');