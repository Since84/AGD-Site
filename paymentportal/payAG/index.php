<?php
////////////////////////////////////////
// CMS
require_once('../Connections/dbCMS.php'); 
require_once("../admin/db_utils.php");
include("../admin/db_misc_functions.php");
include("../utils/misc.php");

$page_id = 10; // home page $_GET['page_id'];
// TEST 
//$page_id = 1029;

// generate top navigation
include("../includes/main_nav_generator.php");

$i = 0;
$s = 0;

// get path for sub navigation to this page
$page_path = array();
gen_path($page_id, $page_path, $db_database, $db_connection);	
$page_menu_id = $page_path[0]; // controls display of top nav

// get content for this page
require_once('../admin/db_pages_get_byID.php');

include("../admin/db_headers_get.php");
//echo 'header: ' . $row_rsPages['header_id'];
if( $row_rsPages['header_id'] > 0 )
	$header_file = getHeader($row_rsPages['header_id'], $db_database, $db_connection);
else
	$header_file = $HEADER_DEFAULT;
$header = explode(".", $header_file);

//echo '<br/>header file: ' . $header_file . ' (' . $header . ')';

?>
<?php 
require_once("../utils/server.php");
if( !secureConnection() )
{
	header("Location: " . "https://www.agdesigngroup.net/payAG" );
}

$LIVE_PAY = true;  

$company_name 		= "AG Design";
$receipt_email 		= "arlene@agdesigngroup.net";
$logo_image_file	= "http://www.agdesigngroup.net/images/logo.gif";

$compCodes = array("qweNONEsdjj", "mnNONEjfsd");
$msg = '';
$test_msg = '';

// ====================================================================================
// initialize the session, check for logout request, and check for authorized access
// ====================================================================================
if (!isset($_SESSION)) {
  session_start();
}

?>
<?php
// PayPal net stuff
$post_action = '';
$showResponse = 0;
$error	      = 0;

$varDesc = $company_name;
$varType   = 'C';

