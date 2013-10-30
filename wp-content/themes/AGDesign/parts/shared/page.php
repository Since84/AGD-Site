<?php /* Basic Page Content */?>
<?php global $post; ?>
<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<?php 
				switch( $post->post_name ){
					case "about-agd": 
						echo "<h1> Get to Know Us </h1>";
						$navMenu = "about-us";
						break;
					case "accolades":
						break;
					default:
						var_dump($post->post_name);
						$navMenu = "side-menu";
						break;
				}
				var_dump($navMenu);
				if ( $navMenu ) { wp_nav_menu( array("menu" => $navMenu ) ); } 
			?>
		</div>
		<div class="wide-content column">
			<?php the_content(); ?>
		</div>
	</div>
</div>
