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
require('checkaccess.php'); 
include("config.php");
include("db_utils.php");



include("config.php");

$admin_id = $_SESSION['AdminID'];
//echo 'Member ID: ' .  $member_id;

$today = date("Y-m-d");   

// initialze vars
$error_msg = '';
$error = 0;

if( isset($_POST["MM_update"]) )
{
	$error = 0;
	
	$password	 = strip_tags($_POST['password']);
	$password2	 = $_POST['password'];
	$first_name	 = $_POST['first_name'];
	$last_name	 = $_POST['last_name'];
		
	// if update
	if( isset($_POST['Update']) )
	{
		if( empty($_POST['password'] ) )
		{
			$error = 1;
			$error_msg = 'Password is required.';
		}
		else
		{
			//echo 'checking...';
			$res = checkPwsd($_POST['password']);
			if( $res[0] )
			{
				if( $_POST['password'] != $_POST['password2'] )
				{
					$error = 1;
					$error_msg = 'Passwords need to match.';
				}
			}
			else
			{
				//echo 'bad';
				$error = 1;
				$error_msg = $res[1];
			}
		}

		if( $error == 0 )
		{
			// update existing item
			$updateSQL = sprintf("UPDATE admin SET password=%s, update_date=%s WHERE admin_id=%s",
						   GetSQLValueString($password, "text"),
						   'NOW()',
						   $admin_id);
	
	//	 	echo '<br/>sql: ' . $updateSQL;
			
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
			
			header('Location: home.php');
	    	exit;
		}
	}

}

$editFormAction = $_SERVER['PHP_SELF'];

mysql_select_db($db_database, $db_connection);
	
$query_rsMembers = sprintf("SELECT * FROM admin WHERE admin_id = %s", $admin_id);
//echo $query_rsMembers;
$rsMembers = mysql_query($query_rsMembers, $db_connection) or die(mysql_error());
$row_rsMembers = mysql_fetch_assoc($rsMembers);
$totalRows_rsMembers = mysql_num_rows($rsMembers);
	
$password	 = $row_rsMembers['password'];
$password2	 = $row_rsMembers['password'];
$first_name	 = $row_rsMembers['first_name'];
$last_name	 = $row_rsMembers['last_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $companyFROM; ?> - Admin</title>
<!-- InstanceEndEditable -->
<link href="adminstyle.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<style>
.style1 {
	color: #FF0000;
	font-weight: bold;
}
</style>
<!-- InstanceEndEditable -->
</head>
<body>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr bgcolor="#ffffff">
    <td width="992" height="80"><a href="<?php echo $baseURL; ?>"><img src="images/logo.gif" width="74" height="74" border="0" style="margin-left:20px;" /></a></td>
    <td valign="bottom" align="left">
	<div id="loginText">
	<?php
	echo 'You are logged in as: <b>'; 
	echo $_SESSION['FirstName'];
	echo '</b><br/>'; 
	?>
    </div>
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#6E0025" height="12"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="150" valign="top" bgcolor="#ededed">
	  <div id="divVert">
		<table width="100%" cellpadding="4">
        <tr>
        <td style="border-top:thin; border-top-color:#999999; border-top-style:solid"><a href="home.php">HOME</a></td>
        </tr>
       <tr>
		  <td><a href="crop_tool.php">IMAGE LIBRARY</a></td>
        </tr>
        <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
        <tr>
		  <td><a href="pages.php">MANAGE PAGES</a></td>
        </tr>
        <?php } ?>
        
        <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
        
        <tr>
		  <td><a href="admin.php">MANAGE USERS</a></td>
        </tr>
        <?php } ?>
        <tr>
          <td><a href="chgpswd.php">CHANGE&nbsp;PASSWORD</a></td>
		  </tr>
          <tr>
          <td><a href="faqs.php">FAQS</a></td>
		  </tr>
            <tr>
          <td><a href="help.php">HELP</a></td>
		  </tr>
        <tr>
          <td><a href="home.php?doLogout=true">LOGOUT</a></td>
		  </tr>
          </table>
	  </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </td>
    <td valign="top" style="padding:5px;">
    <div id="mainContent">
	<!-- InstanceBeginEditable name="mainContent" --> 
<p><span class="pagetitle"> CHANGE PASSWORD
  </span><br/><br/>
  <form id="form1" method="post" action="<?php echo $editFormAction; ?>" />
	  <input type="hidden" name="MM_update" id="MM_update" value="MM_update" />
	  <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id; ?>" />
	  <input type="hidden" name="first_name" id="first_name" value="<?php echo $first_name; ?>" />
	  <input type="hidden" name="last_name" id="last_name" value="<?php echo $last_name; ?>" />
      <table border="0" cellspacing="0" cellpadding="2">
  <tr>
	<td colspan="4" >
	  <?php if( $error == 1 ) echo '<b><font color="#ff0000">' . $error_msg . '</font></b><br/>'; ?>
	  </td>
	</tr>
     <tr>
	<td ><div align="right"><b>Name&nbsp;&nbsp;</b></div></td>
    <td><?php echo $first_name . ' ' . $last_name; ?></td>
	</tr>
     <tr>
  	<td width="164" valign="top"><div align="right"><strong> New Password&nbsp;&nbsp;</strong></div></td>
	<td width="473"><input name="password" type="password" id="password" value="" /></td>
  </tr>
   <tr>
	  <td width="164"><div align="right"><strong>Confirm New Password&nbsp;&nbsp;</strong></div></td>
	  <td align="left"><input name="password2" type="password" id="password2"  value=""/></td>
  </tr>
     <tr>
	<td ><div align="right"></div></td>
	<td >&nbsp;</td>
	</tr>
  <tr>
  	<td width="164"><div align="right"></div></td>
	<td>
	  <input name="Update" type="submit" id="Update" value="Change Password" />
	  <input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
  <tr>
  <td colspan="4"><div align="right"></div></td>
  </tr>
</table>
</form>
<br/><br/>
    <!-- InstanceEndEditable -->
    </div>
    </td>
  </tr>
   <tr valign="top">
    <td height="1" colspan="2" bgcolor="#ededed"></td>
  </tr>
  <tr valign="top">
    <td height="24" colspan="2" class="Copyright">&copy; 2011 Sky High Software</td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php mysql_close(); ?>
