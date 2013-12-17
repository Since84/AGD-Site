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

	# PLEASE DO NOT EDIT FOLLOWING LINES IF YOU'RE NOT SURE ------->
    $province = str_replace("-AU-", "", $state);

        if ($show_services) {
            if($payment_mode=="RECUR"){
                $amount = number_format($recur_services[$service][1], 2);
            } else {
                $amount = number_format($services[$service][1], 2);
            }
            $item_description = $services[$service][0];
        }

		$continue = false;
		if(!empty($amount) && is_numeric($amount)){ 	
			$cctype = (!empty($_POST['cctype']))?strip_tags(str_replace("'","`",strip_tags($_POST['cctype']))):'';
			$ccname = (!empty($_POST['ccname']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccname']))):'';
			$ccn = (!empty($_POST['ccn']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccn']))):'';
			$exp1 = (!empty($_POST['exp1']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp1']))):'';
			$exp2 = (!empty($_POST['exp2']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp2']))):'';
			$cvv = (!empty($_POST['cvv']))?strip_tags(str_replace("'","`",strip_tags($_POST['cvv']))):'';
			
			
            if($cctype!="PP"){
                //CREDIT CARD PHP VALIDATION
                if(empty($ccn) || empty($cctype) || empty($exp1) || empty($exp2) || empty($ccname) || empty($cvv) || empty($address) || empty($state) || empty($city)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Not all required fields were filled out.</p></div></div><br />';
                } else { $continue = true; }

                if(!is_numeric($cvv)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> CVV number can contain numbers only.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if(!is_numeric($ccn)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Credit Card number can contain numbers only.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if(date("Y-m-d", strtotime($exp2."-".$exp1."-01")) < date("Y-m-d")){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Your credit card is expired.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if($continue){
                    //echo "1";
                    if(validateCC($ccn,$cctype)){
                        $continue = true;
                    } else {
                        $continue = false;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> The number you\'ve entered does not match the card type selected.</p></div></div><br />';
                    }
                }

                if($continue){
                    if(luhn_check($ccn)){
                        $continue = true;
                    } else {
                        $continue = false;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Invalid credit card number.</p></div></div><br />';
                    }
                }
            } else {
                $continue = true;
            }
			
            switch ($cctype) {
                case "V":
                    $cctype = "VISA";
                    break;
                case "M":
                    $cctype = "MASTERCARD";
                    break;
                case "DI":
                    $cctype = "DINERS CLUB";
                    break;
                case "D":
                    $cctype = "DISCOVER";
                    break;
                case "A":
                    $cctype = "AMEX";
                    break;
                case "PP":
                    $cctype = "PAYPAL";
                break;
            }
            $transactID = mktime()."-".rand(1,999);

            if($continue && $cctype!="PAYPAL"){
				require_once 'includes/paypal.callerservice.php';





				switch($payment_mode){

                    /*******************************************************************************************************
                    ONE TIME PAYMENT PROCESSING
                    *******************************************************************************************************/
                    case "ONETIME":
					$paymentType =urlencode("Sale");
                    $API_UserName=API_USERNAME;
                    $API_Password=API_PASSWORD;
                    $API_Signature=API_SIGNATURE;
                    $API_Endpoint =API_ENDPOINT;
                    //$subject = SUBJECT;
                    $paymentType =urlencode("Sale");
                    //CREDIT CARD INFO
                    $tt = explode(" ",trim($ccname));
                    if(is_array($tt)){
                        $firstName =urlencode( $tt[0]);
                        if(isset($tt[2])){ $temp = $tt[1]." ".$tt[2]; } else { if(isset($tt[1])){ $temp = $tt[1]; } else { $temp = ""; } }
                        $lastName =urlencode( $temp );
                    } else {
                        $firstName =urlencode( $ccname);
                        $lastName =urlencode("");
                    }
                    $creditCardType =urlencode($cctype);
                    $creditCardNumber = urlencode(trim($ccn));
                    $expDateMonth =urlencode( $exp1);
                    $padDateMonth = str_pad($exp1, 2, '0', STR_PAD_LEFT);
                    $expDateYear =urlencode(  $exp2);
                    $cvv2Number = urlencode(trim($cvv));

                    //CUSTOMER INFO
                    $address1 = urlencode($address);
                    $countryCode = urlencode($country);
                    $city = urlencode($city);
                    $state =urlencode( $state);
                    $zip = urlencode($zip);

                    $amount = urlencode(number_format($amount,2));
                    //$amount = urlencode($amount);

					$currencyCode=PTP_CURRENCY_CODE;
					/* Construct the request string that will be sent to PayPal.
					   The variable $nvpstr contains all the variables and is a
					   name value pair string with & as a delimiter */
					$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$countryCode&CURRENCYCODE=$currencyCode";
					$getAuthModeFromConstantFile = true;
					$nvpHeader = "";
					
					if(!$getAuthModeFromConstantFile) {
						$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
						//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
						//$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
					} else {
						if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature) && !empty($subject)) {
							$AuthMode = "THIRDPARTY";
						}else if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature)) {
							$AuthMode = "3TOKEN";
						}else if(!empty($subject)) {
							$AuthMode = "FIRSTPARTY";
						}
					}
					
					switch($AuthMode) {
						
						case "3TOKEN" : 
								$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature);
								break;
						case "FIRSTPARTY" :
								$nvpHeader = "&SUBJECT=".urlencode($subject);
								break;
		
						case "THIRDPARTY" :
								$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature)."&SUBJECT=".urlencode($subject);
								break;		
						
					}
					
					$nvpstr = $nvpHeader.$nvpstr;
					//echo $nvpstr;
					/* Make the API call to PayPal, using API signature.
					   The API response is stored in an associative array called $resArray */
					$resArray=hash_call("doDirectPayment",$nvpstr);
					
					/* Display the API response back to the browser.
					   If the response from PayPal was a success, display the response parameters'
					   If the response was an error, display the errors received using APIError.php.
					   */
					$ack = strtoupper($resArray["ACK"]);
					
					if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING")  {
						$_SESSION['reshash']=$resArray;
						$resArray=$_SESSION['reshash']; 
						if(isset($_SESSION['curl_error_no'])) { 
							$errorCode= $_SESSION['curl_error_no'] ;
							$errorMessage=$_SESSION['curl_error_msg'] ;
                            $my_status = "<div>Transaction Un-successful!<br/>";
                            $my_status .= "There was an error with your credit card processing:<br/>";
                            $my_status .= "Merchant Gateway Response: " . $errorMessage . ", Error: " . $errorCode . "<br/>";
                            $my_status .= "</div>";
                            $error = 1;
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $my_status . '</div></div><br />';

                        } else {
							$count=0;
							$my_status="<div>Transaction Un-successful!<br/>";
							$my_text="There was an error with your credit card processing:<br/>";
							while (isset($resArray["L_SHORTMESSAGE".$count])) {		
								$errorCode    = $resArray["L_ERRORCODE".$count];
								$shortMessage = $resArray["L_SHORTMESSAGE".$count];
								$longMessage  = $resArray["L_LONGMESSAGE".$count]; 
								$count=$count+1; 					
								$my_text.="Error Code: ".$errorCode."<br/>";
								$my_text.="Error Message: ".$longMessage."<br/>";
							}//end while
							$my_status .= $my_text."</div>";
							$error=1;
							$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
						}// end else
					 } else { 
							$my_status="<br/><div>Transaction Successful!<br/>";
							$my_status .="Thank you for your payment<br /><br />";
                            $my_status .= "Transaction ID: " . $resArray["TRANSACTIONID"] . "<br />";
							$my_status .= "You will receive confirmation email within 5 minutes.<br/><br/><a href='index.php'>Return to payment page</a></div><br/>";
							$error=0;
							$mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
							#**********************************************************************************************#
							#		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
							#**********************************************************************************************#
							
							#**********************************************************************************************#
                            /******************************************************************
                            ADMIN EMAIL NOTIFICATION
                            ******************************************************************/
                            $headers = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: 'PayPal PRO Payment Terminal' <noreply@" . $_SERVER['HTTP_HOST'] . "> \n";
                            $subject = "New Payment Received";
                            $message = "New payment was successfully received through PayPal PRO <br />";
                            $message .= "from " . $fname . " " . $lname . "  on " . date('m/d/Y') . " at " . date('g:i A') . ".<br /> Payment total is: $" . number_format($amount, 2);
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment description: \"" . $item_description . "\"";
                            }
                            $message .= "<br />Transaction Number: \"" . $resArray["TRANSACTIONID"] . "\"";
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br />";

                            mail($admin_email, $subject, $message, $headers);
							
                            /******************************************************************
                            CUSTOMER EMAIL NOTIFICATION
                            ******************************************************************/
                            $subject = "Payment Received!";
                            $message = "Dear " . $fname . ",<br />";
                            $message .= "<br /> Thank you for your payment.";
                            $message .= "<br /><br />";
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment was made for: \"" . $item_description . "\"";
                            }
                            $message .= "<br />Payment amount: $" . number_format($amount, 2);
                            $message .= "<br />Transaction Number: \"" . $resArray["TRANSACTIONID"] . "\"";
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br />";

                            $message .= "<br /><br />Kind Regards,<br />" . $_SERVER['HTTP_HOST'];
                            mail($email, $subject, $message, $headers);

                            //-----> send notification end
                            $show_form = 0;
							}
						break;
				case "RECUR":
                    /*******************************************************************************************************
                    RECURRING PROCESSING
                    *******************************************************************************************************/
					
					$token = urlencode("");
					$paymentAmount = urlencode($amount);
					$currencyID = urlencode(PTP_CURRENCY_CODE);		// or other paypal supported currency
					$startDate = urlencode(date("Y-m-d")."T".date("G:i:s")); // "2009-9-6T0:0:0"date("Y-m-d G:i:s")
					$billingPeriod = urlencode($recur_services[$service][2]);	// or "Day", "Week", "Month", "SemiMonth", "Year"
					$billingFreq = urlencode($recur_services[$service][3]);		// combination of this and billingPeriod must be at most a year
					
					$cartType = urlencode($cctype);
					$cartNumber = urlencode($ccn);
					$expDate = urlencode($exp1.$exp2);
					$fname = urlencode($fname);
					$lname = urlencode($lname);
					$desc = urlencode($recur_services[$service][0]);
					
					$nvpStr="&TOKEN=$token&AMT={$paymentAmount}&CURRENCYCODE={$currencyID}&PROFILESTARTDATE={$startDate}";
					$nvpStr .= "&BILLINGPERIOD={$billingPeriod}&BILLINGFREQUENCY={$billingFreq}&DESC={$desc}";
					$nvpStr .= "&CREDITCARDTYPE={$cartType}&ACCT={$cartNumber}&EXPDATE={$expDate}&FIRSTNAME={$fname}&LASTNAME={$lname}&EMAIL={$email}";
					
					//print $nvpStr."<br><br>" ;
					$httpParsedResponseAr = PPHttpPost('CreateRecurringPaymentsProfile', $nvpStr);
					//print var_dump($httpParsedResponseAr);
					if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
						//exit('CreateRecurringPaymentsProfile Completed Successfully: '.print_r($httpParsedResponseAr, true));
							$my_status="<br/><div>Subscription Created Successfully!<br/>";
                            $my_status .= "Transaction ID: " . urldecode($httpParsedResponseAr["PROFILEID"]) . "<br />";
							$my_status .="Thank you for your payment<br /><br />";
							$my_status .= "You will receive confirmation email within 5 minutes.<br/><br/><a href='index.php'>Return to payment page</a></div><br/>";
							$error=0;
							$mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
							#**********************************************************************************************#
							#		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
							#**********************************************************************************************#
							
							#**********************************************************************************************#
							//-----> send notification 
							//creating message for sending
							$headers  = "MIME-Version: 1.0\n";
							$headers .= "Content-type: text/html; charset=utf-8\n";
							$headers .= "From: 'Paypal Payment Terminal' <noreply@".$_SERVER['HTTP_HOST']."> \n";
							$subject = "Recurring Payment Profile Created";
							$message =  "New Recurring Payment Profile was successfully received through paypal <br />";					
							$message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: $".number_format($amount,2);
							if($show_services){
								$message .= "<br />Payment was made for \"".$recur_services[$service][0]."\"";
							} else { 
								$message .= "<br />Payment description: \"".$item_description."\"";
							}
							$message .= "<br/>Start Date: ".date("Y-m-d")."<br />";
							$message .= "Period: ".$billingPeriod."<br />";
							$message .= "Billing Frequency: ".$billingFreq."<br />";
							$message .= "Profile ID: ".urldecode($httpParsedResponseAr['PROFILEID'])."<br />";
							
							$message .= "<br /><br />Billing Information:<br />";
							$message .= "Full Name: ".$fname." ".$lname."<br />";
							$message .= "Email: ".$email."<br />";
							$message .= "Address: ".$address."<br />";
							$message .= "City: ".$city."<br />";
							$message .= "Country: ".$country."<br />";
							$message .= "State/Province: ".$state."<br />";
							$message .= "ZIP/Postal Code: ".$zip."<br />";
							
							
							mail($admin_email,$subject,$message,$headers);
							
							$subject = "Payment Received!";
							$message =  "Dear ".$fname.",<br />";
							$message .= "<br /> Thank you for your subscription.";
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$recur_services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br/>Start Date: ".date("Y-m-d")."<br />";
                            $message .= "Period: ".$billingPeriod."<br />";
                            $message .= "Billing Frequency: ".$billingFreq."<br />";
                            $message .= "Profile ID: ".urldecode($httpParsedResponseAr['PROFILEID'])."<br />";
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$fname." ".$lname."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$address."<br />";
                            $message .= "City: ".$city."<br />";
                            $message .= "Country: ".$country."<br />";
                            $message .= "State/Province: ".$state."<br />";
                            $message .= "ZIP/Postal Code: ".$zip."<br />";
							$message .= "<br /><br />Kind Regards,<br />".$_SERVER['HTTP_HOST'];
							mail($email,$subject,$message,$headers);	
							
							//-----> send notification end 	
							$show_form=0;
					} else  {
						//exit('CreateRecurringPaymentsProfile failed: ' . print_r($httpParsedResponseAr, true));
							$count=0;
							$my_status="<div>Transaction Un-successful!<br/>";
							$my_text="There was an error with your credit card processing:<br/>";
							
							$my_status .="Error Message: ". urldecode($httpParsedResponseAr['L_LONGMESSAGE0'])."</div>";
							$error=1;
							$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
					}
					
					break;
					}
				 
			} else if($continue && $cctype=="PAYPAL"){
                require('includes/paypal.class.php');
                $paypal = new paypal_class;

                $paypal->add_field('business', $paypal_merchant_email);
                $paypal->add_field('return', $paypal_success_url);
                $paypal->add_field('cancel_return', $paypal_cancel_url);
                $paypal->add_field('notify_url', $paypal_ipn_listener_url);

                    if($payment_mode=="ONETIME"){
                        if($show_services){
                            $paypal->add_field('item_name_1', strip_tags(str_replace("'","",$services[$service][0])));
                        } else {
                            $paypal->add_field('item_name_1', strip_tags(str_replace("'","",$item_description)));
                        }
                        $paypal->add_field('amount_1', $amount);
                        $paypal->add_field('item_number_1', $transactID);
                        $paypal->add_field('quantity_1', '1');
                        $paypal->add_field('custom', $paypal_custom_variable);
                        $paypal->add_field('upload', 1);
                        $paypal->add_field('cmd', '_cart');
                        $paypal->add_field('txn_type', 'cart');
                        $paypal->add_field('num_cart_items', 1);
                        $paypal->add_field('payment_gross', $amount);
                        $paypal->add_field('currency_code',$paypal_currency);

                    } else if($payment_mode=="RECUR"){
                        if($show_services){
                            $paypal->add_field('item_name', strip_tags(str_replace("'","",$recur_services[$service][0])));
                        } else {
                            $paypal->add_field('item_name', strip_tags(str_replace("'","",$item_description)));
                        }
                        $paypal->add_field('item_number', $transactID);
                        $paypal->add_field('a3', $amount);
                        $paypal_duration = getDurationPaypal($recur_services[$service][2]); //get duration based on recurring_services array
                        $paypal->add_field('p3', $recur_services[$service][3]);
                        $paypal->add_field('t3', (is_array($paypal_duration)?$paypal_duration[0]:$paypal_duration));
                        $paypal->add_field('src', '1');
                        $paypal->add_field('no_note', '1');
                        $paypal->add_field('no_shipping', '1');
                        $paypal->add_field('custom', $paypal_custom_variable);
                        $paypal->add_field('currency_code',$paypal_currency);
                    }
                    $show_form=0;
                    $mess = $paypal->submit_paypal_post(); // submit the fields to paypal


            }
				
		} elseif(!is_numeric($amount) || empty($amount)) { 
			if($show_services){
				$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please select service you\'re paying for.</p></div></div><br />';
			} else { 
				$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please type amount to pay for services!</p></div></div><br />';
			}
			$show_form=1; 
		} 
	# END OF PLEASE DO NOT EDIT IF YOU'RE NOT SURE
?>