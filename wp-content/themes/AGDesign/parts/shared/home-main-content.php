<?php
/* Home Main Content */

$accoladesPage = get_page_by_title( 'accolades' );
$accoladesLink = get_permalink( $accoladesPage->ID );
?>
<div class='main-content'>
	<div class="container">
		<div class="one-third column">
			<div class="credo section">
<?php 
	$credoQuery = new WP_Query('pagename=agd-credo'); 
	if ( $credoQuery->have_posts() ) : while ( $credoQuery->have_posts() ) : $credoQuery->the_post();
?>
				<h1><?php the_title(); ?></h1>
				<div><?php the_excerpt(); ?></div>
				<a href="<?php echo $accoladesLink; ?>">Read What Our Clients Have To Say</a>
<?php
	endwhile; 
	endif;
?>
			</div>
			<div class="testimonial section">
<?php 
	$testimonialQuery = new WP_Query('tag=home-feature&post_type=testimonial'); 
	if ( $testimonialQuery->have_posts() ) : while ( $testimonialQuery->have_posts() ) : $testimonialQuery->the_post();
		$position = get_post_meta( get_the_ID(), 'client_position', true );
?>
				<?php the_post_thumbnail();?>
				<div class="client-quote">
					<?php the_content(); ?>
					<div class="client-info">
						<span class="client-name"><?php the_title(); ?></span>
						<span class="client-position"><?php echo $position; ?></span>
					</div>
				</div>
<?php
	endwhile; 
	endif;
?>			
			</div>
			<div class="formula section">
<?php 
	$formulaQuery = new WP_Query('pagename=agd-formula'); 
	if ( $formulaQuery->have_posts() ) : while ( $formulaQuery->have_posts() ) : $formulaQuery->the_post();
?>
			<h1><?php the_title(); ?></h1>
			<div><?php the_excerpt(); ?></div>
			<?php //new_excerpt_more("Read More"); ?>
<?php
	endwhile; 
	endif;
?>
			</div>
		</div>
		<div class="two-third column">
			<div class="connected section">
				<h2>Stay Connected</h2>
				<?php insert_cform('Stay Connected'); ?>
			</div>
			<ul class="news section">
				<h2>What's New</h2>
<?php 
	$newsQuery = new WP_Query('showposts=4'); 
	if ( $newsQuery->have_posts() ) : while ( $newsQuery->have_posts() ) : $newsQuery->the_post();
?>
				<li class="post">
					<a href="<?php the_permalink(); ?>">
						<div class="thumbnail">
<?php 						the_post_thumbnail(); ?>
						</div>
						<div><?php the_excerpt(); ?></div>
					</a>
				</li>
<?php
	endwhile; 
	endif;
?>
			</ul>
		</div>
	</div>
</div>