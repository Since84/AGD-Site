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
require('image_defines.php');

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

include("fckeditor/fckeditor.php") ; 

$page_id = $_POST['page_id'];
$page_title = $_POST['page_title'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_help.php?page_id=" . $page_id . '&page_title=' . $page_title;

if( isset($_POST["ADDRESOURCE"]) )
{
	if( isset($_POST['Cancel']) )
	{
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	$sort_by	 		= $_POST['sort_by'];	
	$help_cat_id		= $_POST['help_cat_id'];	
	$title		 		= $_POST['title'];	
	$description 		= stripslashes($_POST['description']);	
	$resource_link 		= stripslashes($_POST['resource_link']);	
	
	// edits
	$edits_ok = true;
	if( empty($_POST['title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title.</font><br/>';
		$edits_ok = false;
	}
	if( !(isset($_FILES['resource_file']['name']) || isset($_POST['resource_link']) ||  isset($_POST['description'] )) )
	{
		$msg = $msg . '<font color="red">Please enter a description, link or file to upload. ".</font><br/>';
		$edits_ok = false;
	}
	

	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
	
		$upload_ok = true; 
		
		if( isset($_FILES['resource_file']['name']) && strlen($_FILES['resource_file']['name']) > 1 )
		{
			//echo 'file name: ' . $_FILES['resource_file']['name'];
				// input defines
				$max_pdf_size = 5000000;
				$pdf_folder   = $HELP_FOLDER; 
				$pdf_prefix   = 'help_';
				require('resource_upload.php');	
		}
				
		if( $upload_ok )
		{
			//   GetSQLValueString($db_filename_pdf, "text"),
			
			// now update database
			require('db_help_add.php'); 
			$product_id = addHelp($db_filename_pdf, $db_database, $db_connection);
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
		else
		{
			$msg = $msg . '<font color="red">File missing or upload failed.</font><br/>';
			$edits_ok = false;
		}
	}	
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
<span class="pagetitle">ADD Help to "<?php echo $page_title; ?>"</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDRESOURCE" id="ADDRESOURCE" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
            
	  <table width="800" cellpadding="1">
	  
	  <tr>
	  	<td width="175" valign="top" ><div align="right">Display Order</div></td>
		<td >
        <input name="sortby" type="text" id="sortby" size="20" maxlength="20" value="<?php echo $_POST['sortby']; ?>"/> 
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
		<td><input name="title" type="text" id="title" size="50" maxlength="255" value="<?php echo $_POST['title']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Link</div></td>
		<td><input name="resource_link" type="text" id="resource_link" size="50" maxlength="100" value="<?php echo $_POST['resource_link']; ?>"/></td>
	  </tr>
      <tr>
	  	<td width="175" valign="top" ><div align="right">PDF / Doc</div></td>
		<td colspan="1">
        <input type="file" name="resource_file" size="70">        </td>
	  </tr>
 		<tr>
	  	<td width="175" valign="top" ><div align="right">Description</div></td>
		<td colspan="1">
         <?php 
		  
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $description;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 300;
		$oFCKeditor->Create() ;
		
		?>
       </td>
	  </tr>
      <tr>
	  	<td width="175" valign="top">&nbsp;</td>
		<td>
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
       <tr>
	  	<td width="175" valign="top">&nbsp;</td>
		<td>
          <p>
                <span class="footer">
                  Note:  File uploading may take a several  minutes.  Please wait for it to complete.	
         </span></p>
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
