<?php /* Work and Collaborate Preview Content */ ?>			

			<ul class="lower-content">
				<li class="work-with col-2 column">
<?php 				$work = new WP_Query( 'tag=work-with-us&post_type=page' ); 
					if ( $work->have_posts() ) : while ( $work->have_posts() ) : $work->the_post();
?>
					<h2><?php the_title(); ?></h2>
<?php
					the_excerpt();

					endwhile;
					endif;
					wp_reset_query();
?>
				</li>
				<li class="collaborate-with col-2 column">
<?php 				$collab = new WP_Query( 'tag=collaborate-with-us&&post_type=page&posts_per_page=1' ); 
					if ( $collab->have_posts() ) : while ( $collab->have_posts() ) : $collab->the_post();
?>
					<h2><?php the_title(); ?></h2>
<?php
					the_excerpt();

					endwhile;
					endif;
					wp_reset_query();
?>
				</li>
			</ul>