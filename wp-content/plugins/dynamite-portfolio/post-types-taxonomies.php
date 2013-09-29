<?php
/* Dynamite - Post Types and Taxonomies */

/* Testimonials */
add_action( 'init', 'create_post_types' );
function create_post_types() {
	register_post_type( 'testimonial',
		array(
			'labels' 		=> array(
								'name' => __( 'Testimonials' ),
								'singular_name' => __( 'Testimonial' )
							),
			'public' 		=> true,
			'has_archive' 	=> true,
			'supports' 		=> array ( 'title', 'thumbnail', 'editor', 'tag' ),
			'taxonomies' 	=> array('category', 'post_tag')
		)
);

	/** Project Spotlight **/

	register_post_type( 'agd_project',
		array(
			'label' => 'Project',
			'public' => true,
			'has_archive' => true
		)
	);

	/** Team Members **/

	register_post_type( 'team',
		array(
			'label' => 'Member',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);
}

add_action( 'save_post', 'save_meta' );
function save_meta($post_id) {
	if(isset($_POST['client_position']))
	update_post_meta($post_id, 'client_position', $_POST['client_position']);

	if(isset($_POST['professional_position']))
	update_post_meta($post_id, 'professional_position', $_POST['professional_position']);

}


function showClientInfoBox($post) {		
 	$position = get_post_meta($post->ID, 'client_position', true);	
 ?>
 		<ul>
 			<li>
 				<label for="client_position">Position Title</label>
 				<input type="text" id="client_position" class="widefat" name="client_position" value="">
			</li>
		</ul>
 <?php
}

function showTeamInfoBox($post) {		
 	$prof_position = get_post_meta($post->ID, 'professional_position', true);	
 ?>
 		<ul>
 			<li>
 				<label for="professional_position">Position Title</label>
 				<input type="text" id="professional_position" class="widefat" name="professional_position" value="<?php echo $prof_position; ?>">
			</li>
		</ul>
 <?php
}


add_action( 'add_meta_boxes', 'addMetaBoxes' );
function addMetaBoxes(){
	add_meta_box('meta_box', 'Client Information', 'showClientInfoBox', 'testimonial');
	add_meta_box('meta_box', 'Team Information', 'showTeamInfoBox', 'team');
}

add_action( 'init', 'create_team_tax' );
function create_team_tax() {
	register_taxonomy(
		'expertise',
		'team',
		array(
			'label' => __( 'Expertise' ),
			'rewrite' => array( 'slug' => 'expertise' ),
			'hierarchical' => true,
		)
	);
}

?>
