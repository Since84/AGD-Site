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

function notify_email($fromName, $fromEmail, $subject, $toName, $toEmail, $varMsg, $cc="")
{
	@set_time_limit(0);
	
	// send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	
	// Additional headers
	// $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= 'From: ' . $fromName . ' <' . $fromEmail . '>' . "\n";
	$headers .= 'Reply-To: ' . $fromEmail . "\n";
	
	//$headers .= 'Cc: lori@focusonyou.biz' . "\r\n";
	if( strlen($cc) > 1 )
	{
		 $headers .= 'Bcc: ' . $cc . "\r\n";
		 // echo 'headers: ' . $headers;
	}
	
	// format email message
	$message = "
				<html>
				<body>" . 
				$varMsg .
				"</body>
				</html>";
	
				//echo '<br/>headers ' . $headers;
				//echo '<br/>to ' . $toEmail;
				//echo '<br/>from ' . $fromEmail;
				//echo '<br/>subject ' . $subject;
				//echo '<br/>' . $message;
				
	$response = mail($toEmail, $subject, $message, $headers);
}
?>