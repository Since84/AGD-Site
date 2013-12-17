<?php

// getmxrr() - fix for windows users
if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
	function getmxrr($hostname, &$mxhosts){
		$mxhosts = array();
		exec('nslookup -type=mx '.$hostname, $result_arr);
		foreach($result_arr as $line){
			if(preg_match("/.*mail exchanger = (.*)/", $line, $matches)) $mxhosts[] = $matches[1];
		}
		return (count($mxhosts) > 0);
	}
}

// usleep() - fix for >= php5 windows users
function msleep($usecs){
	$temp = gettimeofday();
	$start = (int)$temp["usec"];
	while(true){
		$temp = gettimeofday();
		$stop = (int)$temp["usec"];
		if(($stop-$start) >= $usecs) break;
	}
}

/** 
 * Return an array with tow values: boolean and string
 * 
 * @author    Laurentiu Tanase <expertphp@yahoo.com> 
 * @version   2.4 
 * @param     string  $to         To e-mail address 
 * @param     string  $subject    Mail Subject 
 * @param     string  $message    Message ( Mixed ) 
 * @param     string  $from       From e-mail address 
 * @param     string  $header     Additional headers 
 * @param     integer $timeout    Time out connection 
 */

function smtp_mail($to, $subject, $message, $from, $header = false, $timeout = 30){

	$exp_to = explode("@", $to);
	getmxrr($exp_to[1], $mxhost);
	$iparr = array();

	foreach($mxhost as $hostname){
		$iphost = gethostbyname($hostname);
		if($hostname != $iphost && $hostname != $exp_to[1]) $iparr[] = $iphost;
	}

	if(count($iparr) > 0){

		$vphp = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' && version_compare(phpversion(), "5.0.0", ">=")) ? true : false;

		$ret = array(false, "Can not contact MX host !");
		foreach($iparr as $ipaddr){

			echo '<br/>' . $ipaddr;
			
			if($connect = @fsockopen($ipaddr, 25, $err_num, $err_msg, $timeout)){

				$set = true;

				$rcv0 = fgets($connect, 1024);
				if(substr($rcv0, 0, 3) != "220"){
					fclose($connect);
					$ret = array(false, "Response 0 error: ".$rcv0);
					$set = false;
				}
				
				if($set){
					$exp_from = explode("@", $from);
					fputs($connect, "HELO ".$exp_from[1]."\r\n");
					$rcv1 = fgets($connect, 1024);
					if(substr($rcv1, 0, 3) != "250"){
						fclose($connect);
						$ret = array(false, "Response 1 error: ".$rcv1);
						$set = false;
					}
				}
				
				if($set){
					fputs($connect, "MAIL FROM:<".$from.">\r\n");
					$rcv2 = fgets($connect, 1024);
					if(substr($rcv2, 0, 3) != "250"){
						fclose($connect);
						$ret = array(false, "Response 2 error: ".$rcv2);
						$set = false;
					}
				}

				if($set){
					fputs($connect, "RCPT TO:<".$to.">\r\n");
					$rcv3 = fgets($connect, 1024);
					if(substr($rcv3, 0, 3) != "250"){
						fclose($connect);
						$ret = array(false, "Response 3 error: ".$rcv3);
						$set = false;
					}
				}
				
				if($set){
					fputs($connect, "DATA\r\n");
					$rcv4 = fgets($connect, 1024);
					if(substr($rcv4, 0, 3) != "354"){
						fclose($connect);
						$ret = array(false, "Response 4 error: ".$rcv4);
						$set = false;
					}
				}
				
				if($set){
					if(!$header){
						$header = "From: \"".$exp_from[0]."\" <".$from.">\r\n".
							"To: \"".$exp_to[0]."\" <".$to.">\r\n".
							"Date: ".date("r")."\r\n".
							"Subject: ".$subject."\r\n";
					}

					$rep = array(".\r\n", ".\n", ".\r");
					fputs($connect, $header."\r\n".str_replace($rep, ". \r\n", $message)." \r\n");
					fputs($connect, ".\r\n");
					$rcv5 = fgets($connect, 1024);
					if(substr($rcv5, 0, 3) != "250"){
						fclose($connect);
						$ret = array(false, "Response 5 error: ".$rcv5);
						$set = false;
					}
					
					fputs($connect, "QUIT\r\n");
					if($vphp) msleep(1);
					else usleep(1);
					$rcv6 = fgets($connect, 1024);
					if($vphp) msleep(1);
					else usleep(1);
					fclose($connect);
				}
				
				if($set){
					$ret = array(true, "Response 6 success: ".$rcv5." | ".$rcv6);
					break;
				}

			}
		}

		return $ret;

	}else return array(false, "Can not find MX zone !");

} // End smtp_mail() -----------------------------

?>