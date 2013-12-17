<?php

function send_mail($to, $toName, $from, $fromName, $subject, $message, $attachments=NULL)
{
	require_once('class.phpmailer-lite.php');
	
	$mail             = new PHPMailerLite(); // defaults to using php "Sendmail" (or Qmail, depending on availability)
	$mail->IsMail(); // telling the class to use native PHP mail()
	
	$body             = $message;
	$body             = eregi_replace("[\]",'',$body);
	
	$mail->SetFrom($from, $fromName);
	
	$address = $to;
	$mail->AddAddress($address, $toName);
	
	$mail->Subject    = $subject; 
	
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	
	$mail->MsgHTML($body);
	
	if( $attachments )
	{
		for($i=0; $i<sizeof($attachments); $i++)
			$mail->AddAttachment($attachments[$i]);      // attachment
	}
	
	if(!$mail->Send()) {
	  return $mail->ErrorInfo;
	} else {
	  return NULL;
	}
}
?>