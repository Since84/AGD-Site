<?php
/******************************************************************************
#                      PayPal PRO Payment Terminal v3.0
#******************************************************************************
#      Author:     Convergine.com
#      Email:      info@convergine.com
#      Website:    http://www.convergine.com
#
#
#      Version:    3.0
#      Copyright:  (c) 2012 - Convergine.com
#
#*******************************************************************************/
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require("functions.php");
/*******************************************************************************************************
    GENERAL SCRIPT CONFIGURATION VARIABLES
********************************************************************************************************/
//THIS IS TITLE ON PAGES
$title = "PayPal PRO Payment Terminal v3.0"; //site title
//THIS IS ADMIN EMAIL FOR NEW PAYMENT NOTIFICATIONS.
$admin_email = "notifications@email.com"; //this email is for notifications about new payments
//CHANGE "USD" TO REQUIRED CURRENCY, SUPPORTED BY PROVIDER.USD, CAD, EUR
define("PTP_CURRENCY_CODE","USD"); 
//IF YOU NEED TO ADD MORE SERVICES JUST ADD THEM THE SAME WAY THEY APPEAR BELOW.
$services = array(
				  array("Service 1", "49.99"),
				  array("Service 2", "149.99"),
				  array("Service 3", "249.99"),
				  array("Service 4", "349.99"),
			);
//NOW, IF YOU WANT TO ACTIVATE THE DROPDOWN WITH SERVICES ON THE TERMINAL
//ITSELF, CHANGE BELOW VARIABLE TO TRUE;			
$show_services = true;

// set  to   RECUR  - for recurring payments, ONETIME - for 
$payment_mode = "ONETIME";


//service name   |   price  to charge   | Billing period  "Day", "Week", "SemiMonth", "Month", "Year"   |  how many periods of previous field per billing period
$recur_services = array(
				 array("Service 1 monthly", "49.99", "Month", "1"),
				 array("Service 1 quaterly", "149.99", "Month", "3"),
				 array("Service 1 semi-annualy", "249.99", "Month", "6"),
				 array("Service 1 annualy", "349.99", "Year", "1")
				); 

//IF YOU'RE GOING LIVE FOLLOWING VARIABLE SHOULD BE SWITCH TO true
// IT WILL AUTOMATICALLY REDIRECT ALL NON-HTTTPS REQUESTS TO HTTPS.
// MAKE SURE SSL IS INSTALLED ALREADY.
$redirect_non_https = false;
$liveMode = false;
/****************************************************
//TEST CREDIT CARD CREDENTIALS for SANDBOX TESTING
Card Type: Visa
Account Number: 4683075410516684
Expiration Date: Any in future
Security Code: 123
****************************************************/

if(!$liveMode){
//TEST MODE
define('API_USERNAME', 'YOUR_SANDBOX_API_USERNAME');
define('API_PASSWORD', 'your_SANDBOX_API_PASSWORD');
define('API_SIGNATURE', 'your_SANDBOX_api_signature');
define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
} else {
//LIVE MODE
define('API_USERNAME', 'your_LIVE_api_username');
define('API_PASSWORD', 'your_LIVE_api_password');
define('API_SIGNATURE', 'your_LIVE_api_signature_very_long_string');
//DONT EDIT BELOW 2 LINES IF UNSURE.
define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');
}

/*******************************************************************************************************
    PAYPAL EXPRESS CHECKOUT CONFIGURATION VARIABLES
********************************************************************************************************/
$enable_paypal = true; //shows/hides paypal payment option from payment form.
$paypal_merchant_email = "your_paypal_merchant_email@here.com";
$paypal_success_url = "http://www.domain.com/path/to/paypal-pro-terminal/paypal_thankyou.php";
$paypal_cancel_url = "http://www.domain.com/path/to/paypal-pro-terminal/paypal_cancel.php";
$paypal_ipn_listener_url = "http://www.domain.com/path/to/paypal-pro-terminal/paypal_listener.php";
$paypal_custom_variable = "some_var";
$paypal_currency = "USD";
$sandbox = false; //if you want to test payments with your sandbox account change to true (you must have account at https://developer.paypal.com/ and YOU MUST BE LOGGED IN WHILE TESTING!)
if($liveMode){ $sandbox = false; } else { $sandbox = true; }


//DO NOT CHANGE ANYTHING BELOW THIS LINE, UNLESS SURE OF COURSE
define("PAYMENT_MODE",$payment_mode);
if(!$sandbox){
    define("PAYPAL_URL_STD","https://www.paypal.com/cgi-bin/webscr");
} else {
    define("PAYPAL_URL_STD","https://www.sandbox.paypal.com/cgi-bin/webscr");
}

define('USE_PROXY',FALSE);
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');
define('VERSION', '2.3');
define('ACK_SUCCESS', 'SUCCESS');
define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');

if($redirect_non_https){
	if ($_SERVER['SERVER_PORT']!=443) {
		$sslport=443; //whatever your ssl port is
		$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		header("Location: $url");
		exit();
	}
}
?>