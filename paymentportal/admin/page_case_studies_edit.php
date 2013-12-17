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
	$page_type_id 	= $_POST['page_type_id'];
	$case_study_id		= $_POST['case_study_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$page_type_id 	= $_GET['page_type_id'];
	$case_study_id		= $_GET['case_study_id'];
}

if( $DEBUGGING )
{
	echo '<br/>page_id: ' . $page_id;
	echo '<br/>page_type_id: ' . $page_type_id;
	echo '<br/>page_title: ' . $page_title;
}

// create new image defining obj
$imageDef 	 = new imageDefines($page_type_id, $db_database, $db_connection);


include("db_pages_get_byID.php");
$page_title = $row_rsPages['title'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_case_studies.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_type_id=%s&case_study_id=%s", "page_case_studies_edit.php", $page_id, $page_type_id, $case_study_id);


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
	$case_study_id 		= $_POST['case_study_id'];
	
	$post_date		= $_POST['post_date'];
	$title			= $_POST['title'];
	$objective		= $_POST['objective'];
	$client			= $_POST['client'];
	$challenge		= $_POST['challenge'];
	$solution		= $_POST['solution'];
	$complete_text	= $_POST['complete_text'];
	$other		 	= $_POST['other'];
	$other2		 	= $_POST['other2'];
	$other3		 	= $_POST['other3'];
	$active		 	= $_POST['active'];

	$image_file	 	= $_POST['image_file'];
	$image2_file	= $_POST['image2_file'];
	$image3_file	= $_POST['image3_file'];
	$image4_file	= $_POST['image4_file'];

	if( isset($_POST['addPDF']) )
	{
		$gotoURL = sprintf("fileadd.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $case_study_id);
		
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['changePDF']) )
	{
		$gotoURL = sprintf("filereplace.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $case_study_id);
		
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['removePDF']) )
	{
		$gotoURL = sprintf("fileremove.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $case_study_id);
		
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}

	////////////////////////////////////////////
	// image 1	
	if( isset($_POST['ImageAdd'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	
	if( isset($_POST['ImageRemove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageCrop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=0&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	////////////////////////////////////////////
	// image 2	
	if( isset($_POST['Image2Add'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=2';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image2Replace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=2';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	
	if( isset($_POST['Image2Remove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=2';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image2Crop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image2_file.'&a=0&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	////////////////////////////////////////////
	// image 3
	if( isset($_POST['Image3Add'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=3';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image3Replace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=3';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	
	if( isset($_POST['Image3Remove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=3';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image3Crop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image3_file.'&a=0&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	////////////////////////////////////////////
	// image 4
	if( isset($_POST['Image4Add'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=4';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image4Replace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=4';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	
	if( isset($_POST['Image4Remove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $case_study_id . '&type_id=' . $page_type_id . '&title=' . $title . '&img_no=4';
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['Image4Crop'])  )
	{
		$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image4_file.'&a=0&i=1';
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	
	
	if( $_POST['delete'] == true  )
	{
			// delete item
			$updateSQL = sprintf("DELETE FROM case_studies WHERE case_study_id = %s LIMIT 1", $case_study_id );
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
		
	    /*
		// check length on snippet not exceeded
		include('textCounter.php'); 
		$maxlimit = 150;
		$ret_array = textCount($snippet, $maxlimit);
		if( $ret_array[0] )
		{	
			$msg = $msg . '<font color="red">Objective length of ' . $maxlimit . ' exceeded.</font><br/>';
			$snippet = $ret_array[1];
			$edits_ok = false;
		}
		*/
		
		if($edits_ok)
		{
			require('db_case_studies_update.php'); 
			$result = updateCaseStudy($snippet, $db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['case_study_id']) )
		$case_study_id = $_POST['case_study_id'];
	else
		$case_study_id = $_GET['case_study_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsCaseStudies = sprintf("SELECT * FROM case_studies WHERE case_study_id = %s", $case_study_id);
	if( $DEBUGGING )
		echo $query_rsCaseStudies;
	$rsCaseStudies = mysql_query($query_rsCaseStudies, $db_connection) or die(mysql_error());
	$row_rsCaseStudies = mysql_fetch_assoc($rsCaseStudies);

	$post_date		= $row_rsCaseStudies['post_date'];
	$title			= $row_rsCaseStudies['title'];
	$objective		= stripslashes($row_rsCaseStudies['objective']);
	$client			= stripslashes($row_rsCaseStudies['client']);
	$challenge		= stripslashes($row_rsCaseStudies['challenge']);
	$solution		= stripslashes($row_rsCaseStudies['solution']);
	$complete_text	= stripslashes($row_rsCaseStudies['complete_text']);
	$other		 	= stripslashes($row_rsCaseStudies['other']);
	$other2		 	= stripslashes($row_rsCaseStudies['other2']);
	$other3		 	= stripslashes($row_rsCaseStudies['other3']);
	$active		 	= $row_rsCaseStudies['active'];

	$image_file 	= $row_rsCaseStudies['image_file'];
	$image2_file 	= $row_rsCaseStudies['image2_file'];
	$image3_file 	= $row_rsCaseStudies['image3_file'];
	$image4_file 	= $row_rsCaseStudies['image4_file'];
	$pdf_file	 	= $row_rsCaseStudies['pdf_file'];
}

//echo $other . ', ' . $other2 . ', ' . $other3;
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
      <input type="hidden" name="page_title" value="<?php echo $page_title; ?>">
      <input type="hidden" name="case_study_id" value="<?php echo $case_study_id; ?>">
      <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <input type="hidden" name="image2_file" value="<?php echo $image2_file; ?>">
      <input type="hidden" name="image3_file" value="<?php echo $image3_file; ?>">
      <input type="hidden" name="image4_file" value="<?php echo $image4_file; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="600" cellpadding="0" cellspacing="0">
       <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL</td></tr>
	  <tr>
	  	<td  valign="top" class="Bold"><div align="right">Active</div></td>
		<td colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
	  
	  <tr>
	  	<td  valign="top" class="Bold"><div align="right">Date</div></td>
		<td  colspan="2"><input name="post_date" type="text" id="post_date" size="10" maxlength="50" value="<?php echo substr($post_date,0,10); ?>"/><img onclick="showCal('post_date')" src="../calendar/icon.gif" width="16" height="16" />&nbsp;&nbsp;(yyyy-mm-dd)</td>
      </tr> 
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="2"><input name="title" type="text" id="title" size="50" maxlength="255" value="<?php echo $title; ?>"/></td>
      </tr>
       <?php include("page_add_quote_inc.php"); ?>
	  <?php if ( 0 ) { ?>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Objective</div></td>
		<td colspan="2"><?php 
		$oFCKeditor = new FCKeditor('objective') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Value		= $objective;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Create() ;
		?></td>
      </tr>
	  <?php } ?>

      <?php include("page_edit_PDF_inc.php"); ?>
  		<tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;OTHER</td></tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Challenge</div></td>
		<td colspan="3"><?php 
		$oFCKeditor = new FCKeditor('challenge') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Value		= $challenge;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Create() ;
		?></td>
      </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Solution</div></td>
		<td colspan="3"><?php 
		$oFCKeditor = new FCKeditor('solution') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Value		= $solution;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Create() ;
		?></td>
      </tr>
      
	 <?php //include("page_edit_image_inc.php"); ?>

      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE</td></tr>
 
 	<!-- image 1 --> 
	<tr>
    <td valign="top">Image (top left)
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
	 <tr><td colspan="3" height="20" ><hr size="1" color="#cccccc" /></td></tr>
 	<!-- image 2 --> 
	<tr>
    <td valign="top">Image (top right)
     <?php if( strlen($image2_file) > 0 ) { ?>
       <br/><br/>
      	<input type="submit" name="Image2Replace" id="Image2Replace" value="Replace" style="margin-bottom:2px;" /><br/>
       	<input type="submit" name="Image2Remove" id="Image2Remove" value="Remove"  style="margin-bottom:2px;" /><br/>          
       	<input type="submit" name="Image2Crop" id="Image2Crop" value="Re-Crop Image"  style="margin-bottom:2px;" />
	<?php } else { ?>
          <input type="submit" name="Image2Add" id="Image2Add" value="Add"/>
    	 <?php } ?>

    </td>
    <td valign="top">
    <?php if( strlen($image2_file) > 0 ) { ?>
	            <img src="../<?php echo $imageDef->getImageFolder() . $image2_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <?php }?>
    </td>
    <td valign="top">
    </td>
    </tr>

	 <tr><td colspan="3" height="20" ><hr size="1" color="#cccccc" /></td></tr>
 	<!-- image 3 --> 
	<tr>
    <td valign="top">Image (bottom right)
     <?php if( strlen($image3_file) > 0 ) { ?>
       <br/><br/>
      	<input type="submit" name="Image3Replace" id="Image3Replace" value="Replace" style="margin-bottom:2px;" /><br/>
       	<input type="submit" name="Image3Remove" id="Image3Remove" value="Remove"  style="margin-bottom:2px;" /><br/>          
       	<input type="submit" name="Image3Crop" id="Image3Crop" value="Re-Crop Image"  style="margin-bottom:2px;" />
	<?php } else { ?>
          <input type="submit" name="Image3Add" id="Image3Add" value="Add"/>
    	 <?php } ?>

    </td>
    <td valign="top">
    <?php if( strlen($image3_file) > 0 ) { ?>
	            <img src="../<?php echo $imageDef->getImageFolder() . $image3_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <?php }?>
    </td>
    <td valign="top">
    </td>
    </tr>

     <tr><td colspan="3" height="20" ></td></tr>
        
	<tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;MAIN CONTENT</td></tr>
    <tr>
	  	<td valign="top" class="Bold"><div align="right"></div></td>
		<td colspan="2">
        
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
		<td colspan="2">
        <input name="Update2" type="submit" id="Update2" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
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
