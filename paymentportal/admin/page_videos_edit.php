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
	$video_id			= $_POST['video_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$video_id			= $_GET['video_id'];
}
$page_type_id 	= 9;

$just_videos = false;
if( isset($_POST['just_videos']) )
	$just_videos = $_POST['just_videos'];


$returnURL = "page_videos.php?page_id=" . $page_id . '&page_title=' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_title=%s&video_id=%s", "page_videos_edit.php", $page_id, $page_title, $video_id);

if( isset($_POST['changePDF']) )
{
	$gotoURL = sprintf("flashreplace.php?type_id=%s&page_title=%s&id=%s", $page_type_id, $page_title, $video_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}


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
	$video_id 		= $_POST['video_id'];
	
	$display_order		= $_POST['display_order'];	
	$title 				= $_POST['title'];	
	$other1				= $_POST['other1'];	
	$other2				= $_POST['other2'];	
	$other3				= $_POST['other3'];	
	$other4				= $_POST['other4'];	
	
	
	if( $_POST['delete'] == true  )
	{
			// delete image
			mysql_select_db($db_database, $db_connection);
			$query_rsVideos = sprintf("SELECT * FROM videos WHERE page_id = %s ORDER BY display_order, title ", $page_id);
			//echo $query_rsVideos;
			$rsVideos = mysql_query($query_rsVideos, $db_connection) or die(mysql_error());
			$row_rsVideos = mysql_fetch_assoc($rsVideos);
			$varNumVideos = mysql_num_rows($rsVideos);
			include("filedelete.php");
			deleteFile($PAGES_VIDEO_FOLDER, $row_rsVideos['swf']);
			deleteFile($PAGES_VIDEO_FOLDER, $row_rsVideos['flv']);
			

			// delete item
			$updateSQL = sprintf("DELETE FROM videos WHERE video_id = %s LIMIT 1", $video_id );
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
			
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
			require('db_videos_update.php'); 
			$result = updateVideo($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['video_id']) )
		$video_id = $_POST['video_id'];
	else
		$video_id = $_GET['video_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsVideos = sprintf("SELECT * FROM videos WHERE video_id = %s", $video_id);
	if( $DEBUGGING )
		echo $query_rsVideos;
	$rsVideos = mysql_query($query_rsVideos, $db_connection) or die(mysql_error());
	$row_rsVideos = mysql_fetch_assoc($rsVideos);

	$display_order	= $row_rsVideos['display_order'];	
	$title 			= stripslashes($row_rsVideos['title']);	
	$swf 		= stripslashes($row_rsVideos['swf']);		
	$flv 		= stripslashes($row_rsVideos['flv']);
	$other1		= stripslashes($row_rsVideos['other1']);		
	$other2		= stripslashes($row_rsVideos['other2']);		
	$other3		= stripslashes($row_rsVideos['other3']);		
	$other4		= stripslashes($row_rsVideos['other4']);		
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
      <input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="800" cellpadding="1">
	  
	   <tr>
	  	<td width="27%" valign="top" class="Bold"><div align="right">Display Order</div></td>
		<td width="73%">
        <input name="display_order" type="text" id="display_order" size="5" maxlength="50" value="<?php echo $display_order; ?>"/> 
              </td>
	  </tr>
     <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Title&nbsp;</strong></div></td>
		<td><input name="title" type="text" id="title" size="50" maxlength="50" value="<?php echo $title; ?>"/> 
          </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Video Files</strong></div></td>
		<td>
         <?php if( strlen($swf) > 0 ) { ?>
          &nbsp;<a href="../<?php echo $PAGES_VIDEO_FOLDER . $swf;?>" target="_blank"><?php echo $baseURL . '/' . $PAGES_VIDEO_FOLDER . $swf;?></a>&nbsp;&nbsp;&nbsp;
		   <br/>
         <?php if( strlen($flv) > 0 ) { ?>
          &nbsp;<a href="../<?php echo $PAGES_VIDEO_FOLDER . $flv;?>" target="_blank"><?php echo $baseURL . '/' . $PAGES_VIDEO_FOLDER . $flv;?></a>&nbsp;&nbsp;&nbsp;
          <?php } ?>
		  <input type="submit" name="changePDF" id="changePDF" value="Replace" />
		   <?php }
		   ?>  
		
        
          </td>
	  </tr>
       <?php if( !$just_videos ) { ?>
 	<tr>
	  	<td valign="top" ><div align="right">Featured Quote</div></td>
		<td colspan="2"><textarea name="other1" cols="40" id="other1"><?php echo $other1; ?></textarea></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Author</div></td>
		<td colspan="2"><input name="other2" type="text" id="other2" size="50" maxlength="100" value="<?php echo $other2; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Author's Title</div></td>
		<td colspan="2"><input name="other3" type="text" id="other3" size="50" maxlength="100" value="<?php echo $other3; ?>"/></td>
      </tr>
      <?php } ?>
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
