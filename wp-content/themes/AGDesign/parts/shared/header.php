<header>
	<div class="container">
		<div class="home-logo">
			<a href="<?php echo home_url(); ?>"><img src="<?php bloginfo( 'template_url' );?>/styles/images/logos/agdinc-logo.png"/></a>
		</div>
		<?php wp_nav_menu( array('menu' => 'Main Nav' )); ?>
	</div>
</header>
<div class="subheader">
	<div class="container">
		<?php get_search_form(); ?>
	</div>
</div>