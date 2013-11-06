<?php /* Basic Page Content */?>
<?php global $post; ?>
<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<ul class="categories">
<?php 		Starkers_Utilities::get_template_parts( array( 'parts/shared/blog-category-list' ) ); ?>
			</ul>
		</div>
		<div class="wide-content column">
				<ul class="blog">
<?php
				$blogArgs = array(
					"posts_per_page"	=> 10
				);

				$blog = new WP_QUERY( $blogArgs );

				if ( $blog->have_posts() ) : while ( $blog->have_posts() ) : $blog->the_post();
		
				Starkers_Utilities::get_template_parts( array( 'parts/shared/blogroll-post-block' ) ); 
				
				endwhile; endif;
?>
				</ul>
		</div>
	</div>
</div>
