<?php
/* Header	*/

$headline = get_post_meta( $post->ID, 'headline', true );

?>
<header>
	<div class="container">
		<div class="home-logo">
			<a href="<?php echo home_url(); ?>"><img src="<?php bloginfo( 'template_url' );?>/styles/images/logos/agdinc-logo.png"/></a>
		</div>
		<?php wp_nav_menu( array('menu' => 'Main Nav' )); ?>
	</div>
</header>
<div class="subheader">
<?php if ( !is_home() ) : ?>
	<div class="container">
<?php 	
	if( !is_home() ){	 
	  // if ( is_page('114') ){
		 //  echo get_search_form();
	  // } else {
		  insert_cform('Stay Connected');
	  // }
	}
?>
<?php if( $headline ) { ?>
		<div class="headline">
<?php 	echo $headline;  ?>
		</div>
<?php } else if ( !is_home() ) { ?>
		<div class="headline page-title container">
			<?php the_title(); ?>
		</div>
<?php } ?>
	</div>
<?php endif; ?>
</div>