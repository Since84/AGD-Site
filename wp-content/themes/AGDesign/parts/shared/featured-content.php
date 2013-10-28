<?php
/* Featured Content Area */
$fArgs = array(
		"post_type" 		=> "feature",
		"posts_per_page"	=>	10
	);

$features = new WP_Query( $fArgs );
?>
<div class='featured-content dGlider'>
	<div class='featured-slider'>
		<button class='prev paging'></button>
		<div class='featured-slide-window'>
			<ul class="featured-slide-container">
				<li class='featured-slide'>
					<?php get_dFolio( "project", "10", "feature" ); ?>
				</li>
<?php
				if ( $features->have_posts() ) : while ( $features->have_posts() ) : $features->the_post();
?>
				<li class='featured-slide'><?php the_post_thumbnail(); ?></li>
<?php
				endwhile;
				endif;
?>
			</ul>
		</div>
		<button class='next paging'></button>
	</div>
</div> 
