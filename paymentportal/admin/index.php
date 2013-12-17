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

require_once('../Connections/dbCMS.php'); 
include('config.php');
include("db_utils.php");

// make sure we login on secure server
require('../utils/server.php');
if( !secureConnection() )
{
	$redirectSecure = $secureURL . '/admin';
	header("Location: " . $redirectSecure );
	exit();
}

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  
  $loginUsername	=	strip_tags($_POST['email']);
  $password			=	strip_tags($_POST['password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($db_database, $db_connection);
  
  $LoginRS__query=sprintf("SELECT * FROM admin WHERE email='%s' AND password='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $db_connection) or die(mysql_error());
  $row_rsLogin = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['AdminName']  = $loginUsername;
    $_SESSION['AdminLevel'] = $row_rsLogin['admin_lvl'];
	$_SESSION['AdminID']  	= $row_rsLogin['admin_id'];
	$_SESSION['FirstName']  = $row_rsLogin['first_name'];
	
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }

	// add info to session logs	
	//$clear_sess = "delete from admin_log where admin_id = " . $row_rsLogin['admin_id'];
	//$clear_sess_qry  =  mysql_query($clear_sess) or die (mysql_error()); 
		
	// add new session
	$start_time = date("H:i:s", time());
	$exp	    = time() + (1 * 1 * 30 * 60);  // days, hours, mins, secs
	$exp_time   = date("H:i:s", $exp);
	$admin_id = $row_rsLogin['admin_id'];
	$ip = $_SERVER['REMOTE_ADDR'];
			
	$add_sess = "insert into admin_log (log_id,admin_id,log_date,start_time,exp_time,ip) values ('','$admin_id', NOW(),'$start_time','$exp_time','$ip')";
	$add_sess_qry  =  mysql_query($add_sess) or die (mysql_error()); 
		
	// go to appropriate page	
    $msg = 'successful login: ' . $add_sess;
	header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    $msg = '<font color="red">Incorrect login.</font>';
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $companyFROM; ?></title>
<link href="adminstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="80" colspan="3" bgcolor="#ffffff"><a href="<?php echo $baseURL; ?>"><img src="images/logo.gif" width="74" height="74" border="0" style="margin-left:40px;" /></a></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#6E0025" height="12"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="227" height="50" align="left"><div class="pagetitle">
      <div align="right">CMS  LOGIN</div>
    </div>
    <div align="right"><?php echo $msg; ?></div>
    </td>
    <td width="255" height="50">&nbsp;</td>
    <td width="633" height="50"></td>
  </tr>
  <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <tr>
    <td><div align="right" class="Bold">username:</div></td>
    <td><input name="email" type="text" id="email" size="30" maxlength="40"  />    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right" class="Bold">password:</div></td>
    <td><input name="password" type="password" id="password" size="30" maxlength="16"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Login" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td><a href="forgot.php" class="accentColor">Forgot Your Password?</a></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td colspan="3"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
  <tr>
    <td colspan="3" bgcolor="#000000" height="1"></td>
  </tr>
  <tr>
    <td height="24" colspan="3" class="Copyright">&copy; 2010 Sky High Software</td>
    </tr>
  </form>
</table>
</body>
</html>
<?php mysql_close(); ?>
