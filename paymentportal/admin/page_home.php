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

$page_nav_id = 2;

$special_id = 10;

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$title 			= 'Home';
	$image_file 	= $_POST['image_file'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$title 			= 'Home';
	$image_file 	= $_GET['image_file'];
}
$page_type_id 	= 90;

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_title=%s", "page_home.php", $page_id, $page_title);

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

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_title=%s&id=%s", "page_home.php", $page_id, $title, $special_id);

if( isset($_POST['changeVideo']) )
{
	$gotoURL = sprintf("flashreplace.php?type_id=%s&page_title=%s&id=%s", $page_type_id, $title, $special_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}

if( isset($_POST["MM_update"]) )
{
	$title 				= $_POST['title'];	
	
	$step1_title 		= $_POST['step1_title'];	
	$step1_sub1_title 	= $_POST['step1_sub1_title'];	
	$step1_sub1		 	= $_POST['step1_sub1'];	
	$step1_sub2_title 	= $_POST['step1_sub2_title'];	
	$step1_sub2		 	= $_POST['step1_sub2'];	
	$step1_sub3_title 	= $_POST['step1_sub3_title'];	
	$step1_sub3		 	= $_POST['step1_sub3'];	
	$step1_consider	 	= $_POST['step1_consider'];	
	
	$step2_title 		= $_POST['step2_title'];	
	$step2_sub1_title 	= $_POST['step2_sub1_title'];	
	$step2_sub1		 	= $_POST['step2_sub1'];	
	$step2_sub2_title 	= $_POST['step2_sub2_title'];	
	$step2_sub2		 	= $_POST['step2_sub2'];	
	$step2_sub3_title 	= $_POST['step2_sub3_title'];	
	$step2_sub3		 	= $_POST['step2_sub3'];	
	$step2_consider	 	= $_POST['step2_consider'];	
	
	$step3_title 		= $_POST['step3_title'];	
	$step3_sub1_title 	= $_POST['step3_sub1_title'];	
	$step3_sub1		 	= $_POST['step3_sub1'];	
	$step3_sub2_title 	= $_POST['step3_sub2_title'];	
	$step3_sub2		 	= $_POST['step3_sub2'];	
	$step3_sub3_title 	= $_POST['step3_sub3_title'];	
	$step3_sub3		 	= $_POST['step3_sub3'];	
	$step3_consider	 	= $_POST['step3_consider'];	

	$quick_links		= $_POST['quick_links'];	

	$other1	 			= $_POST['other1'];	
	$other2	 			= $_POST['other2'];	
	$other3	 			= $_POST['other3'];	

	$meta_description 	= $_POST['meta_description'];
	$meta_keywords 		= $_POST['meta_keywords'];
	$meta_title			= $_POST['meta_title'];

	if( isset($_POST['deleteVideo']) )
	{
		if( $DEBUGGING )
			echo 'deleting videos';
			
		include("filedelete.php");
		
		$full_file_name = $PAGES_VIDEO_FOLDER . $_POST['pdf_file'];
		deleteFile($full_file_name);
		$full_file_name = $PAGES_VIDEO_FOLDER . $_POST['pdf_file2'];
		deleteFile($full_file_name);
		
		$_POST['step1_title'] = '';
		$_POST['step2_title'] = '';

	}
	
	// edits
	$edits_ok = true;
	
	if( 0 ) // empty($_POST['step1_consider'])  )
	{
		$msg = $msg . '<font color="red">Please enter the main text.</font><br/>';
		$edits_ok = false;
	}
	
	// video upload?
	$upload_ok = true;
	$update_videos = false;
	if( $edits_ok )
	{
		if( isset($_FILES['pdf_file']['name']) ) 
		{
			if( isset($_FILES['pdf_file2']['name']) ) 
			{
				if( $DEBUGGING )
					echo 'start upload';
				// first upload files
				$max_pdf_size = 100000000;
				$pdf_folder   = $PAGES_VIDEO_FOLDER;
				$pdf_prefix   = $PAGES_VIDEO_PREFIX;
				require('db_flash_upload.php');
				
				if( $upload_ok )
					$update_videos = true;
			}
		}
	}
	
	// if passed edits, update	
	if($edits_ok)
	{
		require('db_specials_update.php'); 
		$result = updateSpecial($db_database, $db_connection);	

		// update page/SEO
		$updateSQL = sprintf("UPDATE pages SET last_update=%s, meta_description=%s, meta_keywords=%s, meta_title=%s WHERE page_id=10",
			   "NOW()",
			   GetSQLValueString($_POST['meta_description'], "text"), 
			   GetSQLValueString($_POST['meta_keywords'], "text"), 
			   GetSQLValueString($_POST['meta_title'], "text")
			   	);		  
		mysql_select_db($db_database, $db_connection);
		$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
		
		// must update this here if videos added
		if( $update_videos )
		{
			if( $DEBUGGING )
				echo 'upload ok: ' . $_POST['special_id'];
			$updateSQL = sprintf("UPDATE specials SET step1_title='%s', step2_title='%s' WHERE special_id=%s  LIMIT 1",
				$db_filename_pdf, 
				$db_filename2_pdf, 
				$_POST['special_id']
				);
			if( $DEBUGGING )
				echo $updateSQL;
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
		}
		
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
}
else
{
	mysql_select_db($db_database, $db_connection);
	$query_rsSpecials = sprintf("SELECT * FROM specials WHERE special_id = %s", $special_id);
	if( $DEBUGGING )
		echo $query_rsSpecials;
	$rsSpecials = mysql_query($query_rsSpecials, $db_connection) or die(mysql_error());
	$row_rsSpecials = mysql_fetch_assoc($rsSpecials);

	$title 				= $row_rsSpecials['title'];	
	
	$step1_title 		= $row_rsSpecials['step1_title'];	
	$step1_sub1_title 	= $row_rsSpecials['step1_sub1_title'];	
	$step1_sub1		 	= $row_rsSpecials['step1_sub1'];	
	$step1_sub2_title 	= $row_rsSpecials['step1_sub2_title'];	
	$step1_sub2		 	= $row_rsSpecials['step1_sub2'];	
	$step1_sub3_title 	= $row_rsSpecials['step1_sub3_title'];	
	$step1_sub3		 	= $row_rsSpecials['step1_sub3'];	
	$step1_consider	 	= $row_rsSpecials['step1_consider'];	
	
	$step2_title 		= $row_rsSpecials['step2_title'];	
	$step2_sub1_title 	= $row_rsSpecials['step2_sub1_title'];	
	$step2_sub1		 	= $row_rsSpecials['step2_sub1'];	
	$step2_sub2_title 	= $row_rsSpecials['step2_sub2_title'];	
	$step2_sub2		 	= $row_rsSpecials['step2_sub2'];	
	$step2_sub3_title 	= $row_rsSpecials['step2_sub3_title'];	
	$step2_sub3		 	= $row_rsSpecials['step2_sub3'];	
	$step2_consider	 	= $row_rsSpecials['step2_consider'];	
	
	$step3_title 		= $row_rsSpecials['step3_title'];	
	$step3_sub1_title 	= $row_rsSpecials['step3_sub1_title'];	
	$step3_sub1		 	= $row_rsSpecials['step3_sub1'];	
	$step3_sub2_title 	= $row_rsSpecials['step3_sub2_title'];	
	$step3_sub2		 	= $row_rsSpecials['step3_sub2'];	
	$step3_sub3_title 	= $row_rsSpecials['step3_sub3_title'];	
	$step3_sub3		 	= $row_rsSpecials['step3_sub3'];	
	$step3_consider	 	= $row_rsSpecials['step3_consider'];	

	$quick_links		= stripslashes($row_rsSpecials['quick_links']);	
	
	$other1	 			= stripslashes($row_rsSpecials['other1']);	
	$other2	 			= $row_rsSpecials['other2'];	
	$other3	 			= $row_rsSpecials['other3'];	

	$image_file		= $row_rsSpecials['image_file'];	
	$image2_file	= $row_rsSpecials['image2_file'];	
	$image3_file	= $row_rsSpecials['image3_file'];
	
	// get page SEO
	$query_rsHome = sprintf("SELECT * FROM pages WHERE page_id = 10");
	$rsHome = mysql_query($query_rsHome, $db_connection) or die(mysql_error());
	$row_rsHome = mysql_fetch_assoc($rsHome);
	$meta_description 	= $row_rsHome['meta_description'];
	$meta_keywords 		= $row_rsHome['meta_keywords'];
	$meta_title			= $row_rsHome['meta_title'];	

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
     <table cellpadding="0" cellspacing="0">
    <tr>
    <td valign="middle">
    
    <?php //include("page_edit_subnav_90.php"); ?>
    
         </td></tr></table>  
    <br/>
  	
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="MM_update" value="MM_update">
      <input type="hidden" name="delete" value="<?php echo $deleting; ?>">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
      <input type="hidden" name="page_title" value="<?php echo $page_title; ?>">
      <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>">
      <input type="hidden" name="special_id" value="<?php echo $special_id; ?>">
       <input type="hidden" name="step1_title" value="<?php echo $step1_title; ?>">
       <input type="hidden" name="step2_title" value="<?php echo $step2_title; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="900" cellpadding="1">
     	<tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE . . .</td></tr>
  
	<tr>
    <td valign="top">Main Image
     <?php if( strlen($image_file) > 0 ) { ?>
       <br/><br/>
      	<input type="submit" name="ImageReplace" id="ImageReplace" value="Replace" style="margin-bottom:2px;" /><br/>
        <input type="submit" name="ImageRemove" id="ImageRemove" value="Remove"  style="margin-bottom:2px;" /><br/>          
        <input type="submit" name="ImageCrop" id="ImageCrop" value="Re-Crop Image"  style="margin-bottom:2px;" />
	<?php } else { ?>
          <input type="submit" name="ImageAdd" id="ImageAdd" value="Add"/>
    	 <?php } ?>

    </td>
    <td valign="top">
    <?php if( strlen($image_file) > 0 ) { ?>
	            <img src="../<?php echo $imageDef->getImageFolder() . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <?php }?>
    </td>
    <td valign="top">
   
    </td>
    </tr>
  
		<tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;OR VIDEO</td></tr>
            <tr><td colspan="2" height="20"></td></tr>
            <tr>
                <td valign="top" class="Bold"><div align="right"><strong>YouTube Code</strong></div></td>
                <td><input type="text" name="step1_title" size="70" value="<?php echo $step1_title; ?>"/></td>
            </tr>
       
 	<tr><td bgcolor="#efefef" ><div align="right"></div></td><td colspan="3" bgcolor="#efefef"></td></tr>
     <tr>
	  	<td width="151" valign="top" class="Bold"><div align="right">Title</div></td>
		<td><input name="step3_title" type="text" id="step3_title" size="100" maxlength="255" value="<?php echo $step3_title; ?>"/></td>
      </tr>
      
       <tr>
	  	<td valign="top" class="Bold"><div align="right"></div></td>
		<td colspan="3">
        
          <label>
          <?php 
		$oFCKeditor = new FCKeditor('other1') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $other1;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 300;
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
      
 	<tr><td bgcolor="#efefef" ><div align="right"></div></td><td colspan="3" bgcolor="#efefef"></td></tr>
    <tr>
	  	<td width="145" valign="top">&nbsp;</td>
		<td>
        <input name="Update2" type="submit" id="Update2" value="Update" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />        </td>
	</tr>
    <tr>
	  	<td width="145" valign="top">&nbsp;</td>
		<td>
        <br/><br/>        </td>
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
