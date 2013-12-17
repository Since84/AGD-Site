<?php 
// Send msg notification email
function notify_client($varName, $varEmail, $varMsg, $receipt_email, $company_name)
{
	@set_time_limit(0);
	

	// change the TO for whoever is going to get these emails
	$to = $varEmail; 
	$from = $receipt_email;
	$subject = $company_name . " Customer Receipt/Purchase Confirmation";

	// echo 'test: ' . $from . ', ' . $subject;
				
	$name = $varName;
		 
	// send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	// $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= 'From: ' . $varName . ' <' . $from . '>' . "\r\n";
	$headers .= 'Reply-To: ' . $from . "\r\n";
	// $headers .= 'Cc: lori@focusonyou.biz' . "\r\n";
	// $headers .= 'Bcc: lori@focusonyou.biz' . "\r\n";
	
	// format email message
	$message = "
				<html>
				<body>" . 
				$varMsg .
				"</p>
				</body>
				</html>";
	
				// echo '<br/>headers ' . $headers;
				// echo '<br/>to ' . $to;
				// echo '<br/>from ' . $from;
				// echo '<br/>' . $message;
				
	$response = mail($to, $subject, $message, $headers);
}
?> 