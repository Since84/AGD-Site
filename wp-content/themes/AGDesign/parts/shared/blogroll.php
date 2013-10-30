<?php /* Basic Page Content */?>
<?php global $post; ?>
<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<ul>
			<?php wp_list_categories(); ?> 
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
?>
				<li class="post">
					<h3 class="post-date"><?php the_time('m.d.Y'); ?></h3>
					<h1 class="post-title"><?php the_title();?></h1>
					<?php the_post_thumbnail( array('196', '196') ); ?>
					<?php the_excerpt(); ?>
				</li>
<?php
			endwhile; endif;
?>
			</ul>
		</div>
	</div>
</div>
