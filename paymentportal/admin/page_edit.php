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
include("db_utils.php");
include("image_defines.php");

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 

include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;

if( $DEBUGGING )
	echo'debug on';

$page_nav_id = 0;
	
$returnURL = "pages.php";

if( isset($_POST['Delete']) )
	$deleting = true;
else
	$deleting = false;
	
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$title 			= $_POST['title'];
	$page_type_id 	= $_POST['page_type_id'];
	$image_file 	= $_POST['image_file'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$title 			= $_GET['title'];
	$page_type_id 	= $_GET['page_type_id'];
	$image_file 	= $_GET['image_file'];
}

if( $DEBUGGING )
{
	echo '<br/>page_id: ' . $page_id;
	echo '<br/>page_type_id: ' . $page_type_id;
}

// TRIAGE SPECIFIC
if( $_SESSION['AdminLevel'] < 9 )
{
	if( $page_id == 8 || $page_id == 9 || $page_id == 41 || $page_id == 42 )
	{
		header(sprintf("Location: %s", "staff.php"));
		exit();
	}
}

//echo 'page_type_id: ' . $page_type_id;
$pdf_folder = '../ ' . $PAGES_PDF_FOLDER;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s", "page_edit.php", $page_id);

if( isset($_POST['addPDF']) )
{
	$gotoURL = sprintf("fileadd.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $page_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['changePDF']) )
{
	$gotoURL = sprintf("filereplace.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $page_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['removePDF']) )
{
	$gotoURL = sprintf("fileremove.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $page_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

	
if( isset($_POST['ImageAdd'])  )
{
	$gotoURL = 'photoadd.php?id=' . $page_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['ImageReplace'])  )
{
	$gotoURL = 'photoreplace.php?id=' . $page_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

if( isset($_POST['ImageRemove'])  )
{
	$gotoURL = 'photoremove.php?id=' . $page_id . '&type_id=' . $page_type_id . '&title=' . $title;
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

$image_filename	 	= $_POST['image_file'];
if( isset($_POST['ImageCrop'])  )
{
	$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$title.'&image_file='.$image_filename.'&a=1&i=1';
	header(sprintf("Location: %s", $returnURL));
	exit();
}
if( isset($_POST['ThumbCrop'])  )
{
	$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&page_title='.$title.'&image_file='.$image_filename.'&a=1&i=0';
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_POST['changeVideo']) )
{
	$gotoURL = sprintf("flashreplace.php?type_id=%s&page_title=%s&id=%s", $page_type_id, $title, $page_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
	
//echo 'news id: ' . $page_id;
	
if( isset($_POST["UPDATE"]) )
{
	$active	 		= $_POST['active'];
	$last_update 	= $_POST['last_update'];
	$title 			= $_POST['title'];
	$sub_title 		= $_POST['sub_title'];
	$sub_nav_title 	= $_POST['sub_nav_title'];
	$snippet 		= $_POST['snippet'];
	$other	 		= $_POST['other'];
	$other2	 		= $_POST['other2'];
	$other3	 		= $_POST['other3'];
	$other4	 		= $_POST['other4'];
	$other5	 		= $_POST['other5'];
	$other6	 		= $_POST['other6'];
	$other7	 		= $_POST['other7'];
	$other8	 		= $_POST['other8'];
	$other9	 		= $_POST['other9'];
	$complete_text 	= $_POST['complete_text'];

	$pdf_file	 	= $_POST['pdf_file'];
	$image_file	 	= $_POST['image_file'];
	
	$admin_lvls		= $_POST['admin_lvls'];

	$parent_id			= $_POST['parent_id'];
	$left_nav_pos	 	= $_POST['left_nav_pos'];
	$alt_landing_page 	= $_POST['alt_landing_page'];
	$back_button		= $_POST['back_button'];
	
	$meta_description 	= $_POST['meta_description'];
	$meta_keywords 		= $_POST['meta_keywords'];
	$meta_title			= $_POST['meta_title'];

	$permalink			= $_POST['permalink'];
	
	$main_menu			= $_POST['main_menu'];
	$footer				= $_POST['footer'];
	$header_id			= $_POST['header_id'];
	

	$pdf_file = $_POST['pdf_file'];


	if( isset($_POST['deleteVideo']) )
	{
		if( $DEBUGGING )
			echo 'deleting videos';
			
		include("filedelete.php");
		
		$full_file_name = $PAGES_VIDEO_FOLDER . $_POST['pdf_file'];
		deleteFile($full_file_name);
		$full_file_name = $PAGES_VIDEO_FOLDER . $_POST['pdf_file2'];
		deleteFile($full_file_name);
		
		$_POST['other8'] = '';
		$_POST['other9'] = '';

	}


	if( $_POST['delete'] == true  )
	{
	
		mysql_select_db($db_database, $db_connection);
		$query_rsPages = sprintf("SELECT * FROM pages WHERE parent_id = %s", $page_id);
		$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
		$row_rsPages = mysql_fetch_assoc($rsPages);
		$varNum = mysql_num_rows($rsPages);
		if( $varNum > 0 )
		{
			$msg = $msg . '<font color="red">Cannot delete:  This page has sub pages assigned to it.</font><br/>';
			$edits_ok = false;		}
		else
		{
			
			// echo 'deleting: ' . $page_id;
			if( $pdf_file )
			{
				include('filedelete.php');
				$tmp = "../" . $PAGES_PDF_FOLDER . $pdf_file;
				deleteFile($tmp);
			}
			
			// delete image
			if( $image_file != NULL )
			{
					include("photodelete.php");
					deletePhotos($page_imagefolder, $image_file);
			}
				
			// delete item
			$updateSQL = sprintf("DELETE FROM pages WHERE page_id = %s LIMIT 1", $page_id );
			//echo $updateSQL;
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
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
		if( empty($_POST['sub_nav_title'])  )
		{
			$msg = $msg . '<font color="red">Please enter a navigation (link) title.</font><br/>';
			$edits_ok = false;
		}
		if( $page_type_id == '70' && $parent_id > 0 )
		{
			$msg = $msg . '<font color="red">Cannot assign a parent page to a main menu page.</font><br/>';
			$edits_ok = false;
		}
		// check length on snippet not exceeded
		/*
		include('textCounter.php'); 
		$maxlimit = 90;
		$ret_array = textCount($snippet, $maxlimit);
		if( $ret_array[0] )
		{
			$msg = $msg . '<font color="red">Snippet length of ' . $maxlimit . ' exceeded.</font><br/>';
			$snippet = $ret_array[1];
			$edits_ok = false;
		}	
		*/
		
		// if passed edits, update	
		if($edits_ok)
		{
			// now update database
			require('db_page_updt.php'); 
			updatePage($db_database, $db_connection);	
		
			header(sprintf("Location: %s", $returnURL));
			exit();
		}	
	}
}
else
{
	mysql_select_db($db_database, $db_connection);
	$query_rsPages = sprintf("SELECT * FROM pages WHERE page_id = %s", $page_id);
	$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
	$row_rsPages = mysql_fetch_assoc($rsPages);
	
	$active	 		= $row_rsPages['active'];
	$last_update 	= $row_rsPages['last_update'];
	$title 			= $row_rsPages['title'];
	$sub_title 		= $row_rsPages['sub_title'];
	$sub_nav_title	= $row_rsPages['sub_nav_title'];
	$snippet 		= stripslashes($row_rsPages['snippet']);
	$other	 		= stripslashes($row_rsPages['other']);
	$other2	 		= stripslashes($row_rsPages['other2']);
	$other3	 		= stripslashes($row_rsPages['other3']);
	$other4	 		= stripslashes($row_rsPages['other4']);
	$other5	 		= stripslashes($row_rsPages['other5']);
	$other6	 		= stripslashes($row_rsPages['other6']);
	$other7	 		= stripslashes($row_rsPages['other7']);
	$other8	 		= stripslashes($row_rsPages['other8']);
	$other9	 		= stripslashes($row_rsPages['other9']);
	$complete_text 	= stripslashes($row_rsPages['complete_text']);
	
	$page_type_id	= $row_rsPages['page_type_id'];
	
	$pdf_file	 	= $row_rsPages['pdf_file'];
	$image_file	 	= $row_rsPages['image_file'];
	$image_size	 	= $row_rsPages['image_size'];
	$image_pos	 	= $row_rsPages['image_pos'];
	
	$admin_lvls     	= explode(",", $row_rsPages['admin_lvls']);
	
	$parent_id			= $row_rsPages['parent_id'];
	$left_nav_pos		= $row_rsPages['left_nav_pos'];
	$alt_landing_page	= $row_rsPages['alt_landing_page'];
	$back_button		= $row_rsPages['back_button'];
	
	$meta_description 	= $row_rsPages['meta_description'];
	$meta_keywords 		= $row_rsPages['meta_keywords'];
	$meta_title			= $row_rsPages['meta_title'];
	
	$permalink			= $row_rsPages['permalink'];
		
	$main_menu			= $row_rsPages['main_menu'];
	$footer				= $row_rsPages['footer'];
	$header_id			= $row_rsPages['header_id'];
	
	
}

$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);

include("db_page_types_get.php");
include("db_admin_lvl_get.php");
include("db_pages_get_all.php");
include("db_headers_get.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $companyFROM; ?> - Admin</title>
<script type="text/javascript">

// shows a calendar and updates form element named
function showCal(element_id)
{
	
var popWinParms = 'toolbar=no,location=no,directorie=no,status=no,menu=no,scrollbars=no,resizable=no,margin=0,width=250,height=250';

	popWin = window.open("calendar/popDate.html", "calWindow", popWinParms);
	popWin.opener.top.name = element_id;
	popWin.focus();
}
// End -->
</script>
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
    

 <table width="700">
      <tr>
      <td>
      <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="">
      <input type="hidden" name="UPDATE" id="UPDATE" value="1"  />
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
      <input type="hidden" name="delete" value="<?php echo $deleting; ?>">
      <input type="hidden" name="title" value="<?php echo $title; ?>" />
       <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
       <input type="hidden" name="image_file" value="<?php echo $image_file; ?>" />
      <input type="hidden" name="returnURL" value="<?php echo 'page_edit.php?page_id=' . $page_id; ?>" />
      
       <?php if( $page_type_id == 14 ) { ?>
       <input type="hidden" name="other8" value="<?php echo $other8; ?>">
       <input type="hidden" name="other9" value="<?php echo $other9; ?>">
       <?php } ?>
      
      <table width="111%" border="0" cellspacing="0" cellpadding="2" style="margin-left:10px;">
  <tr>
  <td colspan="4" class="pagetitle"><br />
   <?php if( $deleting ) echo 'DELETING'; else echo 'UPDATING'; ?> "<?php echo $title; ?>"   
   <br/><br/>
   </td>
  </tr>
  <tr>
  <td colspan="4">
    <?php
	if( $page_type_id == 90 )
		include("page_edit_subnav_90.php");
        else
	if( $page_type_id == 91 )
		include("page_edit_subnav_91.php");
	
	?>

  </td>
  </tr>
  <tr>
  <td colspan="4">
  <?php echo $msg; ?>  
  <?php if( $deleting ) { ?>
	<br/>
    <span class="accentColor">Confirm Delete Below</span>
	<br/><br/>
    <?php } ?>
  </td>
  </tr>
  
  <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL PAGE INFORMATION</td>
  </tr>
       
  	<tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Active</div></td>
		<td width="523"  colspan="3"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
  <tr>
	  	<td valign="top" class="Bold"><div align="right">Access Levels</div></td>
		<td colspan="3">
        <?php 
		do { 
			if( $row_rsAdminLvl['admin_lvl'] <= $_SESSION['AdminLevel'] )
			{
		?>
        <input name="admin_lvls[]" type="checkbox" value="<?php echo $row_rsAdminLvl['admin_lvl']; ?>" <?php if( in_array($row_rsAdminLvl['admin_lvl'], $admin_lvls) ) echo 'checked="checked"'; ?> /><?php echo $row_rsAdminLvl['description']; ?>
        <?php
			}
		} while($row_rsAdminLvl = mysql_fetch_assoc($rsAdminLvl)); ?>
        &nbsp;&nbsp;Last Updated: <?php echo $last_update; ?>
		</td>
      </tr>
      
    <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="3"><input name="title" type="text" id="title" size="50" maxlength="255" value="<?php echo $title; ?>"/></td>
      </tr>
       <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Side Navigation Title</div></td>
		<td colspan="3"><input name="sub_nav_title" type="text" id="sub_nav_title" size="50" maxlength="30" value="<?php echo $sub_nav_title; ?>"/></td>
      </tr>
       <?php if( $FLASH_HEADER ) { ?>      
       <tr>
        <td valign="top"><div align="right">Flash Header</div>
        <td colspan="2">
                <select name="header_id" id="header_id">
                  <option value="" ><default></option>
                  <?php
				  do { 
					?>
                  <option value="<?php echo $row_rsHeaders['header_id']; ?>"<?php if($header_id == $row_rsHeaders['header_id']) echo ' selected="selected" '; ?>><?php echo $row_rsHeaders['title']; ?></option>
                  <?php
				  }  while($row_rsHeaders = mysql_fetch_assoc($rsHeaders)); 
				  ?>
                </select>
        </td>
        </tr>
      	<?php } ?>
        
        <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;NAVIGATION</td></tr> 

       
         <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right"> </div></td>
		<td width="523"  colspan="2">
        <label> 
		  <input type="checkbox" name="main_menu" id="main_menu" <?php if($main_menu == 1) echo 'checked="checked"'; ?> />
		Main Menu</label>
        <label> 
		  <input type="checkbox" name="footer" id="footer" <?php if($footer == 1) echo 'checked="checked"'; ?> />
		Footer</label>
        <label>
		  <input type="checkbox" name="back_button" id="back_button" <?php if($back_button == 1) echo 'checked="checked"'; ?> />
		Back Button</label></td>
  	    
  	</tr> 
    
      <tr>
        <td valign="top"><div align="right"><?php if( $PARENT_PAGE ) echo 'Parent Page'; else echo 'Page Position'; ?></div>
        <td colspan="2">
        <?php if( $PARENT_PAGE ) { ?>
                <select name="parent_id" id="parent_id">
                  <option value="" >&nbsp; </option>
                  <?php
				  do { 
					?>
                  <option value="<?php echo $row_rsPages['page_id']; ?>"<?php if($parent_id == $row_rsPages['page_id']) echo ' selected="selected" '; ?>><?php echo $row_rsPages['title']; ?></option>
                  <?php
				  }  while($row_rsPages = mysql_fetch_assoc($rsPages)); 
				  ?>
                </select>
                &nbsp;&nbsp;Page Position
        <?php } ?>    
                <input name="left_nav_pos" type="text" id="left_nav_pos" size="5" maxlength="2" value="<?php echo $left_nav_pos; ?>"/>
        </td>
        </tr>
        
        <?php 
				  include("db_pages_get_children.php");
				  if( $varNumChildren > 0 )
				  {
		?>
             <tr>
        <td valign="top"><div align="right">Landing Page</div>
        <td colspan="2">    <select name="alt_landing_page" id="alt_landing_page">
                  <option value="" >&nbsp; </option>
                  <?php
				  do { 
					?>
                  <option value="<?php echo $row_rsChildPages['page_id']; ?>"<?php if($alt_landing_page == $row_rsChildPages['page_id']) echo ' selected="selected" '; ?>><?php echo $row_rsChildPages['title']; ?></option>
                  <?php
				  }  while($row_rsChildPages = mysql_fetch_assoc($rsChildPages)); 
				  ?>
                </select>
        </td>
        </tr>
                <?php 
				}
				?>
        
      
 
       
       
       
 <?php 
	   	if( $page_type_id == 5 ) 
       		include("page_edit_5.php");
		else 
 	   	if( $page_type_id == 14 ) 
       		include("page_edit_14.php");
		else 
 		if( $page_type_id == 99 ) 
			include("page_add_99.php");
 		else
		if( $page_type_id == 9 ) 
			include("page_add_9.php");
 		else
		if( $page_type_id == 2 )
			include("page_edit_2.php");
 		else
		if( $page_type_id == 12 )
			include("page_edit_12.php");
 		else
		if( $page_type_id == 91 )
			include("page_edit_91.php");
 		else
		if( $page_type_id == 999 )
			include("page_edit_999.php");
		?>
   
     <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;MAIN CONTENT</td></tr>
   
      <tr>
	  	<td valign="top" class="Bold"><div align="right"></div></td>
		<td colspan="3">
        
          <label>
          <?php 
		  if( $page_type_id == 1 || $page_type_id == 2 )
		  	$form_height = 600;
		  else
		  	$form_height = 400;
		$oFCKeditor = new FCKeditor('complete_text') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $complete_text;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = $form_height;
		$oFCKeditor->Create();
		
		//echo 'test';
		?>
          </label></td>
      </tr>
      
      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;SEO</td></tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">SEO Title</div></td>
		<td colspan="2"><textarea name="meta_title" cols="80" id="meta_title"><?php echo $meta_title; ?></textarea>
        </td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">SEO Description</div></td>
		<td colspan="2"><textarea name="meta_description" cols="80" id="meta_description"><?php echo $meta_description; ?></textarea>
        </td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">SEO Keywords<br/>(separate with commas)</div></td>
		<td colspan="2" valign="top"><textarea name="meta_keywords" cols="80" id="meta_keywords"><?php echo $meta_keywords; ?></textarea>
        </td>
      </tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right">Permalink</div></td>
		<td colspan="2" valign="top"><input name="permalink" type="text" id="permalink" value="<?php echo $permalink; ?>" size="80" maxlength="255"/>
       </td>
      </tr>
  <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ACTIONS</td></tr>
  	  <tr>
	  	<td valign="top">&nbsp;</td>
		<td colspan="3"> 
        <input name="Update" type="submit" id="Update" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
         <p>&nbsp;</p>        </td>
	    </tr>
	  </table>
      	  </form>
          </td>
          </tr>
          </table> <!-- InstanceEndEditable -->
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
