<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	function myplugin_settings() {  
	// Add tag metabox to page
	register_taxonomy_for_object_type('post_tag', 'page'); 
	// Add category metabox to page
	register_taxonomy_for_object_type('category', 'page');  
	}
	 // Add to the admin_init hook of your theme functions.php file 
	add_action( 'admin_init', 'myplugin_settings' );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */
	

	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {

		wp_register_script( 'jqueryui', get_template_directory_uri().'/js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jqueryui' );

		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery', 'jqueryui' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'base', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'base' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/styles/stylesheets/screen.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );

        wp_register_style( 'responsive', get_stylesheet_directory_uri().'/styles/stylesheets/responsive.css', '', '' );
        wp_enqueue_style( 'responsive' );

        wp_register_style( 'mobile', get_stylesheet_directory_uri().'/styles/stylesheets/mobile.css', '', '' );
        wp_enqueue_style( 'mobile' );

		wp_register_style( 'print', get_stylesheet_directory_uri().'/styles/stylesheets/screen.css', '', '', 'print' );
        wp_enqueue_style( 'print' );


	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}


	add_action('after_setup_theme', 'remove_admin_bar');

	function remove_admin_bar() {
		// if (!current_user_can('administrator') && !is_admin()) {
		  show_admin_bar(false);
		// }
	}