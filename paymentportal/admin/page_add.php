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

include("db_page_types_get.php");

// echo $_SERVER['PHP_SELF'];

$DEBUGGING = false;

if( $DEBUGGING )
	echo'debug on';

$page_type_id = $_POST['page_type_id'];
if( $DEBUGGING )
	echo '<br/>page type: ' . $page_type_id;

	
$returnURL = "pages.php";
$msg = '';

if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}

$active = 1;
$admin_lvls = array('3','9'); // default
$parent_id = NULL;
$left_nav_pos = NULL;
$image_size = 2;  // medium
$image_pos  = 2;  // right
	
if( isset($_POST["ADDPAGES"]) )
{
	$active	 			= $_POST['active'];
	$title 				= $_POST['title'];
	$sub_title 			= $_POST['sub_title'];
	$admin_lvls			= $_POST['admin_lvls'];
	$snippet 			= $_POST['snippet'];
	$other	 			= $_POST['other'];
	$other2	 			= $_POST['other2'];
	$other3	 			= $_POST['other3'];
	$other4	 			= $_POST['other4'];
	$other5	 			= $_POST['other5'];
	$other6	 			= $_POST['other6'];
	$other7	 			= $_POST['other7'];
	$other8	 			= $_POST['other8'];
	$other9	 			= $_POST['other9'];
	$complete_text 		= stripslashes($_POST['complete_text']);
	$parent_id	 		= $_POST['parent_id'];
	$left_nav_pos 		= $_POST['left_nav_pos'];
	$image_size 		= $_POST['image_size'];
	$image_pos	 		= $_POST['image_pos'];
	$alt_landing_page = $_POST['alt_landing_page'];
	
	$active 		= $_POST['active'];	// 1 = active, 2 = inactive
	$back_button	= $_POST['back_button'];
	$meta_description 	= $_POST['meta_description'];
	$meta_keywords 		= $_POST['meta_keywords'];
	$meta_title			= $_POST['meta_title'];
	
	$main_menu		= $_POST['main_menu'];
	$footer			= $_POST['footer'];
	$header_id		= $_POST['header_id'];
	$parent_id		= $_POST['parent_id'];

	if( $DEBUGGING )
		echo'admin lvls: ' . $_POST['admin_lvls'];;
	
	
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
	if( empty($_POST['admin_lvls'])  )
	{
		$msg = $msg . '<font color="red">Please set access levels.</font><br/>';
		$edits_ok = false;
	}
	if( 0 ) // was checking page types, opened up
	{
		if( empty($_POST['complete_text'])  )
		{
			$msg = $msg . '<font color="red">Please enter the page text.</font><br/>';
			$edits_ok = false;
		}
	}
	if( $page_type_id == '70' && $parent_id > 0 )
	{
			$msg = $msg . '<font color="red">Cannot assign a parent page to a main menu page.</font><br/>';
			$edits_ok = false;
	}
	
	if( $DEBUGGING )
		echo'checking length';
	
	
	// check length on snippet not exceeded
	include('textCounter.php'); 
	$maxlimit = 255;
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
		if( $DEBUGGING )
			echo'edits ok';
	
		if( $pdf_file )
		{
			$max_pdf_size = 3000000;
			$pdf_folder   = $PAGES_PDF_FOLDER;
			$pdf_prefix   = $PAGE_IMG_PREFIX;
			require('db_pdf_upload.php');
		}
		else
		{
			$upload_ok = true;
		}
		
		$isManualCrop = false;
		if( $upload_ok && $image_file )
		{
			// create new image defining obj
			$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);
			require('image_upload.php');	
			$isManualCrop = $imageDef->isManualCrop();
		}
	
		if( $upload_ok )
		{
			if( $DEBUGGING )
				echo'get add';
				
			// now update database
			require('db_page_add.php'); 
			if( $DEBUGGING )
				echo'go add';
			$page_id = addPage($db_filename_pdf, $image_filename, $db_database, $db_connection);	
	
			$edit_page = getEditPage($page_type_id, $db_database, $db_connection);

			if( $edit_page != 'page_edit.php' )			
				$returnURL = sprintf("%s?page_id=%s&page_type_id=%s&page_title=%s", $edit_page, $page_type_id, $page_id, $title);
			else
				$returnURL = 'pages.php';

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
     <form enctype="multipart/form-data" id="form1" name="form1" method="post" action="">
     <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>" />
       
      <table width="700" border="0" cellspacing="0" cellpadding="2" style="margin-left:10px;">
  <tr>
  <td colspan="2" class="pagetitle"><br />
    ADD A "<?php echo getPageTypeTitle($page_type_id, $db_database, $db_connection); ?>" PAGE 
    <br/><br/>
    </td>
  </tr>
  <tr>
  <td colspan="3">
  <?php echo $msg; ?>  </td>
  </tr>

  <tr>
    <td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL PAGE INFORMATION</td>
  </tr>

  <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Active</div></td>
		<td width="523"  colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  </tr> 
     
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Access Levels</div></td>
		<td colspan="2">
        <?php do { 
			if( $row_rsAdminLvl['admin_lvl'] <= $_SESSION['AdminLevel'] )
			{
		?>
        <input name="admin_lvls[]" type="checkbox" value="<?php echo $row_rsAdminLvl['admin_lvl']; ?>" <?php if( in_array($row_rsAdminLvl['admin_lvl'], $admin_lvls) ) echo 'checked="checked"'; ?> /><?php echo $row_rsAdminLvl['description']; ?>
        <?php
			}
		 } while($row_rsAdminLvl = mysql_fetch_assoc($rsAdminLvl)); ?>
        
		</td>
        </tr>
        
      
             
        <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="2"><input name="title" type="text" id="title" size="50" maxlength="37" value="<?php echo $_POST['title']; ?>"/></td>
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
         <? } ?>
         <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;NAVIGATION</td></tr>
         
         <tr>
	  	<td width="151" valign="top" ><div align="right"></div></td>
		<td width="523"  colspan="3">
        <label> 
		  <input type="checkbox" name="main_menu" id="main_menu" <?php if($main_menu == 1) echo 'checked="checked"'; ?> />
		Main Menu</label>
        <label> 
		  <input type="checkbox" name="footer" id="footer" <?php if($footer == 1) echo 'checked="checked"'; ?> />
		Footer</label>
        <label>
		  <input type="checkbox" name="back_button" id="back_button" <?php if($back_button == 1) echo 'checked="checked"'; ?> />
		Back Button</label>
        </td>
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
                <input name="left_nav_pos" type="text" id="left_nav_pos" size="5" maxlength="2" value="<?php echo $_POST['left_nav_pos']; ?>"/>
        </td>
        </tr>
        
      
       	<?php 
	   	if( $page_type_id == 5 ) 
       		include("page_add_5.php");
 
	   	if( $page_type_id == 14 ) 
       		include("page_add_14.php");
 
 		if( $page_type_id == 99 ) 
			include("page_add_99.php");
 		
		if( $page_type_id == 9 ) 
			include("page_add_9.php");
			
		if( $page_type_id == 2 )
			include("page_add_2.php");

		if( $page_type_id == 91 )
			include("page_add_91.php");

		if( $page_type_id == 92 )
			include("page_add_12.php");

		if( $page_type_id == 999 )
			include("page_add_999.php");
		?>
      
     <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;MAIN CONTENT</td></tr>

      <tr>
	  	<td valign="top" class="Bold"><div align="right"> </div></td>
		<td>
        
          <label>
          
          <?php 
		  
		$oFCKeditor = new FCKeditor('complete_text') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $complete_text;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 600;
		$oFCKeditor->Create() ;
		
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
     <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ACTIONS</td></tr>
    <tr>
	  	<td valign="top">&nbsp;</td>
		<td colspan="2"><input name="ADDPAGES" type="submit" id="ADDPAGES" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
         <p>&nbsp;</p>        </td>
	    </tr>
	  </table>
   	    </form>
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
