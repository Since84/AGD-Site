<?php
/* Dynamite Portfolio - Menus and Widgets */

add_filter('admin_init', 'my_general_settings_register_fields');
 
function my_general_settings_register_fields()
{
    register_setting('general', 'business_name', 'esc_attr');
    add_settings_field('business_name', '<label for="business_name">'.__('Business Name' , 'business_name' ).'</label>' , 'my_business_name_html', 'general');
    
    register_setting('general', 'business_phone', 'esc_attr');
    add_settings_field('business_phone', '<label for="business_phone">'.__('Phone Number' , 'business_phone' ).'</label>' , 'my_business_phone_html', 'general');
    
    register_setting('general', 'business_fax', 'esc_attr');
    add_settings_field('business_fax', '<label for="business_fax">'.__('Fax Number' , 'business_fax' ).'</label>' , 'my_business_fax_html', 'general');
    
    register_setting('general', 'business_email', 'esc_attr');
    add_settings_field('business_email', '<label for="business_email">'.__('Email' , 'business_email' ).'</label>' , 'my_business_email_html', 'general');

     register_setting('general', 'business_careers_email', 'esc_attr');
    add_settings_field('business_careers_email', '<label for="business_careers_email">'.__('Email' , 'business_careers_email' ).'</label>' , 'my_business_careers_email_html', 'general');

    register_setting('general', 'business_address1', 'esc_attr');
    add_settings_field('business_address1', '<label for="business_address1">'.__('Address 1' , 'business_address1' ).'</label>' , 'my_business_address1_html', 'general');

    register_setting('general', 'business_address2', 'esc_attr');
    add_settings_field('business_address2', '<label for="business_address2">'.__('Address 2' , 'business_address2' ).'</label>' , 'my_business_address2_html', 'general');

    register_setting('general', 'business_city', 'esc_attr');
    add_settings_field('business_city', '<label for="business_city">'.__('City' , 'business_city' ).'</label>' , 'my_business_city_html', 'general');

    register_setting('general', 'business_state', 'esc_attr');
    add_settings_field('business_state', '<label for="business_state">'.__('State' , 'business_state' ).'</label>' , 'my_business_state_html', 'general');

    register_setting('general', 'business_zip', 'esc_attr');
    add_settings_field('business_zip', '<label for="business_zip">'.__('Zip' , 'business_zip' ).'</label>' , 'my_business_zip_html', 'general');

}

/* Business Name */ 
function my_business_name_html()
{	
    $name = get_option( 'business_name');
    echo '<input type="text" id="business_name" name="business_name" value="' . $name . '" />';
}
/* Phone/Email */
function my_business_phone_html() {

	
    $phone = get_option( 'business_phone');
    echo '<input type="text" id="business_phone" name="business_phone" value="' . $phone . '" />';

}

function my_business_fax_html() {

    $fax = get_option( 'business_fax');
    echo '<input type="text" id="business_fax" name="business_fax" value="' . $fax . '" />';
	
}

function my_business_email_html() {

    $email = get_option( 'business_email');
    echo '<input type="text" id="business_email" name="business_email" value="' . $email . '" />';
	
}

function my_business_careers_email_html() {

    $careersEmail = get_option( 'business_careers_email');
    echo '<input type="text" id="business_careers_email" name="business_careers_email" value="' . $careersEmail . '" />';
    
}

/* Address */
function my_business_address1_html() {

    $address1 = get_option( 'business_address1');
    echo '<input type="text" id="business_address1" name="business_address1" value="' . $address1 . '" />';
	
}    

function my_business_address2_html() {

    $address2 = get_option( 'business_address2');
    echo '<input type="text" id="business_address2" name="business_address2" value="' . $address2 . '" />';
	
}

function my_business_city_html() {

    $city = get_option( 'business_city');
    echo '<input type="text" id="business_city" name="business_city" value="' . $city . '" />';
	
}

function my_business_state_html() {

    $state = get_option( 'business_state');
    echo '<input type="text" id="business_state" name="business_state" value="' . $state . '" />';
	
}

function my_business_zip_html() {

    $zip = get_option( 'business_zip');
    echo '<input type="text" id="business_zip" name="business_zip" value="' . $zip . '" />';
	
}


/* Company Info Functions */

function dynamite_get_address(){
	$address = array(
		 "name"		=>	get_option( 'business_name' )
		,"address1"	=>	get_option( 'business_address1' )
		,"address2"	=>	get_option( 'business_address2' )
		,"city"		=>	get_option( 'business_city' )
		,"state"	=>	get_option( 'business_state' )
		,"zip"		=>	get_option( 'business_zip' )
	);

	return $address;
}

function dynamite_get_contact(){
	$contact = array(
		 "name"		            =>	get_option( 'business_name' )
		,"phone"	            =>	get_option( 'business_phone' )
		,"fax"		            =>	get_option( 'business_fax' )
		,"email"	            =>	get_option( 'business_email' )
        ,"careers_email"        =>  get_option( 'business_careers_email' )
	);

	return $contact;
}

?>