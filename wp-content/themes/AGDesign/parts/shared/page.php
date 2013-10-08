<?/* Basic Page Content */?>
<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<?php wp_nav_menu( array("menu" => "side-menu") ); ?>
		</div>
		<div class="wide-content column">
			<?php the_content(); ?>
		</div>
	</div>
</div>
