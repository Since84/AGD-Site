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
include("db_misc_functions.php");

$MM_AuthorizedLevels = "1,2,3,9";
require('checkaccess.php'); 

include("db_pages_get_main_all.php");
include("db_page_types_get.php");

$page_type_id = 1; // default

include("pages_subpages.php");

// echo 'admin lvl is: ' . $_SESSION['AdminLevel'];
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
  <table border="0" cellspacing="0" cellpadding="0" >
  <tr>
  <td colspan="4" class="pagetitle"><br />
    WEBSITE PAGES </td>
  </tr>
  <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
  <tr>
  <td colspan="4">
   <br/>
  <form id="form0" name="form0" method="post" action="page_add.php">
  <select name="page_type_id">
  <?php 
  do { 
  	if( $row_rsPageTypes['activated'] ) { 
		if( $row_rsPageTypes['page_type_id'] < 90 || $_SESSION['AdminLevel'] == 9 ) { ?>
  <option value="<?php echo $row_rsPageTypes['page_type_id']; ?>" <?php if( $page_type_id == $row_rsPageTypes['page_type_id'] ) echo ' selected="selected" '; ?>><?php echo $row_rsPageTypes['title']; ?></option>
  <?php 
  		}
  	}
  } while ($row_rsPageTypes = mysql_fetch_assoc($rsPageTypes)); ?>
  </select>
     <input type="submit" name="add" id="add" value="ADD A PAGE" />
     </form>
     <br/>
  </td>
  </tr>
  <?php } ?>
  <tr>
  	<td class="tableHeadings">Title</td>
  	
    <td class="tableHeadings">Position&nbsp;&nbsp;</td>
    <td class="tableHeadings">Active&nbsp;&nbsp;</td>
     <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
    <td width="75" class="tableHeadings">Preview</td>
    <?php } ?>
    <td width="150" class="tableHeadings">Page Type</td>
    <td class="tableHeadings">Main Menu&nbsp;&nbsp;</td>
    <td class="tableHeadings">Footer&nbsp;&nbsp;</td>
   
    <td width="200" class="tableHeadings">Last Updated</td>
    <td width="150" class="tableHeadings">Action</td>
  </tr>
  <?php
  	  //echo 'call pages_inc';
	  include("pages_inc.php");
	  
	  //echo 'call pages float';
	  // now get floaters (not main menu and does not have parent
	  include("db_pages_get_float.php");
	  include("pages_inc.php");
	  

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
