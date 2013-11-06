<?php
/* Team Feature section */
?>
<div class='main-content'>
	<div class="container">
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/side-nav' ) ); ?>
		<div class="wide-content column">
			<div class="team-feature">
				<h1><?php the_title(); ?></h1>
				<?php get_dFolio( "team", 25, "team" ); ?>
			</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/work-collaborate' ) ); ?>
		</div>
	</div>
</div>