<?php
/* Team Feature section */


?>
<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<h1>Get To Know Us</h1>
			<?php wp_nav_menu( array("menu" => "get-to-know-us") ); ?>
		</div>
		<div class="wide-content column">
			<div class="team-feature">
				<h1><?php the_title(); ?></h1>
				<?php get_dFolio( "team", "25", "team" ); ?>
			</div>
			<ul class="lower-content">
				<li class="work-with col-2 column">
<?php 				$work = new WP_Query( 'category_name=work-with-us&post_type=page' ); 
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
<?php 				$collab = new WP_Query( 'category_name=collaborate-with-us&&post_type=page&posts_per_page=1' ); 
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
		</div>
	</div>
</div>