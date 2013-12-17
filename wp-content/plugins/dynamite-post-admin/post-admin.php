<?php
/* 
	Plugin Name: Dynamite Post Admin
	Description: Custom Post Types, Fields, Metaboxes, and all other Post Related components 
	Version: 0.1
	Author: ~== Damon Hastings ==~
*/

/* Metaboxes */
// Add Save Function to Custom Meta Fields
add_action( 'save_post', 'saveMeta' );
function saveMeta($post_id) {
	if(isset($_POST['id_iframe_src']))
		update_post_meta($post_id, 'id_iframe_src', $_POST['id_iframe_src']);

	if(isset($_POST['id_iframe_height']))
	update_post_meta($post_id, 'id_iframe_height', $_POST['id_iframe_height']);
}

// Add Meta Input Boxes to post admin area
add_action( 'add_meta_boxes', 'addInputBoxes' );
function addInputBoxes(){
	add_meta_box('meta_box', 'iFrame Source', 'iFrameSourceMeta', 'page');
} 

/* iFrameSource Meta Input Box - added to post admin for posts use an iFrame template */
function iFrameSourceMeta($post){
	$iframeSrc = get_post_meta($post->ID,'id_iframe_src', true);
	$iframeHeight = get_post_meta($post->ID,'id_iframe_height', true);
?>
	<div class="iframe-src">
		<label for="id_iframe_src">iFrame Source Link</label>
		<input type="text" id="id_iframe_src" class="widefat" name="id_iframe_src" value="<?php echo esc_attr($iframeSrc); ?>">
	</div>

	<div class="iframe-height">
		<label for="id_iframe_height">iFrame Height</label>
		<input type="text" id="id_iframe_height" class="widefat" name="id_iframe_height" value="<?php echo esc_attr($iframeHeight); ?>">
	</div>
<?php
}

