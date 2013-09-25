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

?>