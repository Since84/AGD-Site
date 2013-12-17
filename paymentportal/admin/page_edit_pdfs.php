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
include("image_defines.php");
//require('db_misc_functions.php');

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

if( isset($_POST['Delete']) )
	$deleting = true;
else
	$deleting = false;

$page_nav_id = 2;

$returnURL = "page_edit.php";
	
if( isset($_POST['page_id']) )
{
	$page_id = $_POST['page_id'];
	$page_title = $_POST['page_title'];
}
else
{
	$page_id = $_GET['page_id'];
	$page_title = $_GET['page_title'];
}

$title = $page_tile;


include("db_pdfs_get.php");
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
<span class="pagetitle"> <?php echo $page_title; ?>  </span>
    <br/>
    
  <table width="800" >
  <tr>
  <td colspan="4">
  <?php 
  include("page_edit_subnav_91.php");
  ?>
  </td>
  </tr>
      <tr>
      	<td colspan="4">
            <table >
            <tr>
            <td>
          <form id="form0" name="form0" method="post" action="page_edit_pdfs_add.php">
            <input type="submit" name="add" id="add" value="Add a PDF" />
            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
            <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         </form> 
         </td>
         <td> 
          <form id="form0" name="form0" method="post" action="page_edit.php">
            <input type="submit" name="add" id="add" value="Return" />
            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
            <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         </form> 
          
            </td>
         </tr>
         </table>
     	</td>
        </tr>
      <tr>
      <td class="tableHeadings" width="100">Display Order</td>
      	<td class="tableHeadings">Title	</span>        </td>
      	<td class="tableHeadings"></span> PDF      </td>
      	<td class="tableHeadings"></span> Flipbook      </td>
        
        <td class="tableHeadings">&nbsp;</td>
      </tr>
  		 <!-- first look for sub categories -->
		 <?php          
	  	if( $varNumPDFs > 0 ) 
		{
		  	do
			{
		 ?>
         <tr>
             <!-- now look for any products for this category -->
            <form id="form<?php echo $row_rsPDFs['pdf_id']; ?>" name="form<?php echo $row_rsPDFs['pdf_id']; ?>" method="post" action="page_edit_pdfs_edit.php">
        <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
        <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         <input type="hidden" name="pdf_id" value="<?php echo $row_rsPDFs['pdf_id']; ?>">
      	<td  class="tableFields" valign="top" ><?php echo $row_rsPDFs['display_order']; ?>        </td>
        <td  class="tableFields" valign="top" >
         
         <?php echo $row_rsPDFs['title']; ?>         </td>
        <td  class="tableFields" valign="top" >
        <a href="<?php echo '../' . $PAGES_PDF_FOLDER . $row_rsPDFs['pdf_file']; ?>" target="_blank">View PDF</a> 
       </td>
        <td  class="tableFields" valign="top" >
        <a href="<?php echo '../' . $FLIP_FOLDER . $row_rsPDFs['flipbook']; ?>" target="_blank">View Flipbook</a> 
       </td>
               
        <td width="150"  class="tableFields" valign="top" >
          <input name="Update" type="submit" id="Update" value="Edit" />
          <input name="Delete" type="submit" id="Delete" value="Delete" />
          </td>
        </form>
        </tr>
    <?php  
           } while ($row_rsPDFs = mysql_fetch_assoc($rsPDFs));
        }  
  ?>    
      </table>
  <br/>
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