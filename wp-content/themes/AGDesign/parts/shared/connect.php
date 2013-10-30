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
		<ul>
			<li class="column col-2 map">
				<img src="<?php bloginfo( 'template_directory' );?>/styles/images/map.jpg"/>
			</li>
			<li class="column col-2">
				<h2 class="business-name"><?php echo $address['name']; ?></h2>
				<p class="business-address">
					<?php echo $address['address1']; ?>, <?php echo $address['address2']; ?>
					<br>
					<?php echo $address['city'].', '.$address['state']; ?> <?php echo $address['zip']; ?>							
				</p>
				<ul class="business-contact">
					<li><strong>T</strong><?php echo $contact['phone']; ?></li>
					<li><strong>F</strong><?php echo $contact['fax']; ?></li>
				</ul>	
				<div class= "business-email">
					<h2>General Inquiries</h2>
					<a href="mailto:<?php echo $contact['email'];?>"><?php echo $contact['email'];?></a>
					<h2>Careers</h2>
					<a href="mailto:<?php echo $contact['careers_email'];?>"><?php echo $contact['careers_email'];?></a>
				</div>					
			</li>
		</ul>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/work-collaborate' ) ); ?>
	</div>
</div>