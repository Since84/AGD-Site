<?php 
	/* Dynamite Functions */

	function content_block($page_title){
		$page = get_page_by_title( $page_title );
		
		// echo "<pre>";
		// var_export($page);
		// echo "</pre>";
?>
		<h1><?php echo $page->post_title; ?></h1>
		<p><?php echo $page->post_content; ?></p>
<?php
	}

	function new_excerpt_more( $more ) {
		echo ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'.$more.'</a>';
	}

	function get_custom_terms($taxonomies, $args){
		$args = array('orderby'=>'asc','hide_empty'=>true);
		$custom_terms = get_terms(array('post-type'), $args);
		var_dump($custom_terms);
		foreach($custom_terms as $term){
		    //echo 'Term slug: ' . $term->slug . ' Term Name: ' . $term->name;
		}
	}

	//add pid to query vars
	function add_pid_query_var() {
	    global $wp;
	    $wp->add_query_var('pid');
	}

	add_filter('init', 'add_pid_query_var');

?>