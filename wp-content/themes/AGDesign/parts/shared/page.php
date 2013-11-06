<?php /* Basic Page Content */?>
<?php global $post; ?>
<div class='main-content'>
	<div class="container">
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/side-nav') ); ?>
		<div class="wide-content column">
			<?php the_content(); ?>
		</div>
	</div>
</div>
