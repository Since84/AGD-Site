<?php
//------------------------------------------------------------------------------------------------------------------
// SKY HIGH CMS - Sky High Software Custom Content Management System - http://www.skyhighsoftware.com
// Copyright (C) 2008 - 2010 Sky High Software.  All Rights Reserved. 
// Permission to use and modify this software is for a single website installation as per written agreement.
//
// DO NOT DISTRIBUTE OR COPY this software to any additional purpose, websites, or hosting.  If the original website
// is move to new hosting, this software may also be moved to new location.
//
// IN NO EVENT SHALL SKY HIGH SOFTWARE BE LIABLE TO ANY PARTY FOR DIRECT, INDIRECT, OR INCIDENTAL DAMAGES, 
// INCLUDING LOST PROFITS, ARISING FROM USE OF THIS SOFTWARE.
//
// THIS SOFTWARE IS PROVIDED "AS IS". SKY HIGH SOFTWARE HAS NO OBLIGATION TO PROVIDE MAINTENANCE, SUPPORT, UPDATES, 
// ENHANCEMENTS, OR MODIFICATIONS BEYOND THAT SPECIFICALLY AGREED TO IN SEPARATE WRITTEN AGREEMENT.
//------------------------------------------------------------------------------------------------------------------


/////////////////////////////
// SITE CONFIGURATION FILE

$trueURL 				= 'http://www.agdesigngroup.net';
$baseURL 				= 'http://www.agdesigngroup.net';
$secureURL 				= 'https://www.agdesigngroup.net';
$FCKEDITOR_BASEPATH 	=  'admin/fckeditor/';

$HEADER_DEFAULT = "xxxx.swf";

$HELP_FOLDER = '../admin/help/';
$FLIP_FOLDER = 'overviews/';

/////////////////////////////////////
//  DATABASE TABLES TO BACKUP & RESTORE


////////////////////////////////////////////////////
// PAY PAL Constants are in the following file:

// cart/payPal/constants.php

////////////////////////////////////
// Email receipts
$inquiryEMAIL 	= 'hello@agdesigngroup.net';
$receiptFROM 	= 'hello@agdesigngroup.net';
$receiptSUBJECT = "AG Design - Customer Purchase Confirmation"; 
	
///////////////////////////////////////
// General Order Information
$default_ship_amt = -1;

$companyLOGO	= $baseURL . '/images/logo_email.jpg';
$nameFROM		= 'Orders';
$companyFROM	= "AG Design Group";
$addressFROM 	= '925 Ygnacio Valley Road, Ste 103C';
$cityFROM 		= 'Walnut Creek';
$stateFROM 		= 'CA';
$zipFROM 		= '94596';  // manufacturers zip code for chronomix
$countryFROM 	= 'US';
$phoneFROM		= '9259547084';
$faxFROM		= '9252621749';

// $orderPOLICIESLINK = 'http://www.chronomix.com/' . "BI_ordering_policies.php";

////////////////////////////////////
// Shipping Options
//
$SHIP_OPTIONS = array ("Regular","Pick Up");

$USPS_ENABLED = false;

// --------------------------------------------------------
// UPS
// --------------------------------------------------------
$UPS_ENABLED = false;
$UPS_PICKUP = "01";
$UPS_SERVICE_TYPES = array( "01" => "UPS - Next Day Air",
							"02" => "UPS - 2nd Day Air",
							"12" => "UPS - 3 Day Select",
							"03" => "UPS - Ground" ); 

// UPS service types: 
// 14 - Next Day Air Early AM
// 01 - Next Day Air
// 13 - Next Day Air Saver
// 59 - 2nd Day Air AM
//	02 - 2nd Day Air
//	12 - 3 Day Select
//	03 - Ground

// UPS pickup types: Default value is 01. 
// 01 – Daily Pickup
//	03 – Customer Counter
//	06 – One Time Pickup
//	07 – On Call Air
//	11 – Suggested Retail Ratesw
//	19 – Letter Center
//	20 – Air Service Center

///////////////////////////////////////////
// --------------------------------------------------------
// FED EX
// --------------------------------------------------------
$FEDEX_ENABLED = false;

// fedEx Authorization
// -----------------------------------------
// go to fedex.com
// choose Business solutions
// choose Access Developer Resource Center
// login while choosing Web Services
// choose Move to Production
// scroll to the bottom and click on Obtain Production Key button
// be sure to print out info as not all will be provided in email
///////////////////////////////////////////
// PRODUCTION SYSTEM
// -----------------
$fedExKey 	= 'xxxxx';
$fedExPswd 	= 'xxxxxx';
$fedExAcct	= 'xxxxx';
$fedExMeter	= 'xxxxx';

$fedExdropOffType = 'REGULAR_PICKUP';	// REGULAR_PICKUP, BUSINESS_SERVICE_CENTER, DROP_BOX, REQUEST_COURIER, STATION
$FEXED_SERVICE_TYPES = array( "FEDEX_GROUND"         => "FedEx - Ground",
							  "FEDEX_2_DAY" 		 => "FedEx - 2nd Day",
							  "STANDARD_OVERNIGHT"   => "FedEx - Standard Overnight"
							  ); 


//////////////////////////////
// UPS Authorization  
// ----------------------------
// To get this info...
// go to UPS.com
// login into MY UPS
// go to Technology Support, UPS ONline Tools, Get Access Key, Get XML Access Key
// use Sky High SOftware DEveloper Key:  4C2AAF638BC774B4
//////////////////////
$UPSAccessLicenseNumber = '4C2AAF638BC774B4';
$UPSUserID 				= 'xxxxxx'; //
$UPSAccount 			= 'xxxx';	  // NewChron account
$UPSPassword			= 'xxxxx';  // NewChron password

// see checkout_shipping for other options
// $serviceType 	= "FEDEX_GROUND";
// $rate->setDropOffType('DROP_BOX');	// DROP_BOX, REGULAR_PICKUP

///////////////////////////////////
// USPS access (used in usps.php)
///////////////////////////////////
//
// NOTE: Need registered an account with USPS 
//       http://www.uspsprioritymail.com/et_regcert.html 
//
define('USPS_USERID', 		'xxxxxxxxxxxx');		// sky high test key
define('USPS_PASSWORD', 	'xxxxxxxxxxxx');

define ('USPS_SERVER', 	'production');  // production or test

define('USPS_TEXT_TITLE', 'United States Postal Service');

define('USPS_TEXT_OPT_PP', 'Parcel Post');
define('USPS_TEXT_OPT_PM', 'Priority Mail');
define('USPS_TEXT_OPT_EX', 'Express Mail');

define('USPS_TEXT_ERROR', 'An error occured with the USPS shipping calculations.<br>If you prefer to use USPS as your shipping method, please contact the store owner.');

define('SHIPPING_ORIGIN_COUNTRY', 'US');
define('SHIPPING_ORIGIN_ZIP', '94596');
?>