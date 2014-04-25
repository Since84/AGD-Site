<?php 
/*
	Plugin Name: Mobile Menu (Sidr) 
*/
	function sidr_enqueue(){
		wp_enqueue_script( 'sidr', plugins_url( 'dist/jquery.sidr.js', __FILE__ ), array('jquery') );
		wp_enqueue_style( 'sidrstyle', plugins_url( 'dist/stylesheets/jquery.sidr.light.css', __FILE__ ) );
	}
	add_action('wp_enqueue_scripts', 'sidr_enqueue');
 