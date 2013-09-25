<?php
/** Project Spotlight **/

	register_post_type( 'agd_project',
		array(
			'labels' => array(
				'name' => __( 'Our Projects' ),
				'singular_name' => __( 'Project' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'project'),
		)
	);