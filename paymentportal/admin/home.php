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

require('checkaccess.php'); 
include("config.php");

////////////////////////////////////////
// CMS
require_once('../Connections/dbCMS.php'); 
include("db_utils.php");
include("db_misc_functions.php");

$page_id = 1;

// get content for this page
require_once('db_pages_get_byID.php');

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
<p><span class="pagetitle"> ADMINISTRATIVE HOME
  </span>
    <br/>
  
  <br/>
   <table border="0" cellpadding="0" cellspacing="0" width="600">
      <tr>
        <td colspan="14" valign="top" ><br/>
          <?php 
			  //echo $row_rsPages['image_file'];
			  if( strlen($row_rsPages['image_file']) > 0 ) 
			  {
			       
			  	   if( $row_rsPages['image_size'] == 1 )
				   		$image_file = 'cms/pages/thumbs/' . $row_rsPages['image_file'];
				   else
				   if( $row_rsPages['image_size'] == 3 )
				   		$image_file = 'cms/pages/fullsize/' . $row_rsPages['image_file'];
				   else
				   		$image_file = 'cms/pages/' . $row_rsPages['image_file'];
				   
				   $image_pos = '';
				   if( $row_rsPages['image_pos'] == 1 )
				   		$image_pos = 'float:left; margin-right:20px; ';
				   else
				   if( $row_rsPages['image_pos'] == 2 )
				   		$image_pos = 'float:right; margin-left:20px;  ';
				   		
				   if(  file_exists($image_file) )
				   {
				   		if( $row_rsPages['image_size'] == 3 )
				   			echo '<img src="' . $image_file . '" style="'.$image_pos.'margin-bottom:8px; margin-top:8px;"  border="0"/>'; 
						else
				   			echo '<a href="cms/pages/fullsize/' . $row_rsPages['image_file'] . '" target="_blank"><img src="' . $image_file . '" style="'.$image_pos.'margin-bottom:10px;" border="0" /></a>'; 
					}
					
			  }
			  ?>
                
           <?php 
		   
		   if( $row_rsPages['page_type_id'] == '70' || $row_rsPages['page_type_id'] == '71'  )
		   		echo 'Menu Page - please assign an "Alternate Landing Page" first sub page for this menu item';
		   else 
		   		echo stripParagraphTags($row_rsPages['complete_text']); 
		  
		   
		   ?>
           
           <?php if( $row_rsPages['back_button'] ) { 	?>
            <br/>
            <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Return to Previous Page</a>
           <?php } ?>
         
         </td>
      </tr>
    </table>
    <p>&nbsp;</p>
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
