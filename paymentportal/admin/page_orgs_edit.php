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
	$org_id			= $_POST['org_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$org_id			= $_GET['org_id'];
}
$page_type_id 	= 4;

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_orgs.php?page_id=" . $page_id . '&page_title=' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_title=%s&org_id=%s", "page_orgs_edit.php", $page_id, $page_title, $org_id);

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
	$org_id 		= $_POST['org_id'];
	
	$sort_by		= $_POST['sort_by'];	
	$name 			= $_POST['name'];	
	$phone		 	= $_POST['phone'];	
	$address 		= $_POST['address'];	
	$city		 	= $_POST['city'];	
	$state		 	= $_POST['state'];	
	$zip		 	= $_POST['zip'];	
	$website		= $_POST['website'];	
	$email		 	= $_POST['email'];	
	$image_file 	= $_POST['image_file'];		// logo
	$short_desc 	= $_POST['short_desc'];	
	$description 	= $_POST['description'];
	$image2_file 	= $_POST['image2_file'];		// thumb 1	
	$image3_file 	= $_POST['image3_file'];		// thumb 2	
	$image4_file 	= $_POST['image4_file'];		// thumb 3			

	if( isset($_POST['ImageAdd'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $org_id . '&type_id=' . $page_type_id . '&title=' . $page_title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $org_id . '&type_id=' . $page_type_id . '&title=' . $page_title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageRemove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $org_id . '&type_id=' . $page_type_id . '&title=' . $page_title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}

	$image_filename	 	= $_POST['image_file'];
	if( isset($_POST['ImageCrop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$page_title.'&image_file='.$image_filename.'&a=1&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	if( isset($_POST['ThumbCrop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$page_title.'&image_file='.$image_filename.'&a=1&i=0';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	//echo '<br/>desc: ' . $_POST['description'];
	//$new = htmlspecialchars($_POST['description'], ENT_NOQUOTES);
	//echo '<br/>new: ' .  $new;
	
	
	if( $_POST['delete'] == true  )
	{
			if( $image_file != NULL )
			{
				include("photodelete.php");
				deletePhotos($logo_imagefolder, $image_file);
			}
			// delete item
			$updateSQL = sprintf("DELETE FROM organizations WHERE org_id = %s LIMIT 1", $org_id );
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
		if( empty($_POST['name'])  )
		{
			$msg = $msg . '<font color="red">Please enter a name.</font><br/>';
			$edits_ok = false;
		}
		
			
		if($edits_ok)
		{
			require('db_org_update.php'); 
			$result = updateOrg($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['org_id']) )
		$org_id = $_POST['org_id'];
	else
		$org_id = $_GET['org_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsOrgs = sprintf("SELECT * FROM organizations WHERE org_id = %s", $org_id);
	if( $DEBUGGING )
		echo $query_rsOrgs;
	$rsOrgs = mysql_query($query_rsOrgs, $db_connection) or die(mysql_error());
	$row_rsOrgs = mysql_fetch_assoc($rsOrgs);

	$sort_by		= $row_rsOrgs['sort_by'];	
	$name 			= $row_rsOrgs['name'];	
	$phone		 	= $row_rsOrgs['phone'];	
	$address 		= $row_rsOrgs['address'];	
	$city		 	= $row_rsOrgs['city'];	
	$state		 	= $row_rsOrgs['state'];	
	$zip		 	= $row_rsOrgs['zip'];	
	$website		= $row_rsOrgs['website'];	
	$email		 	= $row_rsOrgs['email'];	
	$image_file 	= $row_rsOrgs['image_file'];		// logo
	$short_desc 	= stripslashes($row_rsOrgs['short_desc']);	
	$description 	= stripslashes($row_rsOrgs['description']);	
	$image2_file 	= $row_rsOrgs['image2_file'];		// thumb 1	
	$image3_file	= $row_rsOrgs['image3_file'];		// thumb 2	
	$image4_file 	= $row_rsOrgs['image4_file'];		// thumb 3	
}
$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
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
      <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="600" cellpadding="1">
	  <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL INFORMATION</td>
  </tr>
	   <tr>
	  	<td width="27%" valign="top" ><div align="right">Display Order</div></td>
		<td width="73%">
        <input name="sort_by" type="text" id="sort_by" size="5" maxlength="50" value="<?php echo $sort_by; ?>"/> 
              </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"> Name</div></td>
		<td><input name="name" type="text" id="name" size="30" maxlength="50" value="<?php echo $name; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Address</div></td>
		<td><input name="address" type="text" id="address" size="30" maxlength="50" value="<?php echo $address; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"> City</div></td>
		<td><input name="city" type="text" id="city" size="30" maxlength="50" value="<?php echo $city; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">State</div></td>
		<td><input name="state" type="text" id="state" size="4" maxlength="2" value="<?php echo $state; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Zip</div></td>
		<td><input name="zip" type="text" id="zip" size="10" maxlength="10" value="<?php echo $zip; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Phone</div></td>
		<td><input name="phone" type="text" id="phone" size="20" maxlength="20" value="<?php echo $phone; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Email</div></td>
		<td><input name="email" type="text" id="email" size="50" maxlength="50" value="<?php echo $email; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Website</div></td>
		<td><input name="website" type="text" id="website" size="50" maxlength="100" value="<?php echo $website; ?>"/></td>
	  </tr>
      <?php include("page_edit_image_inc.php"); ?>
      <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ADDTIONAL INFORMATION</td>
  </tr>
       <tr>
	  	<td valign="top" ><div align="right"> Short Description</div></td>
		<td>
		  <label>
		  <textarea name="short_desc" cols="40" id="short_desc"><?php echo $short_desc; ?></textarea>
		  </label></td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Descripton&nbsp;</strong></div></td>
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
	  	<td width="133" valign="top">&nbsp;</td>
		<td>
        <input name="Update2" type="submit" id="Update2" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
        </td>
	  </tr>
       <tr>
	  	<td width="133" valign="top">&nbsp;</td>
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