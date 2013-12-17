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
require('image_defines.php');

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 
 
include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$page_title 	= $_POST['page_title'];
	$help_id	= $_POST['help_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$help_id	= $_GET['help_id'];
}
$page_type_id 	= 3;

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_help.php?page_id=" . $page_id . '&page_title=' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_title=%s&help_id=%s", "page_resources_edit.php", $page_id, $page_title, $help_id);

if( isset($_POST['Delete']) )
	$deleting = true;
else
	$deleting = false;

if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}
	
if( isset($_POST["MM_update"]) )
{
	$help_id 		= $_POST['help_id'];
	
	$sort_by			= $_POST['sort_by'];	
	$help_cat_id		= $_POST['help_cat_id'];	
	$title		 		= $_POST['title'];	
	$description 		= $_POST['description'];	
	$resource_link 		= $_POST['resource_link'];
	$resource_file 		= $_POST['resource_file'];	
	

	//echo '<br/>desc: ' . $_POST['help_cat_id'];
	//$new = htmlspecialchars($_POST['description'], ENT_NOQUOTES);
	//echo '<br/>new: ' .  $new;
	
	
	if( $_POST['delete'] == true  )
	{
			if( $resource_file != NULL )
			{
					include("filedelete.php");
					$full_name	= '../' . $PAGES_PDF_FOLDER . $image_file;	
					deleteFile($resource_file);
			}
			// delete item
			$updateSQL = sprintf("DELETE FROM help WHERE help_id = %s LIMIT 1", $help_id );
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
			
			// echo '<br/>return: ' . $returnURL;
			
			header(sprintf("Location: %s", $returnURL));
			exit();
	}
	else
	{
		// edits
		$edits_ok = true;
		if( empty($_POST['title'])  )
		{
			$msg = $msg . '<font color="red">Please enter a title.</font><br/>';
			$edits_ok = false;
		}
		
		if($edits_ok)
		{
			require('db_help_update.php'); 
			$result = updateHelp($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['help_id']) )
		$help_id = $_POST['help_id'];
	else
		$help_id = $_GET['help_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsHelp = sprintf("SELECT * FROM help WHERE help_id = %s", $help_id);
	if( $DEBUGGING )
		echo $query_rsHelp;
	$rsHelp = mysql_query($query_rsHelp, $db_connection) or die(mysql_error());
	$row_rsHelp = mysql_fetch_assoc($rsHelp);

	$sort_by			= $row_rsHelp['sort_by'];	
	$help_cat_id		= $row_rsHelp['help_cat_id'];	
	$title 				= $row_rsHelp['title'];	
	$description 		= stripslashes($row_rsHelp['description']);	
	$resource_link 		= stripslashes($row_rsHelp['resource_link']);	
	$resource_file 		= stripslashes($row_rsHelp['resource_file']);
	
}
include("db_help_cat_get.php");
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
<span class="pagetitle"><?php echo ($deleting ? "DELETE" : "EDIT"); ?> from "<?php echo $page_title; ?>"</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="MM_update" value="MM_update">
      <input type="hidden" name="delete" value="<?php echo $deleting; ?>">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
      <input type="hidden" name="page_title" value="<?php echo $page_title; ?>">
      <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>">
      <input type="hidden" name="help_id" value="<?php echo $help_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="700" cellpadding="1">
	 
	  <tr>
	  	<td width="131" valign="top" ><div align="right">Display _order</div></td>
		<td width="557">
 <input name="sort_by" type="text" id="sort_by" size="20" maxlength="20" value="<?php echo $sort_by; ?>"/> 
        </td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Category</div></td>
		<td>
        <select name="help_cat_id" id="help_cat_id">
                  <?php
				  do { 
					?>
                  <option value="<?php echo $row_rsHelpCats['help_cat_id']; ?>"<?php if($help_cat_id == $row_rsHelpCats['help_cat_id']) echo ' selected="selected" '; ?>><?php echo $row_rsHelpCats['description']; ?></option>
                  <?php
				  }  while($row_rsHelpCats = mysql_fetch_assoc($rsHelpCats)); 
				  ?>
                </select>
        </td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Title</div></td>
		<td><input name="title" type="text" id="title" size="50" maxlength="255" value="<?php echo $title; ?>"/></td>
	  </tr>
 	  <tr>
	  	<td valign="top" ><div align="right">Link</div></td>
		<td><input name="resource_link" type="text" id="resource_link" size="50" maxlength="100" value="<?php echo $resource_link; ?>"/></td>
	  </tr>
      <tr>
	  	<td width="131" valign="top" ><div align="right">PDF / Doc</div></td>
		<td colspan="1">
        <?php if( strlen($resource_file) > 0 ) { ?>
        <a href="../<?php echo $PDF_FOLDER; ?><?php echo $resource_file; ?>">View File</a><br/>To change or remove this file, please delete this item and re-add.       
        <?php } ?>
        </td>
	  </tr>
      <tr>
	  	<td width="131" valign="top" ><div align="right">Description</div></td>
		<td colspan="1">
     <?php 
		  
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $description;
		$oFCKeditor->ToolbarSet = 'SkyDefault';
		$oFCKeditor->Width = 600;
		$oFCKeditor->Height = 500;
		$oFCKeditor->Create() ;
		
		?>   
       </td>
	  </tr>
      <tr>
	  	<td width="131" valign="top">&nbsp;</td>
		<td>
        <input name="Update2" type="submit" id="Update2" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
        </td>
	  </tr>
       <tr>
	  	<td width="131" valign="top">&nbsp;</td>
		<td>
        <br/><br/>
        
        </td>
	  </tr>
	  </table>
	  </form>
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
