<?php 
	/* Work and Collaborate Preview Content */ 	
	$name = $post->post_name;
	$contactPage = get_page_by_title('connect');
?>			

			<ul class="lower-content">
				<li class="work-with col-2 column open">
<?php 				$work = new WP_Query( 'tag=work-with-us&post_type=page' ); 
					if ( $work->have_posts() ) : while ( $work->have_posts() ) : $work->the_post();
?>
					<h2><?php the_title(); ?></h2>
<?php
					the_content();
					$contactLink = get_post_meta( get_the_id(), 'contact_link', true );
?>
					<div class="open-close">
						<span class="arrow-button"></span>
					</div>
<?php
						if ( $name != 'contact' ) : 
?>					
							<a href="<?php echo get_permalink( $contactPage->ID ); ?>"><?php echo $contactLink; ?></a>
<?php
						else :

							insert_cform('Work With Us');
						
						endif;

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
					the_content();
					$contactLink = get_post_meta( get_the_id(), 'contact_link', true );
?>
					<div class="open-close">
						<span class="arrow-button"></span>
					</div>
<?php
						if ( $name != 'contact' ) : 
?>					
							<a href="<?php echo get_permalink($contactPage->ID ); ?>"><?php echo $contactLink; ?></a>
<?php
						else :

							insert_cform('Collaborate With Us');
						
						endif;

					endwhile;
					endif;
					wp_reset_query();
?>
				</li>
			</ul>