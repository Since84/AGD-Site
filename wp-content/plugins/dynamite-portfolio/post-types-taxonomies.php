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
}

add_action( 'save_post', 'save_testimonial' );

function save_testimonial($post_id) {
	if(isset($_POST['client_position']))
	update_post_meta($post_id, 'client_position', $_POST['client_position']);
}

function showClientInfoBox($post) {		
	$position = get_post_meta($post->ID, 'client_position', true);
		
?>
		<ul>
			<li>
				<label for="client_position">Position Title</label>
				<input type="text" id="client_position" class="widefat" name="client_position" value="<?php echo esc_attr($position); ?>">
			</li>
		</ul>
<?php
}
function addMetaBoxes(){
	add_meta_box('meta_box', 'Client Information', 'showClientInfoBox', 'testimonial');
}
add_action( 'add_meta_boxes', 'addMetaBoxes' )
?>
