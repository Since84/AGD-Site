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
include("config.php");
include("db_utils.php");

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

if( $_SESSION['AdminLevel'] < 3 )
	header("Location: ". $MM_restrictGoTo); 


$msg = '';
$ship_same = '0';

if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", "admin.php"));
	exit();
}

if( isset($_POST["MM_update"]) )
{
	
	$email      	= strip_tags($_POST['email']);
	$email2      	= strip_tags($_POST['email2']);
	$password      	= strip_tags($_POST['password']);
	$password2      = $_POST['password2'];

	$first_name		= strip_tags($_POST['first_name']);
	$last_name	 	= strip_tags($_POST['last_name']);
	$admin_lvl	 	= $_POST['admin_lvl'];

	// edits
	$edits_ok = true;
	if( empty($_POST['first_name'])  )
	{
		$msg = $msg . '<font color="red">Please enter a first name.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['last_name'])  )
	{
		$msg = $msg . '<font color="red">Please enter a last name.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['email'])  )
	{
		$msg = $msg . '<font color="red">Please enter an email address.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['password'])  )
	{
		$msg = $msg . '<font color="red">Please enter a password.</font><br/>';
		$edits_ok = false;
	}
	else
	{
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
	if( empty($_POST['admin_lvl'])  )
	{
		$msg = $msg . '<font color="red">Please select an access level.</font><br/>';
		$edits_ok = false;
	}

	// if passed edits, update	
	if($edits_ok)
	{
		require('db_admin_add.php'); 
		$result = addAdmin($db_database, $db_connection);	
		{
			header(sprintf("Location: %s", "admin.php"));
			exit();
		}
	}	
}

include("db_admin_lvl_get.php");
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
  <span class="pagetitle"> ADMINISTRATIVE USERS </span>
    <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
          <input type="hidden" id="MM_update" name="MM_update" value="1" />
      <?php if( strlen($msg) > 0 ) { echo $msg; }; ?>
	  <table width="100%" cellpadding="1">
	  <tr>
	  	<td style="padding-left:10px;">        </td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	  	<td valign="top" class="Bold"><div align="right">First Name</div></td>
		<td><input name="first_name" type="text" id="first_name" size="30" maxlength="30" value="<?php echo $_POST['first_name']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Last Name</div></td>
		<td><input name="last_name" type="text" id="last_name" size="30" maxlength="30" value="<?php echo $_POST['last_name']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Username/Email</div></td>
		<td><input name="email" type="text" id="email" size="60" maxlength="60" value="<?php echo $_POST['email']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Password</div></td>
		<td><input name="password" type="password" id="password" size="20" maxlength="20" value="<?php echo $_POST['password']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Confirm Password</div></td>
		<td><input name="password2" type="password" id="password2" size="20" maxlength="20" value="<?php echo $_POST['password2']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Access Level</div></td>
		<td>
         <select name="admin_lvl" id="admin_lvl">
                  <option value="" >&nbsp; </option>
                  <?php
				  do { 
				  	if( $row_rsAdminLvl['admin_lvl'] < 9 || $_SESSION['AdminLevel'] == 9 )
					{
					?>
                  <option value="<?php echo $row_rsAdminLvl['admin_lvl']; ?>"<?php if($admin_lvl == $row_rsAdminLvl['admin_lvl']) echo ' selected="selected" '; ?>><?php echo $row_rsAdminLvl['description']; ?></option>
                  <?php
				  	}
				  }  while($row_rsAdminLvl = mysql_fetch_assoc($rsAdminLvl)); 
				  ?>
                </select>        </td>
	  </tr>
	  <tr>
	  	<td valign="top">&nbsp;</td>
		<td><input name="Add" type="submit" id="Add" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
	  </table>
	  </form>
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
