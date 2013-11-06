<?php /* Sidebar Nav */?>

<div class="left-column column">
	<?php 
		// var_dump($post->post_name);
		switch( $post->post_name ){
			case "about-agd":
			case "team": 
				echo "<h1> Get to Know Us </h1>";
				$navMenu = "about-us";
				break;
			case "accolades":
			case "areas-we-serve":
			case "payment-portal":
				break;
			default:
				$navMenu = "side-menu";
				break;
		}
		if ( $navMenu ) { wp_nav_menu( array("menu" => $navMenu ) ); } 
	?>
</div>