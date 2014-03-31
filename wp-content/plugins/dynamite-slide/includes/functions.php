<?php //Slider Block 

function getSlideshow($post_type=null){
global $post;
/* Featured Content Area */
$fArgs = array(
		"post_type" 		=> ( $post_type ? $post_type : 'dynamite-slide' ) ,
		"posts_per_page"	=>	'-1'
	);

$slides = new WP_Query( $fArgs );
?>
<div class='featured-content dynamite-slide'>
	<div class='dynamite-slider'>
		<button class='prev paging'></button>
		<div class='dynamite-slide-window'>
			<ul class="dynamite-slide-container">
<?php
				if ( $slides->have_posts() ) : while ( $slides->have_posts() ) : $slides->the_post();
				// Get Slide Type 
				$slide_type = get_post_meta($post->ID, 'slide_type', true);
				getSlide($slide_type);
?>
<?php
				endwhile; endif;
?>
			</ul>
		</div>
		<button class='next paging'></button>
	</div>
</div> 

<?php
}

function getSlide($slide_type){
	$dir = plugin_dir_path( __FILE__ ).'/slide-type-blocks/' . $slide_type. '.php';
	include($dir);
}
?>