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

$page_id 		= $_POST['page_id'];
$page_type_id 	= $_POST['page_type_id'];

include("db_pages_get_byID.php");
$page_title = $row_rsPages['title'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_news.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id . '&page_title=' . $page_title;
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}
	

if( isset($_POST["ADDNEWS"]) )
{
	$active			= $_POST['active'];
	$title			= $_POST['title'];
	$short_title	= $_POST['short_title'];
	$author			= $_POST['author'];
	$snippet		= $_POST['snippet'];
	$news_date		= $_POST['news_date'];
	$complete_text	= $_POST['complete_text'];
	$contact_email 	= $_POST['contact_email'];

	$admin_lvls		= $_POST['admin_lvls'];
	
	if( isset($_FILES['pdf_file']['name'])  )
		$pdf_file = $_FILES['pdf_file']['name'];
	else
		$pdf_file = NULL;

	if( isset($_FILES['image_file']['name'])  )
		$image_file = $_FILES['image_file']['name'];
	else
		$image_file = NULL;


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

	// if passed edits, update	
	if($edits_ok)
	{
			// first upload pdf files
		if( $pdf_file )
		{
			$max_pdf_size = 5000000;
			$pdf_folder   = $PAGES_PDF_FOLDER;
			$pdf_prefix   = $PAGE_IMG_PREFIX;
			require('db_pdf_upload.php');
		}
		else
		{
			$upload_ok = true;
		}
		
		if( $upload_ok && $image_file )
		{
			// create new image defining obj
			$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
			require('image_upload.php');	
			$isManualCrop = $imageDef->isManualCrop();
		}
	
		if( $upload_ok )
		{

			// now update database
			require('db_news_add.php'); 
			$product_id = addNews($db_filename_pdf, $image_filename, $db_database, $db_connection);
			
			// if cropping manually, got to crop page first
			if( $isManualCrop )
			{
				$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$title.'&image_file='.$image_filename.'&a=1&i=1';
				$_SESSION['returnURL'] = 'pages.php';
			}
			
			header(sprintf("Location: %s", $returnURL));
			exit();
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
<span class="pagetitle">ADD  to "<?php echo $page_title; ?>"</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDNEWS" id="ADDNEWS" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
            
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
      <tr>
	  	<td valign="top" ><div align="right">PDF</div></td>
		<td colspan="3" valign="top">
          <input type="file" name="pdf_file" size="70">       </td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Image</div></td>
		<td colspan="3" valign="top">
          <input type="file" name="image_file" size="70">       </td>
      </tr>
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
	  	<td valign="top">&nbsp;</td>
		<td colspan="3"> 
        <input name="ADDNEWS" type="submit" id="ADDNEWS" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
         <p>&nbsp;</p>        </td>
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
