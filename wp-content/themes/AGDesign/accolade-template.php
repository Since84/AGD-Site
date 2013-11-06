<?php
/**
 * Template Name: Accolades
 */
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/accolades' ) ); ?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?
endwhile; endif;
?>