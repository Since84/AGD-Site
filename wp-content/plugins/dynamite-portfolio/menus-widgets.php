<?php
/* Dynamite Portfolio - Menus and Widgets */

$menus = array(
	'main'		=> 'Main Nav',
	'footer-1' 	=> 'Footer Links Column 1',
	'footer-2' 	=> 'Footer Links Column 2',
	'footer-3' 	=> 'Footer Links Column 3',
	'footer-4' 	=> 'Footer Links Column 4'
);

register_nav_menus( $menus );


$socialLinks = array(
	'name'          => __( 'Social Links' ),
	'id'            => 'social-links',
	'description'   => 'Social Icons in Footer',
    'class'         => '',
	'before_widget' => '',
	'after_widget'  => ''
); 

register_sidebar( $socialLinks );


?>