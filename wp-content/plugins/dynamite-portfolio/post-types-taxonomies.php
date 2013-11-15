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

	/** Home Page Features **/

	register_post_type( 'feature',
		array(
			'label' => 'Feature',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor', 'excerpt')
		)
	);

	/** Project Spotlight **/

	register_post_type( 'project',
		array(
			'label' => 'Project',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor', 'excerpt')
		)
	);

	/** Team Members **/

	register_post_type( 'team',
		array(
			'label' 		=> 'Member',
			'public' 		=> true,
			'rewrite'       => array( 'slug' => 'our-team' ),
			'has_archive' 	=> true,
			'supports' 		=> array('title', 'thumbnail', 'editor')
		)
	);
}

add_action( 'save_post', 'save_meta' );
function save_meta($post_id) {

	if(isset($_POST['address1']))
	update_post_meta($post_id, 'address1', $_POST['address1']);

	if(isset($_POST['headline']))
	update_post_meta($post_id, 'headline', $_POST['headline']);

	if(isset($_POST['client_position']))
	update_post_meta($post_id, 'client_position', $_POST['client_position']);

	if(isset($_POST['professional_position']))
	update_post_meta($post_id, 'professional_position', $_POST['professional_position']);

	if(isset($_POST['member_facebook']))
	update_post_meta($post_id, 'member_facebook', $_POST['member_facebook']);

	if(isset($_POST['member_linkedin']))
	update_post_meta($post_id, 'member_linkedin', $_POST['member_linkedin']);

	if(isset($_POST['member_twitter']))
	update_post_meta($post_id, 'member_twitter', $_POST['member_twitter']);

	if(isset($_POST['member_behance']))
	update_post_meta($post_id, 'member_behance', $_POST['member_behance']);

	if(isset($_POST['member_dribbble']))
	update_post_meta($post_id, 'member_dribbble', $_POST['member_dribbble']);

	if(isset($_POST['feature_link']))
	update_post_meta($post_id, 'feature_link', $_POST['feature_link']);

}
// add_action('init', 'addSettingsFields');

// function addSettingsFields(){
// 	add_settings_field( 'address-one', 'Address 1', 'getAddressOneField', 'general' );
// 	// add_settings_field( 'address_one', 'Address 1', 'getAddress1Field', 'manage_options' );
// }

function getAddressOneField (){
 	$address1 = get_post_meta($post->ID, 'address_one', true);	
 ?>
 		<ul>
 			<li>
 				<label for="address_one">Address 1</label>
 				<input type="text" id="address_one" class="widefat" name="address_one" value="<?php echo ( $address1 ? $address1 : '');?>">
			</li>
		</ul>
 <?php	
}

function showHeadlineBox($post) {		
 	$headline = get_post_meta($post->ID, 'headline', true);	
 ?>
 		<ul>
 			<li>
 				<label for="headline">Headline</label>
 				<input type="text" id="headline" class="widefat" name="headline" value="<?php echo ( $headline ? $headline : '');?>">
			</li>
		</ul>
 <?php
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

function showFeatureLinkBox($post) {		
 	$link = get_post_meta($post->ID, 'feature_link', true);	
 ?>
	<ul>
		<li>
			<label for="feature_link">Link To:</label>
			<input type="text" id="feature_link" class="widefat" name="feature_link" value="<?php echo ( $link ? $link : 'http://');?>">
		</li>
	</ul>
 <?php
}

function showTeamInfoBox($post) {		
 	$prof_position = get_post_meta($post->ID, 'professional_position', true);
 	$member_facebook = get_post_meta($post->ID, 'member_facebook', true);
 	$member_linkedin = get_post_meta($post->ID, 'member_linkedin', true);
 	$member_twitter = get_post_meta($post->ID, 'member_twitter', true);
 	$member_behance = get_post_meta($post->ID, 'member_behance', true);	
 	$member_dribbble = get_post_meta($post->ID, 'member_dribbble', true);

 ?>
 		<ul>
 			<li>
 				<label for="professional_position">Position Title</label>
 				<input type="text" id="professional_position" class="widefat" name="professional_position" value="<?php echo $prof_position; ?>" />
			</li>
			<li>
				<label for="member_facebook">Facebook</label>
				<input type="text" id="member_facebook" class="widefat" name="member_facebook" value="<?php echo $member_facebook; ?>"/>
			</li>
			<li>
				<label for="member_linkedin">LinkedIn</label>
				<input type="text" id="member_linkedin" class="widefat" name="member_linkedin" value="<?php echo $member_linkedin; ?>"/>
			</li>
			<li>
				<label for="member_twitter">Twitter</label>
				<input type="text" id="member_twitter" class="widefat" name="member_twitter" value="<?php echo $member_twitter; ?>"/>
			</li>
			<li>
				<label for="member_behance">Behance</label>
				<input type="text" id="member_behance" class="widefat" name="member_behance" value="<?php echo $member_behance; ?>"/>
			</li>
			<li>
				<label for="member_dribbble">Dribbble</label>
				<input type="text" id="member_dribbble" class="widefat" name="member_dribbble" value="<?php echo $member_dribbble; ?>"/>
			</li>
		</ul>
 <?php
}


add_action( 'add_meta_boxes', 'addMetaBoxes' );
function addMetaBoxes(){
	add_meta_box('meta_box', 'Client Information', 'showClientInfoBox', 'testimonial');
	add_meta_box('meta_box', 'Team Information', 'showTeamInfoBox', 'team');
	add_meta_box('meta_box', 'Headline', 'showHeadlineBox', 'page');
	add_meta_box('meta_box', 'Feature Link', 'showFeatureLinkBox', 'feature');
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

add_action( 'init', 'create_proj_tax' );
function create_proj_tax() {
	register_taxonomy(
		'project-type',
		'project',
		array(
			'label' => __( 'Project Type' ),
			'rewrite' => array( 'slug' => 'project-type' ),
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'services',
		'project',
		array(
			'label' => __( 'Services' ),
			'rewrite' => array( 'slug' => 'services' ),
			'hierarchical' => true,
		)
	);
}

?>
