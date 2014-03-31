<?php //Custom Content 

add_action( 'init', 'createPostTypes' );
function createPostTypes() {

	//Dynamite Slide Post Type
	register_post_type( 'dynamite-slide',
		array(
			'labels' 		=> array(
								'name' => __( 'Slides' ),
								'singular_name' => __( 'Slide' )
							),
			'public' 		=> true,
			'has_archive' 	=> true,
			'supports' 		=> array ( 'title', 'thumbnail', 'editor', 'tag' ),
			'taxonomies' 	=> array('category', 'post_tag')
		)
	);
}

add_action( 'save_post', 'DMYTsaveMeta' );
function DMYTsaveMeta($post_id) {

	if(isset($_POST['slide_type']))
	update_post_meta($post_id, 'slide_type', $_POST['slide_type']);

	if(isset($_POST['slide_link']))
	update_post_meta($post_id, 'slide_link', $_POST['slide_link']);

	if(isset($_POST['video_slug']))
	update_post_meta($post_id, 'video_slug', $_POST['video_slug']);
}

add_action( 'add_meta_boxes', 'DMYTaddMetaBoxes' );
function DMYTaddMetaBoxes(){
	add_meta_box('meta_box', 'DMYT - Fields', 'getCustomFields', 'dynamite-slide');
}

function getCustomFields (){
	global $post;
	$slide_type = get_post_meta($post->ID, 'slide_type', true);	
 	$slide_link = get_post_meta($post->ID, 'slide_link', true);	
 	$video_slug = get_post_meta($post->ID, 'video_slug', true);	
?>
  		<ul>
  			<li>
				<label for="slide_type">Slide Type</label>
				<select name="slide_type" id="slide_type">
					<option value="image">Image</option>
					<option value="video"<?php if($slide_type == 'video') echo 'selected' ?>>Video</option>
					<option value="projects"<?php if($slide_type == 'projects') echo 'selected' ?>>Projects</option>
				</select>
 			</li>
  			<li>
  				<label for="slide_link">Slide Link</label>
  				<input type="text" id="slide_link" class="widefat" name="slide_link" value="<?php echo ( $slide_link ? $slide_link : '');?>">
 			</li>
   			<li>
  				<label for="video_slug">Video Slug</label>
  				<input type="text" id="video_slug" class="widefat" name="video_slug" value="<?php echo ( $video_slug ? $video_slug : '');?>">
 			</li>
 		</ul>
  <?php	
}

