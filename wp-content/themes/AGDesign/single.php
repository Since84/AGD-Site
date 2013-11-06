<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div class='main-content'>
	<div class="container">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="left-column column">
			<ul class="categories">
<?php 			Starkers_Utilities::get_template_parts( array( 'parts/shared/blog-category-list' ) ); ?>
				<li class="go-back-button"><a href="javascript:history.go(-1)" onMouseOver="self.status=document.referrer;return true">Go Back</a></li>
			</ul>
		</div>
		<article class="wide-content column">
			<time datetime="<?php the_time( 'm d Y' ); ?>" pubdate><?php the_date('m.d.Y'); ?></time>
			<h1><?php the_title(); ?></h1>
			<?php the_post_thumbnail(); ?>
			<?php the_content(); ?>			
			<?php if ( get_the_author_meta( 'description' ) ) : ?>
			<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
			<h3>About <?php echo get_the_author() ; ?></h3>
			<?php the_author_meta( 'description' ); ?>
			<?php endif; ?>



		</article>
<?php endwhile; ?>
	</div>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>