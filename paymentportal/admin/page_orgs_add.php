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

$returnURL = "page_orgs.php?page_id=" . $page_id . '$page_type_id=' . $page_type_id . '&page_title=' . $page_title;
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}


if( isset($_POST["ADDORG"]) )
{
	// edits
	$edits_ok = true;
	if( empty($_POST['name'])  )
	{
		$msg = $msg . '<font color="red">Please enter a name.</font><br/>';
		$edits_ok = false;
	}
	

	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
		
		$logoUploaded = false;
		if( strlen($_FILES['image_file']['name']) > 4 )
		{
			// create new image defining obj
			$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
			require('image_upload.php');	
			$isManualCrop = $imageDef->isManualCrop();

			$image1_filename = $image_filename;
			
			if( $upload_ok )
				$logoUploaded = true;

		}
		else
		{
			$upload_ok = true;
			$image1_filename = NULL;
		}

		if( $upload_ok )
		{
			//   GetSQLValueString($db_filename_pdf, "text"),
			
			// now update database
			require('db_org_add.php'); 
			$product_id = addOrg($image1_filename, $image2_filename, $image3_filename, $image4_filename, $db_database, $db_connection);
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
<span class="pagetitle">ADD  to "<?php echo $page_title; ?>"</span>
     <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDORG" id="ADDORG" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
       <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
            
	  <table width="700" cellpadding="1">
	  <tr>
        <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL <tr>
    	<td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL PAGE INFORMATION</td>
  	  <td>INFORMATION</td>
  	  </tr>
	  <tr>
	  	<td width="138" valign="top" class="Bold"><div align="right">Display Order</div></td>
		<td width="550">
        <input name="sort_by" type="text" id="sort_by" size="5" maxlength="50" value="<?php echo $_POST['sort_by']; ?>"/> 
              </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"> Name</div></td>
		<td><input name="name" type="text" id="name" size="30" maxlength="50" value="<?php echo $_POST['name']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Address</div></td>
		<td><input name="address" type="text" id="address" size="30" maxlength="50" value="<?php echo $_POST['address']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"> City</div></td>
		<td><input name="city" type="text" id="city" size="30" maxlength="50" value="<?php echo $_POST['city']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">State</div></td>
		<td><input name="state" type="text" id="state" size="4" maxlength="2" value="<?php echo $_POST['state']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Zip</div></td>
		<td><input name="zip" type="text" id="zip" size="10" maxlength="10" value="<?php echo $_POST['zip']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Phone</div></td>
		<td><input name="phone" type="text" id="phone" size="20" maxlength="20" value="<?php echo $_POST['phone']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Email</div></td>
		<td><input name="email" type="text" id="email" size="50" maxlength="50" value="<?php echo $_POST['email']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Website</div></td>
		<td><input name="website" type="text" id="website" size="50" maxlength="100" value="<?php echo $_POST['website']; ?>"/></td>
	  </tr>
      
      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE</td></tr>
      <tr>
	  	<td width="138" valign="top" ><div align="right">Main Logo (jpg)</div></td>
		<td colspan="1">
        <input type="file" name="image_file" size="70">        </td>
	  </tr>
      <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ADDITIONAL INFORMATION</td>
  	</tr>
      <tr>
	  	<td valign="top" ><div align="right"> Short Description</div></td>
		<td>
		  <label>
		  <textarea name="short_desc" cols="40" id="short_desc"><?php echo $_POST['short_desc']; ?></textarea>
		  </label></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right"><strong>Descripton&nbsp;</strong></div></td>
		<td><?php 
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $description;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 300;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
	  </tr>
      <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ACTION</td>
  </tr>
      <tr>
	  	<td width="138" valign="top">&nbsp;</td>
		<td>
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
       <tr>
	  	<td width="138" valign="top">&nbsp;</td>
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
