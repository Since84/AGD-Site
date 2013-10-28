<?php
/* 	Contact Info 
	From Dynamite Portfolio Plugin
	Functions dynamite_get_address(), dynamite_get_contact()
*/ 
	$address = dynamite_get_address();
	$contact = dynamite_get_contact();

?>

<div class='main-content'>
	<div class="container">
		<div class="left-column column">
			<h1>Get To Know Us</h1>
			<?php wp_nav_menu( array("menu" => "get-to-know-us") ); ?>
		</div>
		<div class="wide-content column">
			<div class="connect">
				<h1><?php the_title(); ?></h1>
				<ul class="contact-info">
					<li class="column one-third address ">
						<h2><?php echo $address->name; ?></h2>
						<ul class="business-address">
							<li><?php echo $address->address1; ?></li>
							<li><?php echo $address->address2; ?></li>
							<li><?php echo $address->city.', '.$address->state; ?></li>
							<li><?php echo $address->zip; ?></li>
						</ul>
					</li> 
					<li class="column one-third contact">
						<ul class="business-contact">
							<li><?php echo $contact->phone; ?></li>
							<li><?php echo $contact->fax; ?></li>
						</ul>
						<div class= "business-email">
							<h2>General Inquiries</h2>
						</div>
					</li>
					<li class="column one-third social">
						<?php dynamic_sidebar( 'Social Links' ) ?>
					</li> 
				</ul>
			</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/work-collaborate' ) ); ?>
		</div>
	</div>
</div>