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

require('db_news_update.php'); 

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 
 
include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$page_type_id 	= $_POST['page_type_id'];
	$image_file 	= $_POST['image_file'];
	$news_id		= $_POST['news_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_type_id 	= $_GET['page_type_id'];
	$image_file 	= $_GET['image_file'];
	$news_id		= $_GET['news_id'];
}
//$page_type_id 	= 8;

include("db_pages_get_byID.php");
$page_title = $row_rsPages['title'];

if( $DEBUGGING )
{
	echo '<br/>page id: ' 		. $page_id;
	echo '<br/>page_type_id: ' 	. $page_type_id;
	echo '<br/>title ' 			. $page_title;
}

$returnURL = "page_news.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_type_id=%s&news_id=%s", "page_news_edit.php", $page_id, $page_type_id, $news_id);


if( isset($_POST['Archive']) )
{
	archiveNews($news_id, $db_database, $db_connection); 
	header(sprintf("Location: %s", $returnURL));
	exit();
}
else
if( isset($_POST['UnArchive']) )
{
	unArchiveNews($news_id, $db_database, $db_connection); 
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_POST['addPDF']) )
{
	$gotoURL = sprintf("fileadd.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $news_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['changePDF']) )
{
	$gotoURL = sprintf("filereplace.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $news_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['removePDF']) )
{
	$gotoURL = sprintf("fileremove.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $news_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

if( isset($_POST['ImageAdd'])  )
{
	$gotoURL = 'photoadd.php?id=' . $news_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['ImageReplace'])  )
{
	$gotoURL = 'photoreplace.php?id=' . $news_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

if( isset($_POST['ImageRemove'])  )
{
	$gotoURL = 'photoremove.php?id=' . $news_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

$image_filename	 	= $_POST['image_file'];
if( isset($_POST['ImageCrop'])  )
{
	$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=0&i=1';
	header(sprintf("Location: %s", $returnURL));
	exit();
}
if( isset($_POST['ThumbCrop'])  )
{
	$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=1&i=0';
	header(sprintf("Location: %s", $returnURL));
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
	$news_id 		= $_POST['news_id'];
	
	$active			= $_POST['active'];
	$title			= $_POST['title'];
	$title_short	= $_POST['short_title'];
	$snippet		= $_POST['snippet'];
	$news_date		= $_POST['news_date'];
	$complete_text	= $_POST['complete_text'];
	$contact_email 	= $_POST['contact_email'];

	if( $active == "on" )
		$active = 1;
	//echo '<br/>desc: ' . $_POST['description'];
	//$new = htmlspecialchars($_POST['description'], ENT_NOQUOTES);
	//echo '<br/>new: ' .  $new;
	
	
	if( $_POST['delete'] == true  )
	{
			// delete item
			$updateSQL = sprintf("DELETE FROM news WHERE news_id = %s LIMIT 1", $news_id );
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
		if( empty($_POST['snippet'])  )
		{
			$msg = $msg . '<font color="red">Please enter a snippet.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['news_date'])  )
		{
			$msg = $msg . '<font color="red">Please enter a date.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['complete_text'])  )
		{
			$msg = $msg . '<font color="red">Please enter full text.</font><br/>';
			$edits_ok = false;
		}
		// check length on snippet not exceeded
		include('textCounter.php'); 
		$maxlimit = 240;
		$ret_array = textCount($snippet, $maxlimit);
		if( $ret_array[0] )
		{	
			$msg = $msg . '<font color="red">Snippet length of ' . $maxlimit . ' exceeded.</font><br/>';
			$snippet = $ret_array[1];
			$edits_ok = false;
		}
		
		if($edits_ok)
		{
			$result = updateNews($snippet, $db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['news_id']) )
		$news_id = $_POST['news_id'];
	else
		$news_id = $_GET['news_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsNews = sprintf("SELECT * FROM news WHERE news_id = %s", $news_id);
	if( $DEBUGGING )
		echo $query_rsNews;
	$rsNews = mysql_query($query_rsNews, $db_connection) or die(mysql_error());
	$row_rsNews = mysql_fetch_assoc($rsNews);

	$active			= $row_rsNews['active'];
	$title			= stripslashes($row_rsNews['title']);
	$short_title	= stripslashes($row_rsNews['short_title']);
	$author			= stripslashes($row_rsNews['author']);
	$snippet		= stripslashes($row_rsNews['snippet']);
	$news_date		= $row_rsNews['news_date'];
	$complete_text	= stripslashes($row_rsNews['complete_text']);
	$contact_email 	= $row_rsNews['contact_email'];

	$image_file 	= $row_rsNews['image_file'];
	$pdf_file	 	= $row_rsNews['pdf_file'];
}

if( $DEBUGGING )
	echo 'calling defines';
$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
if( $DEBUGGING )
	echo 'done defines';

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
<script type="text/javascript">

// shows a calendar and updates form element named
function showCal(element_id)
{

var popWinParms = 'toolbar=no,location=no,directorie=no,status=no,menu=no,scrollbars=no,resizable=no,margin=0,width=250,height=250';

	popWin = window.open("../calendar/popDate.html", "calWindow", popWinParms);
	popWin.opener.top.name = element_id;
	popWin.focus();
}
// End -->
</script>
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
      <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>">
      <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="600" cellpadding="1">
	  
	   <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td  colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
    <tr>
	  	<td width="100" valign="top" class="Bold"><div align="right">News Date</div></td>
		<td  colspan="3"><input name="news_date" type="text" id="news_date" size="10" maxlength="50" value="<?php echo substr($news_date,0,10); ?>"/><img onclick="showCal('news_date')" src="../calendar/icon.gif" width="16" height="16" />&nbsp;&nbsp;(yyyy-mm-dd)</td>
      </tr> 
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="3"><input name="title" type="text" id="title" size="40" maxlength="100" value="<?php echo $title; ?>"/></td>
      </tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right">Short Title (left nav)</div></td>
		<td colspan="3"><input name="short_title" type="text" id="short_title" size="40" maxlength="100" value="<?php echo $short_title; ?>"/></td>
      </tr>
        <tr>
	  	<td valign="top" class="Bold"><div align="right">Author</div></td>
		<td colspan="3"><input name="author" type="text" id="author" size="40" maxlength="100" value="<?php echo $author; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Snippet</div></td>
		<td colspan="3"><?php 
		$oFCKeditor = new FCKeditor('snippet') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Value		= $snippet;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Create() ;
		?></td>
      </tr>
      <?php include("page_edit_PDF_inc.php"); ?>
      <?php include("page_edit_image_inc.php"); ?>
      <tr>
	  	<td valign="top" ><div align="right">Contact Email</div></td>
		<td colspan="3"><input name="contact_email" type="text" id="contact_email" size="40" maxlength="50" value="<?php echo $contact_email; ?>"/>&nbsp;&nbsp;</td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Full Text</div></td>
		<td colspan="3">
        
          <label>
          <?php 
		$oFCKeditor = new FCKeditor('complete_text') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Value		= $complete_text;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Create() ;
		?>
          </label></td>
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