// get values 
//if( $_SESSION['PrevUrl'] == "/calendarTEST.php" || 
//	$_SESSION['PrevUrl'] == "/login.php"  )
if( !isset($_POST['Submit']) )
{
	// echo '<br/>from: ' . $_SESSION['PrevUrl'];
	$_SESSION['PrevUrl'] = NULL;
	
	// coming through first time
	$varAmount = 1.0;
	$varDesc   = $company_name;

	// initialize variables
	$varEmail      = NULL;
	$varEmail2     = NULL;
	$varFirstName 	= NULL;
	$varLastName 	= NULL;
	$varAddress 	= NULL;
	$varCity	 	= NULL;
	$varState	 	= NULL;
	$varZip		 	= NULL;
	$varCountry	 	= NULL;
	$varPhone	    = NULL;
	$varCardExpMo   = NULL;
	$varCardExpYr   = NULL;
	$varCardNo      = NULL;
	$varDisplayNo = '';
	$member_id 	    = NULL;
	$varPayAmount   = NULL;
	$varDescription = NULL;
	$varCardType	= NULL;
	$cvv2Number		= NULL;
}
else	
// check for form submitted
if( isset($_POST['Submit']) )
{

	// echo '<br/>submitted';
	
	$varEmail 		= stripslashes($_POST['email']);
	$varEmail2      = stripslashes($_POST['email_confirm']);
	$varFirstName 	= stripslashes($_POST['first_name']);
	$varLastName 	= stripslashes($_POST['last_name']);
	$varAddress 	= stripslashes($_POST['address']);
	$varCity	 	= stripslashes($_POST['city']);
	$varState	 	= stripslashes($_POST['state']);
	$varZip		 	= stripslashes($_POST['zip']);
	$varCountry	 	= stripslashes($_POST['country']);
	$varPhone	    = stripslashes($_POST['phone']);
	$varCardExpMo   = $_POST['cardExpMo'];
	$varCardExpYr   = $_POST['cardExpYr'];
	$varCardNo   	= $_POST['card_no'];
	$varDisplayNo 	= $_POST['display_no'];
	$varCardType	= $_POST['cardtype'];
	$cvv2Number		= $_POST['cvv2Number'];

	$varPayAmount 	= $_POST['pay_amount'];
	$varDescription	= $_POST['description'];
	
	if( substr($varDisplayNo,0,4) != '****' )
	{
		$varCardNo = $varDisplayNo;
	}

	// check for comp codes	
	$Comped = ( in_array($varCardNo,$compCodes) ? true : false );

	// echo '<br/>continuing...';
		
	@set_time_limit(0);

	$error = 0;
 	if( (!$Comped) &&
		( empty($_POST['cardExpMo'])  ||
		  empty($_POST['cardExpYr'])  ||
		  ( empty($_POST['card_no']) && empty($_POST['display_no']) )
		)
	  )
	{
		$errorMsg = 'Please enter required credit card information.';
		$error = 1;
	}
	
	if( empty($_POST['cvv2Number'])   )
	{
		$errorMsg = 'Please enter your credit card verification number which is the 3 digit number on the back of your card.';
		$error = 1;
	}

	if( empty($_POST['email'])     || 
		empty($_POST['email_confirm']) ||
		empty($_POST['first_name'])  ||
		empty($_POST['last_name'])  ||
		empty($_POST['address'])  ||
		empty($_POST['city'])  ||
		empty($_POST['state'])  ||
		empty($_POST['zip'])  ||
		empty($_POST['country'])  ||
		empty($_POST['pay_amount'])  ||
		empty($_POST['phone'])   
		)
	{
		$errorMsg = 'Please enter all required information (bold).';
		$error = 1;
	}
	
	if( $error == 0 )
	{
		// echo '<br/>editing...';
	
		// edits of data
		if( badEmail($varEmail) )
		{
			$errorMsg = 'Please enter a valid email address in the form name@isp.com.';
			$error = 1;
		}
		else
		if( strcmp($varEmail, $varEmail2) )
		{
			$errorMsg = 'Emails do not match, please re-enter.';
			$error = 1;
		}
		else
		{
			// echo 'passed edits';
			
			$showResponse = 1;
			$success = 1;

			// if not mailing a check, process credit card transaction
			if( !$Comped )
			{
				/********************************************************
				The code collects transaction parameters from the form
				displayed by DoDirectPayment.php then constructs and sends
				the DoDirectPayment request string to the PayPal server.
				The paymentType variable becomes the PAYMENTACTION parameter
				of the request string.
				
				After the PayPal server returns the response, the code
				displays the API request and response in the browser.
				If the response from PayPal was a success, it displays the
				response parameters. If the response was an error, it
				displays the errors.
				
				Called by DoDirectPayment.php.
				
				Calls CallerService.php and APIError.php.
				***********************************************************/

				require_once 'CallerService.php';
				session_start();

				/**
				 * Get required parameters from the web form for the request
				 */
				$paymentType 		= 'Sale';
				$firstName 			= urlencode( $_POST['first_name']);
				$lastName 			= urlencode( $_POST['last_name']);
				$creditCardType 	= $varCardType ; // urlencode( $_POST['creditCardType']);
				$creditCardNumber 	= $varCardNo;
				$expDateMonth 		= urlencode( $_POST['cardExpMo']);
				// Month must be padded with leading zero
				$padDateMonth 		= str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
				$expDateYear 		= urlencode( $_POST['cardExpYr']);
				$cvv2Number 		= urlencode($_POST['cvv2Number']);
				$address1 			= urlencode($_POST['address']);
				$address2 			= ' '; // urlencode($_POST['address2']);
				$city 				= urlencode($_POST['city']);
				$state 				= urlencode( $_POST['state']);
				$zip 				= urlencode($_POST['zip']);
				$amount 			= urlencode($_POST['pay_amount']);
				//$currencyCode=urlencode($_POST['currency']);
				$currencyCode		= "USD";
				
				/* Construct the request string that will be sent to PayPal.
				   The variable $nvpstr contains all the variables and is a
				   name value pair string with & as a delimiter */
				$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.'20'.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
				"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
				
				// echo '<br/>' . $nvpstr . '<br/>';
				
				if( $LIVE_PAY )
				{
					/* Make the API call to PayPal, using API signature.
					   The API response is stored in an associative array called $resArray */
					$resArray=hash_call("DoDirectPayment",$nvpstr);
	
					/* Display the API response back to the browser.
					   If the response from PayPal was a success, display the response parameters'
					   If the response was an error, display the errors received using APIError.php.
					   */
					$ack = strtoupper($resArray["ACK"]);
					
					if($ack!="SUCCESS")  
					{
						 $success = 3;
					}
				}
			}
			
			if( !$LIVE_PAY )
			{
				echo 'NOT LIVE PAY';
				echo '<br/>' . $nvpstr . '<br/>';
			}
								
			if($Comped )
			{
			 	$msg = '<p><strong>You have signed up for: ' . $varDesc . '</strong>  <br>
				    </p>';
				$varAmount = .01;
			}
			else
			if($success == 1 )
			{
				// get todays date
				$today = getdate();
				$year = $today['year'];
				$month = $today['mon'];
				$day   = $today['mday'];
				$today_text = sprintf("%s-%s-%s", $year, $month, $day);
				
			 	$msg = '<p>Your payment has been processed.  You will receive a receipt via email.<br/></p>';
				// send email receipt because Pay Pal doesn't do that.
				$email_msg = 
						'<p><img src="' . $logo_image_file . '" border="0" /></p>' . 
						'<p>========= GENERAL INFORMATION =========</p>' . 
						'Merchant : ' . $company_name .  
						'<br/>Date/Time : ' . $today_text . 
						'<p>========= ORDER INFORMATION =========</p>' . 
						'Description : ' . $varDescription . 
						'<br/>Total : ' . $varPayAmount . '(USD)' . 
						'<br/>Payment Method : ' . $varCardType  . 
						'<p>==== BILLING INFORMATION ===</p>' . 
						'First Name : ' . $firstName . 
						'<br/>Last Name : ' . $lastName .
						'<br/>Address : ' . $varAddress . 
						'<br/>City : ' . $varCity . 
						'<br/>State/Province : ' . $varState .
						'<br/>Zip/Postal Code : ' . $varZip .
						'<br/>Country : ' . $varCountry . 
						'<br/>Phone : ' . $varPhone . 
						'<br/>Email : ' . $varEmail;
					
					$varName = $company_name;
					include('notify.php');
					notify_client($varName, $varEmail, $email_msg, $receipt_email, $company_name);
					// notify comes to me from PayPal that you have cash!
					// also sending this for description
					notify_client($varName, $receipt_email, $email_msg, $receipt_email, $company_name);
			
			}
			else
			if( $success == 3)
			{
				$count=0;
				while (isset($resArray["L_SHORTMESSAGE".$count])) {		
				  $errorCode    = $resArray["L_ERRORCODE".$count];
				  $shortMessage = $resArray["L_SHORTMESSAGE".$count];
				  $longMessage  = $resArray["L_LONGMESSAGE".$count]; 
				  $count=$count+1; 
				  }
				  $msg = '<p>An error has occured<br/>' . $longMessage . '</p>';
			}

			// update database here			
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/page.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>AG DESIGN: Walnut Creek, CA</title>
<!-- InstanceEndEditable -->
<meta name="keywords" content="graphic design, graphic designer, Pleasant Hill, Concord, Walnut Creek, Martinez, Danville, San Ramon, Pleasanton, graphic services, logo design, branding, marketing, advertising, web design, web designer, Bay Area" />
		<meta name="description" content="AG Design is a creative design agency specializing in building effective communication strategies through fresh and creative design solutions. Founded by Arlene Santos in 2006, AG Design has quickly become the premiere choice among east bay graphic design firms. AG Design is located in Walnut Creek, CA and services companies throughout the Bay Area and nationally. Contact us at (925) 954-7084 to discuss your project today. " />
<script src="../js/jquery-1.4.4.min.js"></script>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="http://fast.fonts.com/jsapi/f1e61616-d676-4ba4-9f98-2945fb89f68a.js"></script>-->
<script type="text/javascript">
function processEmail ()
{
	window.location = "http://www.agdesigngroup.net/page_text.php?page_id=1038&email=" + document.inputGoForm.email.value;
};
</script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.style1 {
	color: #902147;
	font-weight: bold;
}
.txtPay { text-decoration: none; }
.style2 {font-weight: bold}
-->
        </style>
<!-- InstanceEndEditable -->
<script type="text/javascript">
var selectedArea = null;
function activate(e,f) {
    selectedArea = f ? e : null;
}
function menu(e) { 
    if (selectedArea)
	    alert('Access denied');
        // alert('Access denied1: ' + selectedArea.id); 
    else {
        // cross-browser case
        if (e.tagName == 'AREA')
		    alert('Access denied');
            // alert('Access denied2: ' + e.id); 
        else
            // alert('Access denied3: ' + e.tagName);
			 alert('Access denied');
    }
    return false; 
}
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21326556-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body <?php echo $bodyOnLoad; ?>>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td bgcolor="#C9C7C8" align="center">
<div id="pageContainer">
<table cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" align="center"><tr><td>
  <div id="mainNavDiv" class="mainNav">
    <table cellpadding="0" cellspacing="0" border="0" class="mainNavTable" align="left" >
    <tr>
    <td width="166"></td>
    <!-- generate main navigation -->
    	<?php
	  	/////////////////////////////////
      	// generate for main menu 
	  	for($num=0; $num<$varNumMain; $num++)
	  	{
			$i = $num * 4;
			
			$words = explode(" ", $main_nav[($i+2)], 1);
		?>
           <td width="132"><a href="#" class="mainMenu"><span class="mainMenuEm"><?php echo $words[0]; ?></span> <?php echo $words[1]; ?></a></td> 
           <?php if( $num < $varNumMain - 1 ) { ?>
		   <td width="14"></td>
           <?php } ?>
        <?php
	 	} 
	 	///////////////////////////////
		?>
        <!-- end generate main nav -->
    
    </tr>
    </table>
    
  </div>
  <!-- main content -->
  <div id="mainContent" >
 <!-- suppress right click -->
  <map id="Map0">
<area id="Area1" onfocus="activate(this,true)" onblur="activate(this,false)" 
    oncontextmenu="return menu(this)" shape="rect" coords="100, 50, 200, 150" href="..."/>
</map>
  <!-- InstanceBeginEditable name="pageContent" -->
  <div id="pageContent" >
  
  <table cellpadding="0" cellspacing="0" border="0">
  <tr>
  	<td colspan="2" height="40"><span class="pageTitle">Payments </span> </td>
  </tr>
  <tr><td colspan="2" height="20"></td></tr>
  <tr>
 	<td valign="top"><div id="pageNav" >  </div></td>
    <td valign="top">
    <div id="pageMainContent">
        
    <div class="txtPay">
        <!-- start pay form -->
        
      <form name="MainForm" id="MainForm" method="post" action="">
      <input type="hidden" name="x_version" value="3.1" />
      <input type="hidden" name="x_delim_data" value="TRUE"  />
      <input type="hidden" name="x_relay_response" value="FALSE" />
      <input type="hidden" name="x_amount" value="<?php echo $varPayAmount; ?>" >
      <input type="hidden" name="x_card_num" value="<?php echo $varCardNo; ?>" >
      <input type="hidden" name="x_exp_date" value="<?php echo $varCardExpMo . $varCardExpYr; ?>" >
      <input type="hidden" name="x_type" value="AUTH_CAPTURE" />
      <input type="hidden" name="x_first_name" value="<?php echo $varFirstName; ?>" />
      <input type="hidden" name="x_last_name" value="<?php echo $varLastName; ?>" />
      <input type="hidden" name="x_phone" value="<?php echo $varPhone; ?>" />
      <input type="hidden" name="x_email" value="<?php echo $varEmail; ?>" />
      <input type="hidden" name="x_email_customer" value="TRUE" />
              
      <input type="hidden" name="x_description" value="<?php echo $varDescription; ?>" >
      <input type="hidden" name="addr_change" value="<?php echo $addr_change; ?>" />
      <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" >
      <input type="hidden" name="member_id" value="<?php echo $member_id; ?>" >
      <input type="hidden" name="guest_id" value="<?php echo $guest_id; ?>" >
      <INPUT type="hidden" name="x_test_request" value="FALSE">

        <span align="left" class="pagesubtitle">You are making a payment to <span class="style1">AG Design Group Inc.</span>.</span>
        <?php if( $showResponse == 1 )
        {
        //	echo $resp;
            echo '<br/><br/>';
            echo $msg;
            if(	$success == 1 )
                echo '<h4>Thank you ' . $varFirstName . ' for your payment!</h4>';

            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            echo '<p>&nbsp;</p>';
            
            if( $LIVE_TESTING == 0 )
            {
                echo $test_msg;
            }
        }
        else
        {
		?>
        <table align="left" border="0" bordercolor="eeeeee" cellpadding="10">
        <tr>
        <td colspan="3">
<?php
            echo '<span class="style2" >';
            if( strlen($errorMsg) > 1 )
                echo '<font color="red"><br/><br/>' . $errorMsg . '<br/><br/></font>';
            echo '</span>';
                
        ?>					</td>
	</tr>
          
  <!-- main table start -->
    <tr><td colspan="3">
      <table align="left" cellpadding="1" cellspacing="0">
       <tr>
	      <td width="29%"><strong><font size="2" color="#2e2626">TRANSACTION</font></strong></td>
          <td height="20" colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td width="29%"><font size="1" color="#463a3a">TOTAL AMOUNT</strong></font></td>
              <td width="71%" colspan="2"><input tabindex="1" id="pay_amount" name="pay_amount" value="<?php echo $varPayAmount; ?>" size="20" maxlength="60" type="text"  onKeyUp="verifyNumber(this.form.pay_amount);"  /> </td>
              </tr>
              <tr>
          <td width="29%"><font size="1" color="#463a3a">DESCRIPTION</font></td>
              <td colspan="2"><input tabindex="2" id="description" name="description" value="<?php echo $varDescription; ?>" size="40" maxlength="60" type="text" /></a> </td>
        </tr>
        
        <tr>
          <td colspan="3"><div align="left"></div></td>
        </tr>
        <tr>
          <td width="29%"><font size="1" color="#463a3a"><strong>EMAIL</strong></font></td>
              <td colspan="2"><input tabindex="3" id="email" name="email" value="<?php echo $varEmail; ?>" size="40" maxlength="60" type="text" /> </td>
        </tr>
        <tr>
          <td width="29%"><font size="1" color="#463a3a"><strong>CONFIRM EMAIL</strong></font></td>
              <td colspan="2"><input tabindex="4" id="email_confirm" name="email_confirm" value="<?php echo $varEmail2; ?>" size="40" maxlength="60" type="text" /> </td>
       </tr>
        <tr>
	      <td width="29%" class="style1"><font size="2" color="#2e2626"><strong>PAYMENT</strong></font></td>
          <td height="20" colspan="2" >&nbsp;</td>
        </tr>
            
        <tr>
          <td width="29%"><font size="1" color="#463a3a"><strong>CREDIT CARD NO.</strong></font></td>
              <td colspan="2"> <input type="hidden" tabindex="5" name="card_no" id="card_no" value="<?php echo $varCardNo; ?>" size="20" maxlength="19" />          
            <input type="text" tabindex="6" name="display_no" id="display_no" value="<?php echo $varDisplayNo; ?>" size="20" maxlength="19" />	</td>
        </tr>
        <tr>
          <td width="29%"><font size="1" color="#463a3a"><strong><strong>EXPIRATION DATE (mm/yy)</strong></strong></font></td>
              <td colspan="2">
              <select tabindex="7" name="cardExpMo" id="cardExpMo" style="width:75;">
                <option value=""> </option>
                <option value="01" <?php if($varCardExpMo == '01') echo ' selected="selected" '; ?>>01 </option>
                <option value="02" <?php if($varCardExpMo == '02') echo ' selected="selected" '; ?>>02 </option>
                <option value="03" <?php if($varCardExpMo == '03') echo ' selected="selected" '; ?>>03 </option>
                <option value="04" <?php if($varCardExpMo == '04') echo ' selected="selected" '; ?>>04 </option>
                <option value="05" <?php if($varCardExpMo == '05') echo ' selected="selected" '; ?>>05 </option>
                <option value="06" <?php if($varCardExpMo == '06') echo ' selected="selected" '; ?>>06 </option>
                <option value="07" <?php if($varCardExpMo == '07') echo ' selected="selected" '; ?>>07 </option>
                <option value="08" <?php if($varCardExpMo == '08') echo ' selected="selected" '; ?>>08 </option>
                <option value="09" <?php if($varCardExpMo == '09') echo ' selected="selected" '; ?>>09 </option>
                <option value="10" <?php if($varCardExpMo == '10') echo ' selected="selected" '; ?>>10 </option>
                <option value="11" <?php if($varCardExpMo == '11') echo ' selected="selected" '; ?>>11 </option>
                <option value="12" <?php if($varCardExpMo == '12') echo ' selected="selected" '; ?>>12 </option>
                </select>
                &nbsp;
                  <?php 
				  $year = date("y");
                 // echo 'year: ' . $varCardExpYr;
				  ?>
                  <select tabindex="7" name="cardExpYr" id="cardExpYr" style="width:75;">
                    <option value=""> </option>
                <?php
		
				  $ten_years = $year + 10;
				  for($yr=$year; $yr < $ten_years; $yr++)
				  {
				  	echo  '<option value="' . $yr . '"';
					if($varCardExpYr == $yr) echo ' selected="selected" ';
					echo '>' . $yr . '</option>';

				  }
				  ?>
                  </select>         </td>
            </tr>
            
            <tr>
              <td ><font size="1" color="#463a3a"><strong>CREDIT CARD TYPE</strong></font></td>
              <td colspan="2"><select tabindex="9" name="cardtype" id="cardtype" >
           <option value="Visa" <?php if($varCardType == 'Visa') echo ' selected="selected" '; ?>>Visa</option>
           <option value="MasterCard" <?php if($varCardType == 'MasterCard') echo ' selected="selected" '; ?>>MasterCard</option>
           <option value="Discover" <?php if($varCardType == 'Discover') echo ' selected="selected" '; ?>>Discover</option>
           <option value="Amex" <?php if($varCardType == 'Amex') echo ' selected="selected" '; ?>>Amex</option>

         </select></td>
            </tr>
           <tr>
              <td ><font size="1" color="#463a3a"><strong> VERIFICATION NO.</strong></font></td>
          <td colspan="2">  <input name="cvv2Number" type="text" id="cvv2Number" tabindex="10" value="<?php echo $cvv2Number; ?>" size="5" maxlength="5" /> </td>
            </tr>  
        <tr>
	      <td width="29%" class="style1"><font size="2" color="#2e2626"><strong>BILLING INFORMATION</strong></font></td>
          <td height="20" colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td><font size="1" color="#463a3a"><strong>FIRST NAME</strong></font></td>
              <td colspan="2"><input name="first_name" type="text" id="first_name" tabindex="11" value="<?php echo $varFirstName; ?>" size="20" maxlength="30"  /> </td>
        </tr>
        <tr>
          <td ><font size="1" color="#463a3a"><strong>LAST NAME</strong></font></td>
              <td colspan="2"><input name="last_name" type="text" id="last_name" tabindex="12" value="<?php echo $varLastName; ?>" size="20" maxlength="30"   /> </td>
       </tr>
        <tr>
          <td colspan="1" valign="bottom" height="20"><font size="1" color="#463a3a"><strong>ADDRESS</strong> </font></td>
          <td colspan="2" align="left"><input tabindex="13" name="address" value="<?php echo $varAddress; ?>" size="20" maxlength="30" type="text"   />            </td>
       </tr>
       <tr>
          <td ><font size="1" color="#463a3a"><strong>CITY</strong> </font></td>
              <td colspan="2" ><input tabindex="14" name="city" id="city" value="<?php echo $varCity; ?>" size="20" maxlength="30" type="text"   /> </td>
            </tr>
       <tr>
          <td ><font size="1" color="#463a3a"><strong>STATE</strong> </font></td>
              <td colspan="2">
              
                            <select tabindex="15" name="state" id="state"  onchange="addrChange(this.form.addr_change);">
                <option value="" >&nbsp; </option>
                <option value="--"<?php if($varState == '--') echo ' selected="selected" '; ?>>Outside U.S./Canada </option>
                <option value="AA"<?php if($varState == 'AA') echo ' selected="selected" '; ?>>AA - Armed Forces Americas </option>
                <option value="AB"<?php if($varState == 'AB') echo ' selected="selected" '; ?>>AB - Alberta </option>
                <option value="AE"<?php if($varState == 'AE') echo ' selected="selected" '; ?>>AE - Armed Forces </option>
                <option value="AK"<?php if($varState == 'AK') echo ' selected="selected" '; ?>>AK - Alaska </option>
                <option value="AL"<?php if($varState == 'AL') echo ' selected="selected" '; ?>>AL - Alabama </option>
                <option value="AP"<?php if($varState == 'AP') echo ' selected="selected" '; ?>>AP - Armed Forces Pacific </option>
                <option value="AR"<?php if($varState == 'AR') echo ' selected="selected" '; ?>>AR - Arkansas </option>
                <option value="AS"<?php if($varState == 'AS') echo ' selected="selected" '; ?>>AS - American Samoa </option>
                <option value="AZ"<?php if($varState == 'AZ') echo ' selected="selected" '; ?>>AZ - Arizona </option>
                <option value="BC"<?php if($varState == 'BC') echo ' selected="selected" '; ?>>BC - British Columbia </option>
                <option value="CA"<?php if($varState == 'CA') echo ' selected="selected" '; ?>>CA - California </option>
                <option value="CO"<?php if($varState == 'CO') echo ' selected="selected" '; ?>>CO - Colorado </option>
                <option value="CT"<?php if($varState == 'CT') echo ' selected="selected" '; ?>>CT - Connecticut </option>
                <option value="DC"<?php if($varState == 'DC') echo ' selected="selected" '; ?>>DC - District of Columbia </option>
                <option value="DE"<?php if($varState == 'DE') echo ' selected="selected" '; ?>>DE - Delaware </option>
                <option value="FL"<?php if($varState == 'FL') echo ' selected="selected" '; ?>>FL - Florida </option>
                <option value="FM"<?php if($varState == 'FM') echo ' selected="selected" '; ?>>FM - Federated States of Micronesia </option>
                <option value="GA"<?php if($varState == 'GA') echo ' selected="selected" '; ?>>GA - Georgia </option>
                <option value="GU"<?php if($varState == 'GU') echo ' selected="selected" '; ?>>GU - Guam </option>
                <option value="HI"<?php if($varState == 'HI') echo ' selected="selected" '; ?>>HI - Hawaii </option>
                <option value="IA"<?php if($varState == 'IA') echo ' selected="selected" '; ?>>IA - Iowa </option>
                <option value="ID"<?php if($varState == 'ID') echo ' selected="selected" '; ?>>ID - Idaho </option>
                <option value="IL"<?php if($varState == 'IL') echo ' selected="selected" '; ?>>IL - Illinois </option>

                <option value="IN"<?php if($varState == 'IN') echo ' selected="selected" '; ?>>IN - Indiana </option>
                <option value="KS"<?php if($varState == 'KS') echo ' selected="selected" '; ?>>KS - Kansas </option>
                <option value="KY"<?php if($varState == 'KY') echo ' selected="selected" '; ?>>KY - Kentucky </option>
                <option value="LA"<?php if($varState == 'LA') echo ' selected="selected" '; ?>>LA - Louisiana </option>
                <option value="MA"<?php if($varState == 'MA') echo ' selected="selected" '; ?>>MA - Massachusetts </option>
                <option value="MB"<?php if($varState == 'MB') echo ' selected="selected" '; ?>>MB - Manitoba </option>
                <option value="MD"<?php if($varState == 'MD') echo ' selected="selected" '; ?>>MD - Maryland </option>
                <option value="ME"<?php if($varState == 'ME') echo ' selected="selected" '; ?>>ME - Maine </option>
                <option value="MH"<?php if($varState == 'MH') echo ' selected="selected" '; ?>>MH - Marshall Islands </option>
                <option value="MI"<?php if($varState == 'MI') echo ' selected="selected" '; ?>>MI - Michigan </option>
                <option value="MN"<?php if($varState == 'MN') echo ' selected="selected" '; ?>>MN - Minnesota </option>
                <option value="MO"<?php if($varState == 'MO') echo ' selected="selected" '; ?>>MO - Missouri </option>
                <option value="MP"<?php if($varState == 'MP') echo ' selected="selected" '; ?>>MP - Northern Mariana Islands </option>
                <option value="MS"<?php if($varState == 'MS') echo ' selected="selected" '; ?>>MS - Mississippi </option>
                <option value="MT"<?php if($varState == 'MT') echo ' selected="selected" '; ?>>MT - Montana </option>
                <option value="NB"<?php if($varState == 'NB') echo ' selected="selected" '; ?>>NB - New Brunswick </option>
                <option value="NC"<?php if($varState == 'NC') echo ' selected="selected" '; ?>>NC - North Carolina </option>
                <option value="ND"<?php if($varState == 'ND') echo ' selected="selected" '; ?>>ND - North Dakota </option>
                <option value="NE"<?php if($varState == 'NE') echo ' selected="selected" '; ?>>NE - Nebraska </option>
                <option value="NF"<?php if($varState == 'NF') echo ' selected="selected" '; ?>>NF - Newfoundland </option>
                <option value="NH"<?php if($varState == 'NH') echo ' selected="selected" '; ?>>NH - New Hampshire </option>
                <option value="NJ"<?php if($varState == 'NJ') echo ' selected="selected" '; ?>>NJ - New Jersey </option>
                <option value="NM"<?php if($varState == 'NM') echo ' selected="selected" '; ?>>NM - New Mexico </option>
                <option value="NS"<?php if($varState == 'NS') echo ' selected="selected" '; ?>>NS - Nova Scotia </option>
                <option value="NT"<?php if($varState == 'NT') echo ' selected="selected" '; ?>>NT - Northwest Territories </option>
                <option value="NV"<?php if($varState == 'NV') echo ' selected="selected" '; ?>>NV - Nevada </option>
                <option value="NY"<?php if($varState == 'NY') echo ' selected="selected" '; ?>>NY - New York </option>
                <option value="OH"<?php if($varState == 'OH') echo ' selected="selected" '; ?>>OH - Ohio </option>
                <option value="OK"<?php if($varState == 'OK') echo ' selected="selected" '; ?>>OK - Oklahoma </option>
                <option value="ON"<?php if($varState == 'ON') echo ' selected="selected" '; ?>>ON - Ontario </option>
                <option value="OR"<?php if($varState == 'OR') echo ' selected="selected" '; ?>>OR - Oregon </option>
                <option value="PA"<?php if($varState == 'PA') echo ' selected="selected" '; ?>>PA - Pennsylvania </option>
                <option value="PE"<?php if($varState == 'PE') echo ' selected="selected" '; ?>>PE - Prince Edward Island </option>
                <option value="PR"<?php if($varState == 'PR') echo ' selected="selected" '; ?>>PR - Puerto Rico </option>
                <option value="PW"<?php if($varState == 'PW') echo ' selected="selected" '; ?>>PW - Palau </option>
                <option value="QC"<?php if($varState == 'QC') echo ' selected="selected" '; ?>>QC - Quebec </option>
                <option value="RI"<?php if($varState == 'RI') echo ' selected="selected" '; ?>>RI - Rhode Island </option>
                <option value="SC"<?php if($varState == 'SC') echo ' selected="selected" '; ?>>SC - South Carolina </option>
                <option value="SD"<?php if($varState == 'SD') echo ' selected="selected" '; ?>>SD - South Dakota </option>
                <option value="SK"<?php if($varState == 'SK') echo ' selected="selected" '; ?>>SK - Saskatchewan </option>
                <option value="TN"<?php if($varState == 'TN') echo ' selected="selected" '; ?>>TN - Tennessee </option>
                <option value="TX"<?php if($varState == 'TX') echo ' selected="selected" '; ?>>TX - Texas </option>
                <option value="UT"<?php if($varState == 'UT') echo ' selected="selected" '; ?>>UT - Utah </option>
                <option value="VA"<?php if($varState == 'VA') echo ' selected="selected" '; ?>>VA - Virginia </option>
                <option value="VI"<?php if($varState == 'VI') echo ' selected="selected" '; ?>>VI - Virgin Islands </option>
                <option value="VT"<?php if($varState == 'VT') echo ' selected="selected" '; ?>>VT - Vermont </option>
                <option value="WA"<?php if($varState == 'WA') echo ' selected="selected" '; ?>>WA - Washington </option>
                <option value="WI"<?php if($varState == 'WI') echo ' selected="selected" '; ?>>WI - Wisconsin </option>
                <option value="WV"<?php if($varState == 'WV') echo ' selected="selected" '; ?>>WV - West Virginia </option>
                <option value="WY"<?php if($varState == 'WY') echo ' selected="selected" '; ?>>WY - Wyoming </option>
                <option value="YT"<?php if($varState == 'YT') echo ' selected="selected" '; ?>>YT - Yukon </option>
                </select>  </td>
        </tr>
        <tr>
          <td><font size="1" color="#463a3a"><strong>ZIP OR POSTAL</strong></font></td>
          <td colspan="2" align="left"><input tabindex="16" name="zip" id="zip" value="<?php echo $varZip; ?>" size="20" maxlength="30" type="text"   /></td>
        </tr>
        <tr>
              <td ><font size="1" color="#463a3a"><strong>COUNTRY</strong> </font></td>
               <td colspan="2" align="left">
                 <select tabindex="17" name="country" onchange="addrChange(this.form.addr_change);">
                   <option value="AD">Andorra </option>
                   <option value="AE">United Arab Emirates </option>
                   <option value="AF">Afghanistan </option>
                   <option value="AG">Antigua And Barbuda </option>
                   <option value="AI">Anguilla </option>
                   <option value="AL">Albania </option>
                   <option value="AM">Armenia </option>
                   <option value="AN">Netherlands Antilles </option>
                   <option value="AO">Angola </option>
                   <option value="AQ">Antarctica </option>
                   <option value="AR">Argentina </option>
                   <option value="AS">American Samoa </option>
                   <option value="AT">Austria </option>
                   <option value="AU">Australia </option>
                   <option value="AW">Aruba </option>
                   <option value="AZ">Azerbaijan </option>
                   <option value="BA">Bosnia And Herzegovina </option>
                   <option value="BB">Barbados </option>
                   <option value="BD">Bangladesh </option>
                   <option value="BE">Belgium </option>
                   <option value="BF">Burkina Faso </option>
                   <option value="BG">Bulgaria </option>
                   <option value="BH">Bahrain </option>
                   <option value="BI">Burundi </option>
                   <option value="BJ">Benin </option>
                   <option value="BM">Bermuda </option>
                   <option value="BN">Brunei Darussalam </option>
                   <option value="BO">Bolivia </option>
                   <option value="BR">Brazil </option>
                   <option value="BS">Bahamas </option>
                   <option value="BT">Bhutan </option>
                   <option value="BV">Bouvet Island </option>
                   <option value="BW">Botswana </option>
                   <option value="BY">Belarus </option>
                   <option value="BZ">Belize </option>
                   <option value="CA">Canada </option>
                   <option value="CC">Cocos Keeling Islands </option>
                   <option value="CD">Congo, D.P.R </option>
                   <option value="CF">Central African Republic </option>
                   <option value="CG">Congo </option>
                   <option value="CH">Switzerland </option>
                   <option value="CI">C&Ugrave;te D`ivoire </option>
                   <option value="CK">Cook Islands </option>
                   <option value="CL">Chile </option>
                   <option value="CM">Cameroon </option>
                   <option value="CN">China </option>
                   <option value="CO">Colombia </option>
                   <option value="CR">Costa Rica </option>
                   <option value="CU">Cuba </option>
                   <option value="CV">Cape Verde </option>
                   <option value="CX">Christmas Island </option>
                   <option value="CY">Cyprus </option>
                   <option value="CZ">Czech Republic </option>
                   <option value="DE">Germany </option>
                   <option value="DJ">Djibouti </option>
                   <option value="DK">Denmark </option>
                   <option value="DM">Dominica </option>
                   <option value="DO">Dominican Republic </option>
                   <option value="DZ">Algeria </option>
                   <option value="EC">Ecuador </option>
                   <option value="EE">Estonia </option>
                   <option value="EG">Egypt </option>
                   <option value="EH">Western Sahara </option>
                   <option value="ER">Eritrea </option>
                   <option value="ES">Spain </option>
                   <option value="ET">Ethiopia </option>
                   <option value="FI">Finland </option>
                   <option value="FJ">Fiji </option>
                   <option value="FK">Falkland Islands Malvinas </option>
                   <option value="FM">Micronesia </option>
                   <option value="FO">Faroe Islands </option>
                   <option value="FR">France </option>
                   <option value="GA">Gabon </option>
                   <option value="GB">United Kingdom </option>
                   <option value="GD">Grenada </option>
                   <option value="GE">Georgia </option>
                   <option value="GF">French Guiana </option>
                   <option value="GH">Ghana </option>
                   <option value="GI">Gibraltar </option>
                   <option value="GL">Greenland </option>
                   <option value="GM">Gambia </option>
                   <option value="GN">Guinea </option>
                   <option value="GP">Guadeloupe </option>
                   <option value="GQ">Equatorial Guinea </option>
                   <option value="GR">Greece </option>
                   <option value="GS">South Georgia/Sandwich Islands </option>
                   <option value="GT">Guatemala </option>
                   <option value="GU">Guam </option>
                   <option value="GW">Guinea-bissau </option>
                   <option value="GY">Guyana </option>
                   <option value="HK">Hong Kong </option>
                   <option value="HM">Heard And McDonald Islands </option>
                   <option value="HN">Honduras </option>
                   <option value="HR">Croatia </option>
                   <option value="HT">Haiti </option>
                   <option value="HU">Hungary </option>
                   <option value="ID">Indonesia </option>
                   <option value="IE">Ireland </option>
                   <option value="IL">Israel </option>
                   <option value="IN">India </option>
                   <option value="IO">British Indian Ocean Territory </option>
                   <option value="IQ">Iraq </option>
                   <option value="IR">Iran, Islamic Republic Of </option>
                   <option value="IS">Iceland </option>
                   <option value="IT">Italy </option>
                   <option value="JM">Jamaica </option>
                   <option value="JO">Jordan </option>
                   <option value="JP">Japan </option>
                   <option value="KE">Kenya </option>
                   <option value="KG">Kyrgyzstan </option>
                   <option value="KH">Cambodia </option>
                   <option value="KI">Kiribati </option>
                   <option value="KM">Comoros </option>
                   <option value="KN">Saint Kitts And Nevis </option>
                   <option value="KP">Korea, D.P.R. </option>
                   <option value="KR">Korea, Republic Of </option>
                   <option value="KW">Kuwait </option>
                   <option value="KY">Cayman Islands </option>
                   <option value="KZ">Kazakstan </option>
                   <option value="LA">Lao </option>
                   <option value="LB">Lebanon </option>
                   <option value="LC">Saint Lucia </option>
                   <option value="LI">Liechtenstein </option>
                   <option value="LK">Sri Lanka </option>
                   <option value="LR">Liberia </option>
                   <option value="LS">Lesotho </option>
                   <option value="LT">Lithuania </option>
                   <option value="LU">Luxembourg </option>
                   <option value="LV">Latvia </option>
                   <option value="LY">Libyan Arab Jamahiriya </option>
                   <option value="MA">Morocco </option>
                   <option value="MC">Monaco </option>
                   <option value="MD">Moldova, Republic Of </option>
                   <option value="MG">Madagascar </option>
                   <option value="MH">Marshall Islands </option>
                   <option value="MK">Macedonia </option>
                   <option value="ML">Mali </option>
                   <option value="MM">Myanmar </option>
                   <option value="MN">Mongolia </option>
                   <option value="MO">Macau </option>
                   <option value="MP">Northern Mariana Islands </option>
                   <option value="MQ">Martinique </option>
                   <option value="MR">Mauritania </option>
                   <option value="MS">Montserrat </option>
                   <option value="MT">Malta </option>
                   <option value="MU">Mauritius </option>
                   <option value="MV">Maldives </option>
                   <option value="MW">Malawi </option>
                   <option value="MX">Mexico </option>
                   <option value="MY">Malaysia </option>
                   <option value="MZ">Mozambique </option>
                   <option value="NA">Namibia </option>
                   <option value="NC">New Caledonia </option>
                   <option value="NE">Niger </option>
                   <option value="NF">Norfolk Island </option>
                   <option value="NG">Nigeria </option>
                   <option value="NI">Nicaragua </option>
                   <option value="NL">Netherlands </option>
                   <option value="NO">Norway </option>
                   <option value="NP">Nepal </option>
                   <option value="NR">Nauru </option>
                   <option value="NU">Niue </option>
                   <option value="NZ">New Zealand </option>
                   <option value="OM">Oman </option>
                   <option value="PA">Panama </option>
                   <option value="PE">Peru </option>
                   <option value="PF">French Polynesia </option>
                   <option value="PG">Papua New Guinea </option>
                   <option value="PH">Philippines </option>
                   <option value="PK">Pakistan </option>
                   <option value="PL">Poland </option>
                   <option value="PM">Saint Pierre And Miquelon </option>
                   <option value="PN">Pitcairn </option>
                   <option value="PR">Puerto Rico </option>
                   <option value="PS">Palestine </option>
                   <option value="PT">Portugal </option>
                   <option value="PW">Palau </option>
                   <option value="PY">Paraguay </option>
                   <option value="QA">Qatar </option>
                   <option value="RE">R&Egrave;union </option>
                   <option value="RO">Romania </option>
                   <option value="RU">Russian Federation </option>
                   <option value="RW">Rwanda </option>
                   <option value="SA">Saudi Arabia </option>
                   <option value="SB">Solomon Islands </option>
                   <option value="SC">Seychelles </option>
                   <option value="SD">Sudan </option>
                   <option value="SE">Sweden </option>
                   <option value="SG">Singapore </option>
                   <option value="SH">Saint Helena </option>
                   <option value="SI">Slovenia </option>
                   <option value="SJ">Svalbard And Jan Mayen </option>
                   <option value="SK">Slovakia </option>
                   <option value="SL">Sierra Leone </option>
                   <option value="SM">San Marino </option>
                   <option value="SN">Senegal </option>
                   <option value="SO">Somalia </option>
                   <option value="SR">Suriname </option>
                   <option value="ST">Sao Tome And Principe </option>
                   <option value="SV">El Salvador </option>
                   <option value="SY">Syrian Arab Republic </option>
                   <option value="SZ">Swaziland </option>
                   <option value="TC">Turks And Caicos Islands </option>
                   <option value="TD">Chad </option>
                   <option value="TF">French Southern Territories </option>
                   <option value="TG">Togo </option>
                   <option value="TH">Thailand </option>
                   <option value="TJ">Tajikistan </option>
                   <option value="TK">Tokelau </option>
                   <option value="TM">Turkmenistan </option>
                   <option value="TN">Tunisia </option>
                   <option value="TO">Tonga </option>
                   <option value="TP">East Timor </option>
                   <option value="TR">Turkey </option>
                   <option value="TT">Trinidad And Tobago </option>
                   <option value="TV">Tuvalu </option>
                   <option value="TW">Taiwan </option>
                   <option value="TZ">Tanzania, United Republic Of </option>
                   <option value="UA">Ukraine </option>
                   <option value="UG">Uganda </option>
                   <option value="UM">US Minor Outlying Islands </option>
                   <option selected="selected" value="US">United States </option>
                   <option value="UY">Uruguay </option>
                   <option value="UZ">Uzbekistan </option>
                   <option value="VA">Vatican City </option>
                   <option value="VC">St Vincent/Grenadines </option>
                   <option value="VE">Venezuela </option>
                   <option value="VG">Virgin Islands, British </option>
                   <option value="VI">Virgin Islands, U.S. </option>
                   <option value="VN">Vietnam </option>
                   <option value="VU">Vanuatu </option>
                   <option value="WF">Wallis And Futuna </option>
                   <option value="WS">Samoa </option>
                   <option value="YE">Yemen </option>
                   <option value="YT">Mayotte </option>
                   <option value="YU">Yugoslavia </option>
                   <option value="ZA">South Africa </option>
                   <option value="ZM">Zambia </option>
                   <option value="ZW">Zimbabwe </option>
                   </select>          </td>
        </tr>
        <tr>
          <td height="20" colspan="1" valign="bottom"><font size="1" color="#463a3a"><strong>PHONE</strong> </font></td>
           <td colspan="2" valign="middle" class="notes"><input name="phone" tabindex="18" type="text" id="phone" maxlength="20" value="<?php echo $varPhone; ?>"    />   &nbsp;&nbsp;           (xxx)xxx-xxxx</td>
        </tr>
        
        <tr>
          <td valign="middle" class="notes" colspan="3">
            <hr align="left" size="1" color="#dddddd"/>           </td>
        </tr>
        <tr>
           <td> <div align="left"></div></td>
           <td colspan="2">
            <div align="left">
                <input tabindex="19" name="Submit" id="Submit" value="Submit Payment" type="submit" />
                <br />
                <br />
              Once you click on the &quot;Submit Payment&quot; button the authorization process will begin.<br />
              <br />
              If no response, wait at least 30 seconds before resubmitting to avoid duplicate charges. 
           </div></td>
	    </tr>
        </table>
  
   </td></tr></table>
  <!-- main table end -->
        <?php	} ?>
     
   
      </form>                   <!-- end pay form -->
                         </div>
        </div>
    </td></tr></table>    
    <div id="footer">
 <?php include("../includes/footer.php"); ?>
    </div>
    
    
  </div>
  <!-- InstanceEndEditable --></div>
  <!-- end main content -->
</td></tr></table>
    <div id="subNavDiv" class="subNav">
 <table  border="0" align="left" cellpadding="0" cellspacing="0" class="subNavTable" >
    <tr>
   
    <td width="167"></td>
     <?php
		  /////////////////////////////////
		  // generate for main menu 
		  $col = 0;
		  for($num=0; $num<$varNumMain; $num++)
		  {
		  	$col ++;
			$i = $num * 4;
			?>
		    <td width="132" valign="top">
            <br/>
        	<?php
			///////////////////////////////////
			// now get any sub navigation
        	$sub_nav = $main_nav[($i+3)];
			//print_r($sub_nav);
			if( sizeof($sub_nav) > 0 )
			{
				$first_time = true;
				for($num2=0; $num2< ((sizeof($sub_nav))/3); $num2++)
				{
					$i2 = $num2 * 3;
					$name = str_replace("'","",$sub_nav[($i2+2)]); 
					$name = str_replace(" ","_",$name); 
					?>
					
					<a href="../<?php echo $sub_nav[($i2+1)]; ?>" class="subMenu"><?php echo $sub_nav[($i2+2)]; ?></a>
					
					<?php 
					if( $num2 < (((sizeof($sub_nav))/3)-1) )
					{ 
					?>
					<img src="../images2/menu_dots.jpg" width="86" height="2" alt="" />
					<?php 
					} 
				}
			}
			
			if( $col == 4 )
			{
			?>
            <img src="images2/menu_dots.jpg" width="86" height="2" alt="" />
	        <div style="margin-top:8px;">
    	    <a href="http://www.linkedin.com/company/970221" target="_blank"><img src="images2/buttons/linkedin.jpg" style="float:left;margin-left:0px;" border="0" alt="AG on LinkedIn"/></a><a href="http://www.facebook.com/agdesigngroup" target="_blank"><img src="images2/buttons/facebook.jpg" style="float:left; margin-left:6px;" border="0" alt="AG on Facebook" /></a><a href="http://twitter.com/AGDesignGroup" target="_blank"><img src="images2/buttons/twitter.jpg" style="float:left; margin-left:6px;" border="0" alt="AG on Twitter" /></a><a href="http://www.youtube.com/agdesigngroupinc" target="_blank"><img src="images2/buttons/youtube.png" alt="youtube" width="40" height="20"  style="float:left; margin-left:6px;" /></a>  
        	</div>
			<?php			
			}
			?>
			</td>
    		<td width="14"></td>
			<?php 
		 } 
		 ///////////////////////////////
		 ?>   

    <td width="244" valign="top">
    <div align="right" style="margin-right:12px;">
    <img src="../images2/increase_brand_iq.jpg" alt="Learn how to increase your brand IQ" width="214" height="50"  /> 
    <br/>  
     <div id="inputGo">
      <div align="left">
         <form id="inputGoForm" name="inputGoForm" method="post" action="">
         &nbsp;<input name="email" type="text" value="Enter Email Address" />
         </form>
         <div id="btnGo"><a href="#" onclick="processEmail();"><img src="../images2/buttons/btn_go.jpg" width="34" height="20" border="0" /></a>  </div>
       </div>
     </div>
     </div>
    </td>
    </tr></table>
  </div>
  <div id="AGlogo"><a href="../index.php"><img src="../images2/AG_design_logo.png" alt="AG Design" width="74" height="74" border="0" /></a></div>
</div> 
</td>
</tr></table>
<script>

$(window).resize(function() {
	resizeMainContent();
});

$(window).scroll(function () { 
	resizeMainContent();
});

function resizeMainContent()
{
	//alert($(window).height() - $('div #mainNavDiv').height());
	//if( ($(window).height() - $('div #mainNavDiv').height()) > 800 )
	$('div #mainContent').height(($(window).height() - $('div #mainNavDiv').height())); 
}
resizeMainContent();


//alert("number of divs: " + $('div').length);
$('div .subNav').hide();

// if click on main menu item, show sub nav
$('a').filter('.mainMenu').mouseover(function () {
		$("div").find('#subNavDiv').slideDown("slow");
});

// if click on sub nav, hide sub nav
$('a').filter('.subMenu').click(function () {
		$("div").find(".subNav").slideUp("fast");
});

$('div #subNavDiv').mouseleave(function () {
	$("div").find(".subNav").slideUp("slow");
});
</script>
</body>
<!-- InstanceEnd --></html>
