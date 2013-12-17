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

$page_id = $_POST['page_id'];
$page_title = $_POST['page_title'];
$just_videos = false;
if( isset($_POST['just_videos']) )
	$just_videos = $_POST['just_videos'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_videos.php?page_id=" . $page_id . '&page_title=' . $page_title;
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}
	

if( isset($_POST["ADDVIDEO"]) )
{
	$display_order	= $_POST['display_order'];
	$title	= $_POST['title'];
	$other1 = $_POST['other1'];
	$other2 = $_POST['other2'];
	$other3 = $_POST['other3'];
	
	// edits
	$edits_ok = true;
	if( empty($_POST['title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title.</font><br/>';
		$edits_ok = false;
	}
		
	if( $edits_ok )
	{
		// first upload files
		$max_pdf_size = 10000000;
		$pdf_folder   = $PAGES_VIDEO_FOLDER;
		$pdf_prefix   = $PAGES_VIDEO_PREFIX;
		require('db_flash_upload.php');
	}
		
	// if passed edits, update	
	if($edits_ok && $upload_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
		
		// now update database
		require('db_videos_add.php'); 
		$product_id = addVideo($db_filename_pdf, $db_filename2_pdf, $db_database, $db_connection);
		header(sprintf("Location: %s", $returnURL));
		exit();
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
	  <input type="hidden" name="ADDVIDEO" id="ADDVIDEO" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
            
	  <table width="600" cellpadding="1">
	  
	  <tr>
	  	<td width="27%" valign="top" class="Bold"><div align="right">Display Order</div></td>
		<td width="73%">
        <input name="display_order" type="text" id="display_order" size="5" maxlength="50" value="<?php echo $display_order; ?>"/> 
              </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Title&nbsp;</strong></div></td>
		<td><input name="title" type="text" id="title" size="40" maxlength="255" value="<?php echo $title; ?>"/> 
          </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Flash .swf File</strong></div></td>
		<td><input type="file" name="pdf_file" size="70" />
          </td>
	  </tr>
      <tr>
	  	<td valign="top"><div align="right"><strong>Flash .flv File</strong></div></td>
		<td><input type="file" name="pdf_file2" size="70" />
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
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
       <tr>
	  	<td width="133" valign="top">&nbsp;</td>
		<td>
          <p>
                </p>
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
