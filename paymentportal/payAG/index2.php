<?php 
include ("global.php");
// require_once("../notify.php");

$LIVE_TESTING = 1;  // 1 = live, 0 = testing
$LIVE_DATABASE = 0;  // 1 = live, 0 = testing

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
	else
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
	else
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
			if( $Comped == false  )
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
				$creditCardType 	= 'Visa'; // urlencode( $_POST['creditCardType']);
				$creditCardNumber 	= $varCardNo;
				$expDateMonth 		= urlencode( $_POST['cardExpMo']);
				// Month must be padded with leading zero
				$padDateMonth 		= str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
				$expDateYear 		= urlencode( $_POST['cardExpYr']);
				$cvv2Number 		= '673'; // urlencode($_POST['cvv2Number']);
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
				$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
				"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
				
				// echo '<br/>' . $nvpstr . '<br/>';
				
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
								
			if($Comped )
			{
			 	$msg = '<p><strong>You have signed up for: ' . $varDesc . '</strong>  <br>
				    </p>';
				$varAmount = .01;
			}
			else
			if($success == 1 )
			{
			 	$msg = '<p>Your payment has been processed.  You will receive a receipt via email.<br/></p>';
				// send email receipt because Pay Pal doesn't do that.
				$email_msg = 
						'<p><img src="' . $logo_image_file . '" border="0" /></p>' . 
						'<p>========= GENERAL INFORMATION =========</p>' . 
						'Merchant : ' . $company_name .  
						'<br/>Date/Time : ' . $today . 
						'<p>========= ORDER INFORMATION =========</p>' . 
						'Description : ' . $varDescription . 
						'<br/>Total : ' . $varPayAmount . '(USD)' . 
						'<br/>Payment Method : ' . $creditCardType . 
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
				  $msg = '<p>' . $longMessage . '</p>';
			}

			// update database here			
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Adobe GoLive" />
		<meta name="keywords" content="94521, AG Design, AG Design Group, Ganancial Design, Arlene Ganancial, Arlene Santos, Graphic Design, Graphic Artist, Packaging, Marketing, Branding, Advertising, Websites, California, East Bay, San Francisco, Walnut Creek, Concord, Pleasant Hill, Clayton" />
		<meta name="description" content="AG Design is a full service graphic design firm specializing in building better branding for companies." />
		<title>AG DESIGN</title>
		<link href="../css/basic.css" rel="stylesheet" type="text/css" media="all" />
        <style type="text/css">
       .main { color: #282828; font-size: 11px; font-family: Helvetica, Geneva, Arial, SunSans-Regular, 		sans-serif; line-height: 14px; text-decoration: none; margin-top: 5px; margin-right: 25px; margin-left: 25px; }

		</style>
        
			<SCRIPT LANGUAGE="JavaScript">
		<!--//Code generated by the Arlene G. Santos ©1999 referenced jhs.com-->
    	if (document.images) {
        	image1on = new Image();
        	image1on.src = "../links/company-on.gif"; 

        	image2on = new Image();
        	image2on.src = "../links/services-on.gif"; 
	
    	    image3on = new Image();
       		image3on.src = "../links/portfolio-on.gif"; 

       		image4on = new Image();
        	image4on.src = "../links/clients-on.gif"; 
        	
        	image5on = new Image();
        	image5on.src = "../links/contact-on.gif"; 
	
    	    image6on = new Image();
       		image6on.src = "../links/home-on.gif"; 

       		image7on = new Image();
        	image7on.src = "../images/img-homeOvr.gif"; 
	
    	    image8on = new Image();
       		image8on.src = "../links/quote-on.gif";         	

        	image1off = new Image();
        	image1off.src = "../links/company-off.gif"; 

        	image2off = new Image();
        	image2off.src = "../links/services-off.gif"; 
	
    	    image3off = new Image();
       		image3off.src = "../links/portfolio-off.gif"; 

       		image4off = new Image();
        	image4off.src = "../links/clients-off.gif"; 
        	
        	image5off = new Image();
        	image5off.src = "../links/contact-off.gif"; 
	
    	    image6off = new Image();
       		image6off.src = "../links/home-off.gif"; 

       		image7off = new Image();
        	image7off.src = "../images/img-home2.jpg"; 
	
    	    image8off = new Image();
       		image8off.src = "../links/quote-off.gif";       	

		}

			function turnOn(imageName) {
    		if (document.images) {
        	document[imageName].src = eval(imageName + "on.src");
    	}
	}

			function turnOff(imageName) {
 		   	if (document.images) {
        	document[imageName].src = eval(imageName + "off.src");
    	}
	}
	</script>
    <script type="text/javascript" src="../verifyNumber.js"></script>
	</head>

	<body>
		<div align="center">
		<table width="744" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" valign="top">
					<table width="744" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top" width="166"></td>
								<td align="left" valign="top" width="243"><img src="../images/spr-top.gif" alt="" height="28" width="243" border="0" /></td>
								<td align="left" valign="top" width="65"></td>
								<td align="left" valign="top" width="63"></td>
								<td align="left" valign="top" width="65"></td>
								<td align="left" valign="top" width="54"></td>
								<td align="left" valign="top" width="60"></td>
								<td align="left" valign="top" width="28"></td>
							</tr>
							<tr>
							<td align="left" valign="top" width="166"><a href="../index.html"><img src="../images/logo.gif" alt="" height="28" width="166" border="0" /></a></td>
							<td align="left" valign="top" width="243"><img src="../images/spr-top.gif" alt="" height="28" width="243" border="0" /></td>
							<td align="left" valign="top" width="65"><a href="http://www.agdesigngroup.net/company.html" onmouseover="turnOn('image1')" onmouseout="turnOff('image1')"><img name="image1" src="../links/company-off.gif" alt="" width="65" height="28" border="0" /></td>
							<td align="left" valign="top" width="63"><a href="http://www.agdesigngroup.net/services.html" onmouseover="turnOn('image2')" onmouseout="turnOff('image2')"><img name="image2" src="../links/services-off.gif" alt="" width="63" height="28" border="0" /></td>
							<td align="left" valign="top" width="65"><a href="http://www.agdesigngroup.net/portfolio.html" onmouseover="turnOn('image3')" onmouseout="turnOff('image3')"><img name="image3" src="../links/portfolio-off.gif" alt="" width="65" height="28" border="0" /></td>
							<td align="left" valign="top" width="54"><a href="http://www.agdesigngroup.net/clients.html" onmouseover="turnOn('image4')" onmouseout="turnOff('image4')"><img name="image4" src="../links/clients-off.gif" alt="" width="54" height="28" border="0" /></td>
							<td align="left" valign="top" width="60"><a href="http://www.agdesigngroup.net/contact.html" onmouseover="turnOn('image5')" onmouseout="turnOff('image5')"><img name="image5" src="../links/contact-off.gif" alt="" width="60" height="28" border="0" /></td>
							<td align="left" valign="top" width="28"><a href="http://www.agdesigngroup.net/index.html" onmouseover="turnOn('image6')" onmouseout="turnOff('image6')"><img name="image6" src="../links/home-off.gif" alt="" width="28" height="28" border="0" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top"><img src="../images/gradient-top.jpg" alt="" height="30" width="744" border="0" /></td>
			</tr>
			<tr height="412">
				<td align="left" valign="top" height="412">
						<table width="744" border="0" cellspacing="0" cellpadding="0">
							<tr height="363">
								<td rowspan="2" width="538" height="412" valign="top">
            <!-- start main content -->
            <div class="main">
            <form name="MainForm" id="MainForm" method="post" action="">

  			<table align="center" border="0" bordercolor="eeeeee" cellpadding="5" width="530" height="412">
  			<tr>
				<td colspan="3">
	  		<span align="left" class="pagesubtitle">You are making a payment to AG Design. </span>
			<br/><br/>		
            
<?php 
if( $showResponse == 1 )
{
	echo $msg;
	if(	$success == 1 )
	{
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
	}
				
	if( $LIVE_TESTING == 0 )
	{
		echo $test_msg;
	}
}
else
{
	echo '<font color="red" >';
	if( strlen($errorMsg) > 1 )
		echo $errorMsg;
	else
		echo 'Note: Once you hit the submit button, your credit card will be charged. ';
	echo '</font>';
?>
	</td>
    </tr>
        <div align="left">
  <input type="hidden" name="x_login" value="<?php echo $loginid; ?>">
  <input type="hidden" name="x_tran_key" value="<?php echo $x_tran_key; ?>">
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
          
  <!-- main table start -->
    <tr><td>
      <table align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3"><hr color="#dddddd" size="1"/></td>
            </tr>
        <tr>
          <td width="35%"><strong>Total Amount</strong></td>
              <td colspan="2">Description </td>
              </tr>
        <tr>
          <td><input tabindex="1" id="pay_amount" name="pay_amount" value="<?php echo $varPayAmount; ?>" size="20" maxlength="60" type="text"  onKeyUp="verifyNumber(this.form.pay_amount);"  /></td>
              <td colspan="2"><input tabindex="2" id="description" name="description" value="<?php echo $varDescription; ?>" size="40" maxlength="60" type="text" /></td>
              </tr>
        <tr>
          <td colspan="3"><br/><hr color="#dddddd" size="1"/></td>
            </tr>
        <tr>
          <td width="35%"><strong>EMail Address</strong></td>
              <td colspan="2"><strong>Confirm EMail Address</strong> </td>
              </tr>
        <tr>
          <td><input tabindex="3" id="email" name="email" value="<?php echo $varEmail; ?>" size="20" maxlength="60" type="text" /></td>
              <td colspan="2"><input tabindex="4" id="email_confirm" name="email_confirm" value="<?php echo $varEmail2; ?>" size="20" maxlength="60" type="text" /></td>
              </tr>
        <tr>
          <td colspan="3"><br/><hr color="#dddddd"/> </td>
            </tr>
        <tr>
          <td colspan="3" class="style3">Payment </td>
            </tr>
        <tr>
          <td colspan="3"><hr color="#dddddd"/> </td>
            </tr>
        <tr>
          <td width="35%"><strong>Credit Card #</strong></td>
              <td width="28%"><strong>Expire Date (mm/yy)</strong></td>
              <td>&nbsp;</td>
            </tr>
        <tr>
          <td width="35%">
            <input type="hidden" tabindex="5" name="card_no" id="card_no" value="<?php echo $varCardNo; ?>" size="20" maxlength="19" />          
            <input type="text" tabindex="6" name="display_no" id="display_no" value="<?php echo $varDisplayNo; ?>" size="20" maxlength="19" />		  </td>
              <td width="28%"><select tabindex="7" name="cardExpMo" id="cardExpMo" style="width:75;">
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
                <select tabindex="8" name="cardExpYr" id="cardExpYr" style="width:75;">
                  <option value=""> </option>
                  <option value="2007" <?php if($varCardExpYr == '2007') echo ' selected="selected" '; ?>>07 </option>
                  <option value="2008" <?php if($varCardExpYr == '2008') echo ' selected="selected" '; ?>>08 </option>
                  <option value="2009" <?php if($varCardExpYr == '2009') echo ' selected="selected" '; ?>>09 </option>
                  <option value="2010" <?php if($varCardExpYr == '2010') echo ' selected="selected" '; ?>>10 </option>
                  <option value="2011" <?php if($varCardExpYr == '2011') echo ' selected="selected" '; ?>>11 </option>
                  <option value="2012" <?php if($varCardExpYr == '2012') echo ' selected="selected" '; ?>>12 </option>
                  <option value="2013" <?php if($varCardExpYr == '2013') echo ' selected="selected" '; ?>>13 </option>
                  <option value="2014" <?php if($varCardExpYr == '2014') echo ' selected="selected" '; ?>>14 </option>
                  <option value="2015" <?php if($varCardExpYr == '2015') echo ' selected="selected" '; ?>>15 </option>
                  <option value="2016" <?php if($varCardExpYr == '2016') echo ' selected="selected" '; ?>>16 </option>
                  </select>          </td>
              <td width="37%">&nbsp;</td>
            </tr>
        <tr>
          <td colspan="3"><br/><hr color="#dddddd"/> </td>
            </tr>
        <tr>
          <td colspan="3" class="style3">Billing Information</td>
            </tr>
        <tr>
          <td valign="bottom" height="30" width="35%"><strong>First Name</strong></td>
              <td valign="bottom" height="30" width="28%"><strong>Last Name</strong> </td>
              <td valign="bottom" height="30" width="37%">&nbsp; </td>
            </tr>
        <tr>
          <td align="left"><input name="first_name" type="text" id="first_name" tabindex="9" value="<?php echo $varFirstName; ?>" size="20" maxlength="30" /></td>
              <td align="left"><input name="last_name" type="text" id="last_name" tabindex="10" value="<?php echo $varLastName; ?>" size="20" maxlength="30"  /></td>
              <td align="left">&nbsp;</td>
            </tr>
        <tr>
          <td colspan="3" valign="bottom" height="30"><strong>Address</strong> </td>
            </tr>
        <tr>
          <td colspan="3" align="left"><input tabindex="11" name="address" value="<?php echo $varAddress; ?>" size="20" maxlength="30" type="text"  />            </td>
            </tr>
        <tr>
          <td valign="bottom" height="30" width="35%"><strong>City</strong> </td>
              <td valign="bottom" height="30" width="28%"><strong>State</strong> </td>
		      <td valign="bottom" height="30">&nbsp;</td>
            </tr>
        <tr>
          <td align="left"><input tabindex="12" name="city" id="city" value="<?php echo $varCity; ?>" size="20" maxlength="30" type="text"  /></td>
              <td colspan="2" align="left"><select tabindex="13" name="state" id="state"  >
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
                </select>          </td>
            </tr>
        <tr>
          <td valign="bottom" height="30" width="35%"><strong>Zip or Postal</strong></td>
               <td valign="bottom" height="30" width="28%"><strong>Country</strong> </td>
               <td valign="bottom" height="30" width="37%">&nbsp; </td>
            </tr>
        <tr>
          <td align="left"><input tabindex="14" name="zip" id="zip" value="<?php echo $varZip; ?>" size="20" maxlength="30" type="text"  /></td>
               <td colspan="2" align="left">
                 <select tabindex="14" name="country" >
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
          <td height="30" colspan="3" valign="bottom"><strong>Phone</strong> </td>
            </tr>
        
        <tr>
          <td colspan="3" valign="middle" class="notes"><input name="phone" tabindex="16" type="text" id="phone" maxlength="20" value="<?php echo $varPhone; ?>"  />   &nbsp;&nbsp;           (xxx)xxx-xxxx</td>
            </tr>
        <tr>
          <td valign="middle" class="notes" colspan="3">
            <br/>
            <hr color="#dddddd"/>
            
            <br/>
            <input tabindex="17" name="Submit" id="Submit" value="Submit Payment" type="submit" />
            <br />
            <br />
            Once you click on the &quot;Submit Payment&quot; button the authorization process will begin.<br />
            If no response, wait at least 30 seconds before resubmitting to avoid duplicate charges. 
            <br/><br/>
            <br/>
            <br/>              			  </td>
		    </tr>
        </table>
    </td></tr>
  </table>
  <!-- main table end -->
        <?php
}
?>
       </form>
      </div>

  <!-- end content -->	
                                </td>
							  <td width="206" height="363" valign="top"><img src="../images/img-contact2.gif" alt="" width="206" height="363" usemap="#img-contact2c37e1f5d" border="0" /><map name="img-contact2c37e1f5d"><area shape="rect" coords="32,329,157,346" href="mailto:info@agdesigngroup.net" alt="" /></map></td>
							</tr>
							<tr height="49">
								<td align="left" valign="top" width="206" height="49"><a href="quote.html" onmouseover="turnOn('image8')" onmouseout="turnOff('image8')"></td>
						  </tr>
						</table>
					</td>
			</tr>
		</table>
        <table>
        			<tr>
				<td align="left" valign="top"><img src="../images/gradient-btm.jpg" alt="" height="35" width="744" border="0" /></td>
			</tr>
			<tr>
				<td align="left" valign="top"><img src="../images/copyright.gif" alt="" height="16" width="217" border="0" /></td>
			</tr>
</table>
	</div>
	</body>

</html>