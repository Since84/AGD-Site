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

$page_id 		= $_POST['page_id'];
$page_title 	= $_POST['page_title'];
$page_type_id 	= $_POST['page_type_id'];
if( $DEBUGGING )
{
	echo '<br/>page type: ' . $page_type_id;
	echo '<br/>page id: ' . $page_id;
	echo '<br/>title ' . $page_title;
}

$returnURL = "page_portfolio.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id . '&page_title=' . $page_title;

if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_POST["ADDSTAFF"]) )
{
	$title 			= $_POST['title'];	
	$group_id 		= $_POST['group_id'];	
	$sort_by 		= $_POST['sort_by'];	
	$short_desc 	= stripslashes($_POST['short_desc']);	
	$description 	= stripslashes($_POST['description']);
	$image_file	 	= stripslashes($_POST['image_file']);	
	$active		 	= stripslashes($_POST['active']);	
	
	// edits
	$edits_ok = true;
	if( empty($_POST['title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title.</font><br/>';
		$edits_ok = false;
	}
	if( !isset($_FILES['image_file']['name']) )
	{
		$msg = $msg . '<font color="red">Image is required.</font><br/>';
		$edits_ok = false;
	}
	
	
	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
	
		$upload_ok = true; 
		
		if( isset($_FILES['image_file']['name']) )
		{
			// create new image defining obj
			$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
			require('image_upload.php');	
			$isManualCrop = $imageDef->isManualCrop();
		}

		if( $upload_ok )
		{
			//   GetSQLValueString($db_filename_pdf, "text"),
			
			// now update database
			require('db_portfolio_add.php'); 
			$product_id = addPortfolio($image_filename, $db_database, $db_connection);
			
			// if cropping manually, got to crop page first
			if( $isManualCrop )
			{
				//$returnURL = 'photo_crop.php?page_id='.$page_id.'&a=1&i=1';
				$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$title.'&image_file='.$image_filename.'&a=1&i=1';
				$_SESSION['returnURL'] = 'pages.php';
			}
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
		else
		{
			$msg = $msg . '<font color="red">Photo missing or upload failed.</font><br/>';
			$edits_ok = false;
		}
	}	
}

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
<span class="pagetitle">ADD PERSON to "<?php echo $page_title; ?>"</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDSTAFF" id="ADDSTAFF" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
       <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
            
	  <table width="700" cellpadding="1">
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td ><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == "on") echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
	  <tr>
	  	<td valign="top" ><div align="right">Group<br/>(also sort order)</div></td>
		<td valign="top"><input name="group_id" type="text" id="group_id" size="20" maxlength="10" value="<?php echo $group_id; ?>"/></td>
	  </tr>
	  <tr>
	  	<td width="175" valign="top" ><div align="right">Display Order<br/>(within group)</div></td>
		<td width="513">
        <input name="sort_by" type="text" id="sort_by" size="20" maxlength="20" value="<?php echo $_POST['sort_by']; ?>"/> 
              </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $_POST['title']; ?>"/></td>
	  </tr>
       <?php if( 0 ) { ?>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Short Description</div></td>
		<td>
        <?php 
		$oFCKeditor = new FCKeditor('short_desc') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $short_desc;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?> 
        </td>
	  </tr>
      <?php } ?>
       <tr>
	  	<td width="175" valign="top" ><div align="right">Image (jpg)</div></td>
		<td colspan="1">
        <input type="file" name="image_file" size="70">        </td>
	  </tr>
       <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;MAIN TEXT</td></tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"></div></td>
		<td><?php 
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $description;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
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
                  Note:  File uploading and resizing may take a several  minutes.  Please wait for it to complete.	
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
