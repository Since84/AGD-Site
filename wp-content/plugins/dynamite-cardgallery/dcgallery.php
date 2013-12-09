<?php
/*
*
	Plugin Name: Dynamite - Card Gallery
*
*/

add_action('init','enqueueScripts');
function enqueueScripts(){
	wp_enqueue_script('isotope', plugins_url('/dynamite-cardgallery/js/isotope/jquery.isotope.min.js', dirname(__FILE__)),array('jquery'));
	wp_enqueue_script('jqueryui', plugins_url('/dynamite-cardgallery/js/jquery-ui-1.10.3.custom.min.js', dirname(__FILE__)),array('jquery'));
	wp_enqueue_script('cardgallery', plugins_url('/dynamite-cardgallery/js/dynamite.cardgallery.js', dirname(__FILE__)),array('jquery'));

	wp_enqueue_style( 'galleryMain',plugins_url( '/dynamite-cardgallery/stylesheets/screen.css', dirname(__FILE__) ) );

}

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

add_action('wp_ajax_member_bio', 'get_member_bio');
add_action('wp_ajax_nopriv_member_bio', 'get_member_bio');
function get_member_bio() {
	global $wpdb; // this is how you get access to the database

	$id = $_POST['memberId'] ;

	$member = get_post($id);

	$memberPosition = get_post_meta( $id, 'professional_position', true );
	$memberFacebook = get_post_meta( $id, 'member_facebook', true );
	$memberLinkedin = get_post_meta( $id, 'member_linkedin', true );
	$memberTwitter = get_post_meta( $id, 'member_twitter', true );
	$memberBehance = get_post_meta( $id, 'member_behance', true );
	$memberDribbble = get_post_meta( $id, 'member_dribbble', true );

	$memberSocialBlock 	= "<ul class='member-social'>";
	$memberSocialBlock .= 	( $memberFacebook ) ? "<li class='member-facebook'><a href='//www.facebook.com/".$memberFacebook."'></a></li>" : "" ;
	$memberSocialBlock .= 	( $memberLinkedin ) ? "<li class='member-linkedin'><a href='//www.linkedin.com/in/".$memberLinkedin."'></a></li>" : "" ;
	$memberSocialBlock .= 	( $memberTwitter ) ? "<li class='member-twitter'><a href='//www.twitter.com/".$memberTwitter."'></a></li>" : "" ;
	$memberSocialBlock .= 	( $memberBehance ) ? "<li class='member-behance'><a href='//www.behance.com/".$memberBehance."'></a></li>" : "" ;
	$memberSocialBlock .= 	( $memberDribbble ) ? "<li class='member-dribbble'><a href='//www.dribbble.com/".$memberDribbble."'></a></li>" : "" ;
	$memberSocialBlock .= "</ul>";

	$memberExpertise = get_the_terms( $id, 'expertise' );
	$memberExpertiseBlock  = "<ul class='member-expertise'>";
	$memberExpertiseBlock .= "	<h2>Expertise</h2>";
	foreach ( $memberExpertise as $expertise ) {
		$memberExpertiseBlock .= "<li>".$expertise->name."</li>";
	}
	$memberExpertiseBlock .= "</ul>";


	$block  = "<div class='close'></div>";
	$block .= "<div class='column one-third'>";
	$block .= 	"<h1 class='member-name'>".$member->post_title."</h1>";
	$block .=	"<h2 class='member-position'>".$memberPosition."</h2>";
	$block .=	$memberSocialBlock;
	$block .=	$memberExpertiseBlock;
	$block .= "</div>";
	$block .= "<div class='column two-third'>";
	$block .= 	"<div class='member-bio'>".apply_filters( 'the_content', $member->post_content )."</div>";
	$block .= "</div>";

	echo $block;

	die(); // this is required to return a proper result
}



add_action('wp_ajax_project_profile', 'get_project_profile');
add_action('wp_ajax_nopriv_project_profile', 'get_project_profile');
function get_project_profile() {
	global $wpdb; // this is how you get access to the database

	$id = $_POST['projectId'] ;

	$project = get_post($id);

	$projectType = wp_get_post_terms( $project->ID, 'project-type' );
	
	$projectBlock = "";
	$p = 0;
	foreach ( $projectType as $type ) {
		$projectBlock .= ( $p == 0  ) ? '' : ', ';
		$projectBlock .= $type->name;
		$p++;
	}

	/* PROJECT IMAGES */
	$features = dynamite_get_project_features($project->ID);

	$featureBlock  = "<div 	class='cycle-slideshow' 
    						data-cycle-fx=scrollHorz
    						data-cycle-swipe=true
    						data-cycle-timeout=5000
    						data-cycle-pager='.feature-pager'
    				 >";
    				
	foreach ($features as $feature => $image) {
		$featureBlock .= $image;
	}

	$featureBlock .= "</div>";

	/* PROJECT SERVICES */
	$services = wp_get_post_terms( $project->ID, 'services' );

	$serviceBlock  = "<ul class='project-services'>";
	$serviceBlock .=	"<h2>Services</h2>";
	foreach ( $services as $service ) {
		$serviceBlock .= "<li class='project-service'>".$service->name."</li>";
	}
	$serviceBlock .= "</ul>";

	$block  = "<div class='close'></div>";
	$block .= "<div class='feature-wide'>";
	$block .= 	"<div class='project-feature'>".$featureBlock."</div>";
	$block .= "</div>";
	$block .= "<div class='feature-side'>";
	$block .= 	"<div class='feature-pager'></div>";
	$block .= 	"<h1 class='project-name'>".$project->post_title."</h1>";
	// $block .=	"<h2 class='project-type'>".$projectBlock."</h2>";
	$block .= 	"<div class='project-profile'>".$project->post_content."</div>";
	$block .=   $serviceBlock;
	$block .= "</div>";

	echo $block;

	die(); // this is required to return a proper result
}