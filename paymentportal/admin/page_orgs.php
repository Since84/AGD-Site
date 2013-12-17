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
include("config_cms.php");
include("db_utils.php");
//require('db_misc_functions.php');

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

if( isset($_POST['Delete']) )
	$deleting = true;
else
	$deleting = false;

$returnURL = "pages.php";
	
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

if( isset($_POST['ConfirmDelete']) )
{
	////////////////////////////////
	// check for dependent pages
	mysql_select_db($db_database, $db_connection);
	$query_rsPages = sprintf("SELECT * FROM pages WHERE parent_id = %s", $page_id);
	$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
	$row_rsPages = mysql_fetch_assoc($rsPages);
	$varNum = mysql_num_rows($rsPages);
	
	if( $varNum > 0 )
	{
		$msg = $msg . '<font color="red">Cannot delete:  This page has sub pages assigned to it.</font><br/>';
		$edits_ok = false;		
	}
	else
	{
		// get page details
		mysql_select_db($db_database, $db_connection);
		$query_rsPages = sprintf("SELECT * FROM pages WHERE page_id = %s", $page_id);
		$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
		$row_rsPages = mysql_fetch_assoc($rsPages);
		
		$active	 		= $row_rsPages['active'];
		$last_update 	= $row_rsPages['last_update'];
		$title 			= $row_rsPages['title'];
		$sub_title 		= $row_rsPages['sub_title'];
		$sub_nav_title	= $row_rsPages['sub_nav_title'];
		$snippet 		= $row_rsPages['snippet'];
		$other	 		= $row_rsPages['other'];
		$other2	 		= $row_rsPages['other2'];
		$complete_text 	= $row_rsPages['complete_text'];
		
		$page_type_id	= $row_rsPages['page_type_id'];
		
		$pdf_file	 	= $row_rsPages['pdf_file'];
		$image_file	 	= $row_rsPages['image_file'];
		$image_size	 	= $row_rsPages['image_size'];
		$image_pos	 	= $row_rsPages['image_pos'];
		
		$admin_lvls     	= explode(",", $row_rsPages['admin_lvls']);
		
		$parent_id			= $row_rsPages['parent_id'];
		$left_nav_pos		= $row_rsPages['left_nav_pos'];
		$alt_landing_page	= $row_rsPages['alt_landing_page'];
		$back_button		= $row_rsPages['back_button'];
		$main_menu			= $row_rsPages['main_menu'];
		$footer				= $row_rsPages['footer'];
		$header_id			= $row_rsPages['header_id'];

		// delete PDF
		if( $pdf_file )
		{
			include('filedelete.php');
			$tmp = "../" . $PAGES_PDF_FOLDER . $pdf_file;
			deleteFile($tmp);
		}
			
		// delete image
		if( $image_file != NULL )
		{
				include("photodelete.php");
				deletePhotos($page_imagefolder, $image_file);
		}
		
		// delete orgs
		$updateSQL = sprintf("DELETE FROM organizations WHERE page_id = %s", $page_id );
		$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
				
		// delete page
		$updateSQL = sprintf("DELETE FROM pages WHERE page_id = %s LIMIT 1", $page_id );
		$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
		
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
}

include("db_orgs_get.php");
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
     <table cellpadding="0" cellspacing="0">
    <tr>
    <td valign="middle">
    
    <?php if( $deleting ) { ?>
	<br/>
    <span class="accentColor">By Confirming Delete, this page and all the content below that is associated with it will be deleted.</span>
	<br/><br/>
    <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
      <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
       <input type="hidden" name="title" value="<?php echo $title; ?>" />
          <input name="ConfirmDelete" type="submit" id="ConfirmDelete" value="Confirm Delete" />	
   	    </form>
        <br/>
    <?php } else { ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="page_edit.php">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
      <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
       <input type="hidden" name="title" value="<?php echo $title; ?>" />
          <input name="Update" type="submit" id="Update" value="Update Title / Intro" />	
   	    </form>
        <?php } ?>	</td>
    <td valign="middle" style="padding-left:10px;">        &nbsp;&nbsp;&nbsp;&nbsp;
    <!-- <form id="form0" name="form0" method="post" action="pages.php">
            <input type="submit" name="done" id="done" value="Return" />
         </form> -->
         </td></tr></table>  
    <br/>
    <hr size="1" />
    <br/>
  <table width="800" >
  
    <?php if( !$deleting ) { ?>
      <tr>
      	<td colspan="4">
            <table >
            <tr>
            <td>
          <form id="form0" name="form0" method="post" action="page_orgs_add.php">
            <input type="submit" name="add" id="add" value="Add Organization" />
            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
            <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         </form> 
         </td>
         <td> 
          
            </td>
         </tr>
         </table>
     	</td>
        </tr>
        <?php } ?>
      <tr>
      <td class="tableHeadings" width="100">Display Order</td>
      	<td class="tableHeadings">Name	</span>        </td>
      	<td class="tableHeadings"></span> Short Desc       </td>
        
        <td class="tableHeadings">&nbsp;</td>
      </tr>
  		 <!-- first look for sub categories -->
		 <?php          
	  	if( $varNumOrgs > 0 ) 
		{
		  	do
			{
		 ?>
         <tr>
             <!-- now look for any products for this category -->
            <form id="form<?php echo $row_rsOrgs['org_id']; ?>" name="form<?php echo $row_rsOrgs['org_id']; ?>" method="post" action="page_orgs_edit.php">
        <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
        <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         <input type="hidden" name="org_id" value="<?php echo $row_rsOrgs['org_id']; ?>">
      	<td  class="tableFields" valign="top" ><?php echo $row_rsOrgs['sort_by']; ?>        </td>
        <td  class="tableFields" valign="top" >
         
         <?php echo $row_rsOrgs['name']; ?>         </td>
        <td  class="tableFields" valign="top" >
        <?php echo $row_rsOrgs['short_desc']; ?> 
       </td>
               
        <td width="150"  class="tableFields" valign="top" >
        <?php if( !$deleting ) { ?>
          <input name="Update" type="submit" id="Update" value="Edit" />
          <input name="Delete" type="submit" id="Delete" value="Delete" />    
          <?php } ?>
          </td>
        </form>
        </tr>
    <?php  
           } while ($row_rsOrgs = mysql_fetch_assoc($rsOrgs));
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
