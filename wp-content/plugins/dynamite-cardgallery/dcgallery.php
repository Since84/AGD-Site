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

	echo $id;

	die(); // this is required to return a proper result
}