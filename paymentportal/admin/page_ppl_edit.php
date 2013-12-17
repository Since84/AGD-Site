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
$staffphoto_imagefolder = "cms/staffphotos/";

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$page_title 	= $_POST['page_title'];
	$page_type_id 	= $_POST['page_type_id'];
	$people_id		= $_POST['people_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$page_title 	= $_GET['page_title'];
	$page_type_id 	= $_GET['page_type_id'];
	$people_id		= $_GET['people_id'];
}

// create new image defining obj
$imageDef 	 = new imageDefines($page_type_id, $db_database, $db_connection);

			
//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_ppl.php?page_id=" . $page_id . '&page_type_id=' . $page_type_id . '&page_title=' . $page_title;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&page_type_id=%s&page_title=%s&people_id=%s", "page_ppl_edit.php", $page_id, $page_type_id, $page_title, $people_id);

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
	$people_id 		= $_POST['people_id'];
	
	$sort_by		= $_POST['sort_by'];	
	$first_name 	= $_POST['first_name'];	
	$middle_name 	= $_POST['middle_name'];	
	$last_name 		= $_POST['last_name'];	
	$title		 	= $_POST['title'];	
	$phone		 	= $_POST['phone'];	
	$email		 	= $_POST['email'];	
	$image_file 	= $_POST['image_file'];	
	$short_desc 	= $_POST['short_desc'];	
	$description 	= $_POST['description'];
	$desc_2		 	= $_POST['desc_2'];	
	$desc_3		 	= $_POST['desc_3'];	
	$desc_4		 	= $_POST['desc_4'];	
	$desc_5		 	= $_POST['desc_5'];	
	$desc_6		 	= $_POST['desc_6'];	
	$desc_7		 	= $_POST['desc_7'];	
	$table_1	 	= $_POST['table_1'];	
	$table_2	 	= $_POST['table_2'];	
	$other_1	 	= $_POST['other_1'];	
	$active		 	= $_POST['active'];	
	

	if( isset($_POST['ImageAdd'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $people_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $people_id . '&type_id=' . $page_type_id . '&title=' . $title;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageRemove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $people_id . '&type_id=' . $page_type_id . '&title=' . $title;
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
			$updateSQL = sprintf("DELETE FROM people WHERE people_id = %s LIMIT 1", $people_id );
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
		if( empty($_POST['first_name'])  )
		{
			$msg = $msg . '<font color="red">Please enter a first name.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['last_name'])  )
		{
			$msg = $msg . '<font color="red">Please enter a last name.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['description'])  )
		{
			$msg = $msg . '<font color="red">Please enter information for "When And why did you become a SCORE Counselor?".</font><br/>';
			$edits_ok = false;
		}
		if( 0 ) //empty($_POST['desc_2'])  )
		{
			$msg = $msg . '<font color="red">Please enter business background. ".</font><br/>';
			$edits_ok = false;
		}
		if( 0 ) //empty($_POST['desc_3'])  )
		{
			$msg = $msg . '<font color="red">Please select alma mater. ".</font><br/>';
			$edits_ok = false;
		}
	
		// check the lengths on table fields
		$ck = explode(";", $table_1);
		foreach($ck as $entry)
		{
			if( strlen($entry) > 20 )
			{
				$msg = $msg . '<font color="red">Lengths for Industry Areas must be less than 20 characters. ".</font><br/>';
				$edits_ok = false;
			}
		}
		$ck = explode(";", $table_2);
		foreach($ck as $entry)
		{
			if( strlen($entry) > 20 )
			{
				$msg = $msg . '<font color="red">Lengths for Areas of Expertise must be less than 20 characters. ".</font><br/>';
				$edits_ok = false;
			}
		}
		
		if($edits_ok)
		{
			require('db_ppl_update.php'); 
			$result = updatePerson($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['people_id']) )
		$people_id = $_POST['people_id'];
	else
		$people_id = $_GET['people_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsProducts = sprintf("SELECT * FROM people WHERE people_id = %s", $people_id);
	if( $DEBUGGING )
		echo $query_rsProducts;
	$rsProducts = mysql_query($query_rsProducts, $db_connection) or die(mysql_error());
	$row_rsProducts = mysql_fetch_assoc($rsProducts);

	$sort_by		= $row_rsProducts['sort_by'];	
	$first_name 	= $row_rsProducts['first_name'];	
	$middle_name 	= $row_rsProducts['middle_name'];	
	$last_name 		= $row_rsProducts['last_name'];	
	$title 			= $row_rsProducts['title'];	
	$phone 			= $row_rsProducts['phone'];	
	$email	 		= $row_rsProducts['email'];	
	$image_file		= $row_rsProducts['image_file'];	
	$short_desc 	= stripslashes($row_rsProducts['short_desc']);	
	$description 	= stripslashes($row_rsProducts['description']);	
	$desc_2		 	= stripslashes($row_rsProducts['desc_2']);	
	$desc_3		 	= stripslashes($row_rsProducts['desc_3']);	
	$desc_4		 	= stripslashes($row_rsProducts['desc_4']);	
	$desc_5		 	= stripslashes($row_rsProducts['desc_5']);	
	$desc_6		 	= stripslashes($row_rsProducts['desc_6']);	
	$desc_7		 	= stripslashes($row_rsProducts['desc_7']);	
	$table_1	 	= $row_rsProducts['table_1'];	
	$table_2	 	= $row_rsProducts['table_2'];	
	$other_1	 	= $row_rsProducts['other_1'];		
	$active		 	= $row_rsProducts['active'];		
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
      <input type="hidden" name="people_id" value="<?php echo $people_id; ?>">
      <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="800" cellpadding="1">
	 <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;GENERAL</td></tr>
     <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td ><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == "on") echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
	  <tr>
	  	<td width="169" valign="top" ><div align="right">Display _order</div></td>
		<td width="619">
 <input name="sort_by" type="text" id="sort_by" size="20" maxlength="20" value="<?php echo $sort_by; ?>"/> 
        </td>
	  </tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right">First Name</div></td>
		<td><input name="first_name" type="text" id="first_name" size="30" maxlength="50" value="<?php echo $first_name; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Last Name</div></td>
		<td><input name="last_name" type="text" id="last_name" size="30" maxlength="50" value="<?php echo $last_name; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Title</div></td>
		<td><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $title; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Phone</div></td>
		<td><input name="phone" type="text" id="phone" size="30" maxlength="50" value="<?php echo $phone; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Email</div></td>
		<td><input name="email" type="text" id="email" size="30" maxlength="50" value="<?php echo $email; ?>"/></td>
	  </tr>
      <?php include("page_edit_image_inc.php"); ?>
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
     <?php include("page_ppl_extra.php"); ?>
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
