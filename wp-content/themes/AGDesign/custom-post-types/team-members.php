<?php
/** Team Members **/

	register_post_type( 'agd_team',
		array(
			'labels' => array(
				'name' => __( 'Team Members' ),
				'singular_name' => __( 'Member' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'member'),
		)
	);