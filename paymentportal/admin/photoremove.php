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
require('checkaccess.php'); 
include("config.php");
include("db_utils.php");
include("image_defines.php"); 	// photo defines
	
$DEBUGGING = false;
if( $DEBUGGING )
	echo 'testing...';
	
$returnURL 	= $_SESSION['returnURL'];
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}

if( isset($_GET['id']) )
{	
	$title		= $_GET['title'];
	$type_id	= $_GET['type_id'];
	$id			= $_GET['id'];
}
else
{
	$type_id	= $_POST['type_id'];
	$id 		= $_POST['id'];
}

$imageDef = new imageDefines($type_id, $db_database, $db_connection);

$img_no = 0;
if( isset($_GET['img_no']) )
	$img_no = $_GET['img_no'];
else
if( isset($_POST['img_no']) )
	$img_no = $_POST['img_no'];
	
$msg = '';
if( isset($_POST["MM_delete"]) )
{
	if( $DEBUGGING )
		echo 'deleting...';
	
	switch($img_no)
	{
		case '1':
			$image_field = 'image_file';
			break;
		case '2':
			$image_field = 'image2_file';
			break;
		case '3':
			$image_field = 'image3_file';
			break;
		case '4':
			$image_field = 'image4_file';
			break;
		default:  
			$image_field = "image_file";
			break;

	}

	$base_folder = $imageDef->getImageFolder();
	
	$updateSQL = sprintf("UPDATE %s SET %s = NULL WHERE %s=%s",
	   $imageDef->getTableName(),
	   $image_field,
	   $imageDef->getTableID(),
	   GetSQLValueString($id, "text") 			);
	

	if( $DEBUGGING )
		echo 'del photos...';
	

	include("photodelete.php");
	deletePhotos($base_folder, $_POST['image_file']);
		
	if( $DEBUGGING )
		echo 'upd sql...';
	
	mysql_select_db($db_database, $db_connection);
	//echo '<br/>sql: ' . $updateSQL;
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	header(sprintf("Location: %s", $returnURL));
	exit();
}

$query_rsFind = sprintf("SELECT * FROM %s WHERE %s=%s", 
		$imageDef->getTableName(),
		$imageDef->getTableID(),
		$id);
		
$image_folder = $imageDef->getImageFolder();	

mysql_select_db($db_database, $db_connection);
$rs = mysql_query($query_rsFind, $db_connection) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

switch($img_no)
{
	case '1':
		$image_file =$row_rs[ 'image_file'];
		break;
	case '2':
		$image_file = $row_rs['image2_file'];
		break;
	case '3':
		$image_file = $row_rs['image3_file'];
		break;
	case '4':
		$image_file = $row_rs['image4_file'];
		break;
	default:
		$image_file =$row_rs[ 'image_file'];
		break;
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
 <form enctype="multipart/form-data" id="form1" name="form1" method="post" >
      <input type="hidden" name="MM_delete" value="<?php echo $type_id; ?>">
       <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="hidden" name="img_no" value="<?php echo $img_no; ?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-left:10px;">
  <tr>
  <td colspan="3" class="pagetitle"><br />
    Remove Image  </td>
  </tr>
  <tr>
  <td colspan="3">
  <?php echo $msg; ?>  </td>
      <tr>
	  	<td width="12%" valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="3"><?php echo $title; ?> <?php if( $img_no > '1' ) echo '(' . $img_no . ')'; ?></td>
      </tr>
      <tr>
	  	<td width="12%" valign="top" ><div align="right">Image</div></td>
		<td colspan="3"><?php echo $imageDef->getImageFolder() . $image_file; ?> <img src="../<?php echo $imageDef->getImageFolder() . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
          </td>
      </tr>
	  <tr>
	  	<td valign="top">&nbsp;</td>
		<td colspan="3"> <input name="Delete" type="submit" id="Delete" value="Confirm Delete"); />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
         <p>&nbsp;</p>
        </td>
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
