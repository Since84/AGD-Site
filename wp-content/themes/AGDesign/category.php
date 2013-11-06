<?php
/**
 * The template for displaying Category Archive pages
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
		<div class="left-column column">
			<ul class="categories">
<?php 			Starkers_Utilities::get_template_parts( array( 'parts/shared/blog-category-list' ) ); ?> 
			</ul>
		</div>
		<div class="wide-content column">
			<ul class="blog">
<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();

			Starkers_Utilities::get_template_parts( array( 'parts/shared/blogroll-post-block' ) ); 

			endwhile; 
			else: 
?>
				<h2>No posts to display in <?php echo single_cat_title( '', false ); ?></h2>	
<?php		
			endif;
?>
			</ul>
		</div>
	</div>
</div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>