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

require_once('db_portfolio_update.php'); 

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 
 
include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;
$staffphoto_imagefolder = "cms/staffphotos/";

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$page_title 	= $_POST['page_title'];
	$page_type_id 	= $_POST['page_type_id'];
	$portfolio_id		= $_POST['portfolio_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$page_type_id 	= $_GET['page_type_id'];
	$portfolio_id		= $_GET['portfolio_id'];
}


// create new image defining obj
$imageDef 	 = new imageDefines($page_type_id, $db_database, $db_connection);

			
//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_portfolio.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id . '&page_title=' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_type_id=%s&page_title=%s&portfolio_id=%s", "page_portfolio_edit.php", $page_id, $page_type_id, $page_title, $portfolio_id);

if( isset($_POST['Delete']) )
	$deleting = true;
else
	$deleting = false;
	
if( isset($_POST['Archive']) )
{
	archivePortfolio($portfolio_id, $db_database, $db_connection); 
	header(sprintf("Location: %s", $returnURL));
	exit();
}
else
if( isset($_POST['UnArchive']) )
{
	unArchivePortfolio($portfolio_id, $db_database, $db_connection); 
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}
	
if( isset($_POST["MM_update"]) )
{
	$portfolio_id 		= $_POST['portfolio_id'];
	
	$sort_by		= $_POST['sort_by'];	
	$title		 	= $_POST['title'];	
	$group_id		 	= $_POST['group_id'];	
	$short_desc 	= $_POST['short_desc'];	
	$description 	= $_POST['description'];
	$image_file 	= $_POST['image_file'];	
	$active		 	= $_POST['active'];	
	

	if( isset($_POST['ImageAdd'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $portfolio_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $portfolio_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ThumbReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $portfolio_id . '&type_id=' . $page_type_id . '&title=' . $title . '&thumbonly=1'.'&thumb_file='.$image_file;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageRemove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $portfolio_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}

	if( isset($_POST['ImageCrop'])  )
	{
		//$gotoURL = 'photo_crop.php?page_id=' . $page_id . '&i=1';
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=0&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	if( isset($_POST['ThumbCrop'])  )
	{
		//$gotoURL = 'photo_crop.php?page_id=' . $page_id . '&i=0';
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=1&i=0';
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
				deletePhotos($photo_imagefolder, $image_file);
			}
			// delete item
			$updateSQL = sprintf("DELETE FROM portfolio WHERE portfolio_id = %s LIMIT 1", $portfolio_id );
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
		if( empty($_POST['description'])  )
		{
			$msg = $msg . '<font color="red">Please enter a description".</font><br/>';
			$edits_ok = false;
		}
		
		if($edits_ok)
		{
			$result = updatePortfolio($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['portfolio_id']) )
		$portfolio_id = $_POST['portfolio_id'];
	else
		$portfolio_id = $_GET['portfolio_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsPortfolio = sprintf("SELECT * FROM portfolio WHERE portfolio_id = %s", $portfolio_id);
	if( $DEBUGGING )
		echo $query_rsPortfolio;
	$rsPortfolio = mysql_query($query_rsPortfolio, $db_connection) or die(mysql_error());
	$row_rsPortfolio = mysql_fetch_assoc($rsPortfolio);

	$sort_by		= $row_rsPortfolio['sort_by'];	
	$title 			= $row_rsPortfolio['title'];	
	$group_id 		= $row_rsPortfolio['group_id'];	
	$image_file		= $row_rsPortfolio['image_file'];	
	$short_desc 	= stripslashes($row_rsPortfolio['short_desc']);	
	$description 	= stripslashes($row_rsPortfolio['description']);	
	$active		 	= $row_rsPortfolio['active'];	
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
      <input type="hidden" name="portfolio_id" value="<?php echo $portfolio_id; ?>">
      <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="800" cellpadding="1">
	 <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL</td></tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td ><label> <input type="checkbox" name="active" id="active" <?php if($active == "on") echo 'checked="checked"'; ?> />		</label></td>
  	</tr> 
     <tr>
	  	<td valign="top" ><div align="right">Group<br/>(also sort order)</div></td>
		<td valign="top"><input name="group_id" type="text" id="group_id" size="20" maxlength="10" value="<?php echo $group_id; ?>"/></td>
	  </tr>
	  <tr>
	  	<td width="169" valign="top" ><div align="right">Display _order<br/>(within group)</div></td>
		<td width="619" valign="top">
 <input name="sort_by" type="text" id="sort_by" size="20" maxlength="20" value="<?php echo $sort_by; ?>"/> 
        </td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Title</div></td>
		<td><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $title; ?>"/></td>
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
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?> 
        </td>
	  </tr>
	  <?php } ?>
	  <?php include("page_edit_image_inc.php"); ?>
      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;OR VIDEO</td></tr>
            <tr><td colspan="2" height="20"></td></tr>
            <tr>
                <td valign="top" class="Bold"><div align="right"><strong>YouTube Code</strong></div></td>
                <td><input type="text" name="short_desc" size="70" value="<?php echo $short_desc; ?>"/></td>
            </tr>
       
 	<tr><td bgcolor="#efefef" ><div align="right"></div></td><td colspan="3" bgcolor="#efefef"></td></tr>
     <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Title</div></td>
		<td><input name="step3_title" type="text" id="step3_title" size="100" maxlength="255" value="<?php echo $step3_title; ?>"/></td>
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

      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ACTION</td></tr>

      <tr>
	  	<td width="169" valign="top">&nbsp;</td>
		<td>
        <input name="Update2" type="submit" id="Update2" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
        </td>
	  </tr>
       <tr>
	  	<td width="169" valign="top">&nbsp;</td>
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
