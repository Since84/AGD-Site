<?php
/* Dynamite - Post Images */
	
add_action( 'init', 'add_post_thumbs' );

function add_post_thumbs(){
	if (class_exists('MultiPostThumbnails')) {

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 2',
					'id' => 'feature_2',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 3',
					'id' => 'feature_3',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 4',
					'id' => 'feature_4',
					'post_type' => 'project'
				)	
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 5',
					'id' => 'feature_5',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 6',
					'id' => 'feature_6',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 7',
					'id' => 'feature_7',
					'post_type' => 'project'
				)	
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 8',
					'id' => 'feature_8',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 9',
					'id' => 'feature_9',
					'post_type' => 'project'
				)
			);

		new MultiPostThumbnails(
				array(
					'label' => 'Feature 10',
					'id' => 'feature_10',
					'post_type' => 'project'
				)	
			);


		new MultiPostThumbnails(
				array(
					'label' => 'Thumb',
					'id' => 'project_thumbnail',
					'post_type' => 'project'
				) 
			);	
	}	
}

function dynamite_get_project_features( $postID ){
	$imageArray = Array( 'feature_2', 'feature_3', 'feature_4', 'feature_5', 'feature_6', 'feature_7','feature_8', 'feature_9','feature_10' );

	if ( has_post_thumbnail( $postID ) ) : 

		$projectImages['feature_1'] = get_the_post_thumbnail( $postID );

	endif; 

	foreach ($imageArray as $image ) {

		if ( class_exists('MultiPostThumbnails')
        	 && MultiPostThumbnails::has_post_thumbnail( 'project', $image, $postID ) ) :

        	$feature = MultiPostThumbnails::get_the_post_thumbnail( 'project', $image, $postID );
        	$projectImages[$image] = $feature;

        endif;

	}

	return $projectImages;

}









