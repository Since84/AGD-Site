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

$admin_id = 0;
	
mysql_select_db($db_database, $db_connection);
$query_rsAdmin = sprintf("SELECT * FROM admin ORDER BY last_name, first_name ASC");
$rsAdmin = mysql_query($query_rsAdmin, $db_connection) or die(mysql_error());
$row_rsAdmin = mysql_fetch_assoc($rsAdmin);
$varNumUsers = mysql_num_rows($rsAdmin);

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
      <br/><br/>
     <form id="form0" name="form0" method="post" action="admin_add.php">
     <input type="submit" name="add" id="add" value="Add A User" />
     </form>
     <br/>
	  <table width="700">
      <tr>
      	<td class="tableHeadings" valign="bottom">Username</td>
      	<td width="150" class="tableHeadings" valign="bottom">Access Level</td>
        <td width="150" class="tableHeadings" valign="bottom">Action</td>
      </tr>
      <?php
	      if( $varNumUsers > 0 )
		  {
		  	do
			{
				if( $row_rsAdmin['admin_lvl'] < 9 || $_SESSION['AdminLevel'] == 9 )
				{
		 ?>
         <tr>
             <!-- now look for any products for this category -->
            <form id="form<?php echo $row_rsAdmin['admin_id']; ?>" name="form<?php echo $row_rsAdmin['admin_id']; ?>" method="post" action="admin_update.php">
        <input type="hidden" name="admin_id" value="<?php echo $row_rsAdmin['admin_id']; ?>">
        <td class="tableFields" >
         <?php echo $row_rsAdmin['email']; ?></td>
         <td  class="tableFields">
         <?php echo getAdminLvlDesc($row_rsAdmin['admin_lvl'], $db_database, $db_connection); ?></td>
          <td class="tableFields" >
          <input name="Update" type="submit" id="Update" value="Edit" />
          <input name="Delete" type="submit" id="Delete" value="Delete" />    
          </td>
        </form>
        </tr>
    	<?php  
				}
  			} while ($row_rsAdmin = mysql_fetch_assoc($rsAdmin));
	  	}
	  	?>    
      </table>
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