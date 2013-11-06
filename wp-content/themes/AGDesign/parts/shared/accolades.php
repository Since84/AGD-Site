<?php
/* Accolade section */

$accArgs = array(
	"post_type"	=> "testimonial"
);
$accQuery = new WP_Query ( $accArgs );
?>
<div class='main-content testimonials'>
	<div class="container">
		<div class="left-column column">
		</div>
		<div class="wide-content column">
			<h1><?php the_title(); ?></h1>
			<?php 
				if( $accQuery->have_posts() ) : while( $accQuery->have_posts() ) : $accQuery->the_post(); 
				$accTitle = get_post_meta( get_the_ID(), 'client_position', true );?>
			<div class="testimonial">
				<?php the_post_thumbnail(); ?>
				<?php the_content(); ?>
				<h2><?php the_title(); ?></h2>
				<span class="client-position"><?php echo $accTitle; ?></span>
			</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
</div>