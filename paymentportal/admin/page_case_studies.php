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
//require('db_misc_functions.php');

$DEBUGGING = false;

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$page_type_id 	= $_POST['page_type_id'];
	$page_title 	= $_POST['page_title'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_type_id	= $_GET['page_type_id'];
	$page_title 	= $_GET['page_title'];
}

if( $DEBUGGING )
{
	echo '<br/>page_id: ' . $page_id;
	echo '<br/>page_type_id: ' . $page_type_id;
	echo '<br/>page_title: ' . $page_title;
}

include("db_pages_get_byID.php");
$title = $row_rsPages['title'];

include("db_case_studies_get_all.php");
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
<span class="pagetitle"> <?php echo $title; ?>  </span>
     <table cellpadding="0" cellspacing="0">
    <tr>
    <td valign="middle">
    &nbsp;&nbsp;&nbsp;&nbsp;
    <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="page_edit.php">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
          <input name="Update" type="submit" id="Update" value="Update Title / Intro" />	
   	    </form>
	</td><td valign="middle" style="padding-left:10px;">        &nbsp;&nbsp;&nbsp;&nbsp;
   <!-- <form id="form0" name="form0" method="post" action="pages.php">
            <input type="submit" name="done" id="done" value="Return" />
         </form> -->
         </td></tr></table>  
    <br/>
    <hr size="1" />
    <br/>
  <table width="800" >
      <tr>
      	<td colspan="4">
            <table >
            <tr>
            <td>
          <form id="form0" name="form0" method="post" action="page_case_studies_add.php">
            <input type="submit" name="add" id="add" value="Add a Case Study" />
            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
            <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
            <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         </form> 
         </td>
         <td> 
          
            </td>
         </tr>
         </table>
     	</td>
        </tr>
      <tr>
      <td class="tableHeadings" width="100"> Date</td>
      	<td class="tableHeadings">Title	</span>        </td>
      	<td class="tableHeadings">Active	</span>        </td>
        
        <td class="tableHeadings">&nbsp;</td>
      </tr>
  		 <!-- first look for sub categories -->
		 <?php          
	  	if( $varNumStudies > 0 ) 
		{
		  	do
			{
		 ?>
         <tr>
             <!-- now look for any products for this category -->
            <form id="form<?php echo $row_rsCaseStudies['case_study_id']; ?>" name="form<?php echo $row_rsCaseStudies['case_study_id']; ?>" method="post" action="page_case_studies_edit.php">
        <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
        <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
        <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         <input type="hidden" name="case_study_id" value="<?php echo $row_rsCaseStudies['case_study_id']; ?>">
      	<td  class="tableFields" ><?php echo $row_rsCaseStudies['post_date']; ?>        </td>
        <td  class="tableFields" >  <?php echo $row_rsCaseStudies['title']; ?>         </td>
        <td  class="tableFields" > <?php if( $row_rsCaseStudies['active'] < 1 ) echo 'No'; ?>         </td>
        
               
        <td width="150"  class="tableFields" >
          <input name="Update" type="submit" id="Update" value="Edit" />
          <input name="Delete" type="submit" id="Delete" value="Delete" />    </td>
        </form>
        </tr>
    <?php  
           } while ($row_rsCaseStudies = mysql_fetch_assoc($rsCaseStudies));
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
