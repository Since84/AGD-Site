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
		<div class="left-column column"></div>
		<div class="wide-content column">
			<div class="connect">
				
				<ul class="contact-info">
					<li class="column one-third address ">
						<h1>Visit</h1>
						<h2 class="business-name"><?php echo $address['name']; ?></h2>
						<ul class="business-address">
							<li><?php echo $address['address1']; ?></li>
							<li><?php echo $address['address2']; ?></li>
							<li><?php echo $address['city'].', '.$address['state']; ?></li>
							<li><?php echo $address['zip']; ?></li>
						</ul>
					</li> 
					<li class="column one-third contact">
						<h1>Connect</h1>
						<ul class="business-contact">
							<li><strong>T</strong><?php echo $contact['phone']; ?></li>
							<li><strong>F</strong><?php echo $contact['fax']; ?></li>
						</ul>
						<div class= "business-email">
							<h2>General Inquiries</h2>
							<a href="mailto:<?php echo $contact['email'];?>"><?php echo $contact['email'];?></a>
						</div>
					</li>
					<li class="column one-third social">
						<h1>Follow</h1>
						<?php dynamic_sidebar( 'Social Links' ) ?>
					</li> 
				</ul>
			</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/work-collaborate' ) ); ?>
		</div>
	</div>
</div>