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
				<?php get_dFolio( "team", 25, "team" ); ?>
			</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/work-collaborate' ) ); ?>
		</div>
	</div>
</div>