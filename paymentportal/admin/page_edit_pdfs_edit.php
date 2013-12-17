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
require('image_defines.php');

$MM_AuthorizedLevels = "3,9";
require('checkaccess.php'); 
 
include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$pdf_id			= $_POST['pdf_id'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$pdf_id			= $_GET['pdf_id'];
}
$page_type_id 	= 91;

include("db_pages_get_byID.php");
$page_title = $row_rsPages['title'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_edit_pdfs.php?page_id=" . $page_id;

$_SESSION['returnURL'] = sprintf("%s?page_id=%s&pdf_id=%s", "page_edit_pdfs_edit.php", $page_id, $pdf_id);

if( isset($_POST['addPDF']) )
{
	$gotoURL = sprintf("fileadd.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $pdf_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['changePDF']) )
{
	$gotoURL = sprintf("filereplace.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $pdf_id);
	
	header(sprintf("Location: %s", $gotoURL));
	exit();
}
if( isset($_POST['removePDF']) )
{
	$gotoURL = sprintf("fileremove.php?type_id=%s&title=%s&id=%s", $page_type_id, $title, $pdf_id);
	
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
	$pdf_id 		= $_POST['pdf_id'];
	
	$title			= $_POST['title'];
	$display_order		= $_POST['display_order'];
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
			$updateSQL = sprintf("DELETE FROM pdfs WHERE pdf_id = %s LIMIT 1", $pdf_id );
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
			require('db_pdfs_update.php'); 
			$result = updatePDF($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['pdf_id']) )
		$pdf_id = $_POST['pdf_id'];
	else
		$pdf_id = $_GET['pdf_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsPDFs = sprintf("SELECT * FROM pdfs WHERE pdf_id = %s", $pdf_id);
	if( $DEBUGGING )
		echo $query_rsPDFs;
	$rsPDFs = mysql_query($query_rsPDFs, $db_connection) or die(mysql_error());
	$row_rsPDFs = mysql_fetch_assoc($rsPDFs);

	$title			= stripslashes($row_rsPDFs['title']);
	$display_order	= stripslashes($row_rsPDFs['display_order']);
	$pdf_file	 	= $row_rsPDFs['pdf_file'];
	$flipbook	 	= $row_rsPDFs['flipbook'];
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
      <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>">
      <input type="hidden" name="pdf_id" value="<?php echo $pdf_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="600" cellpadding="1">
	  
	    <tr>
	  	<td width="100" valign="top" class="Bold"><div align="right">Display Order</div></td>
		<td  colspan="3"><input name="display_order" type="text" id="display_order" size="10" maxlength="50" value="<?php echo $display_order; ?>"/></td>
      </tr> 
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td colspan="3"><input name="title" type="text" id="title" size="40" maxlength="100" value="<?php echo $title; ?>"/></td>
      </tr>
      <tr>
      <td width="95" valign="top" ><div align="right">PDF</div></td>
		<td colspan="3" valign="top">
          <?php if( strlen($pdf_file) > 0 ) { ?>
          &nbsp;<a href="../<?php echo $PAGES_PDF_FOLDER . $pdf_file;?>" target="_blank"><?php echo $baseURL . '/' . $PAGES_PDF_FOLDER . $pdf_file;?></a>&nbsp;&nbsp;&nbsp;
		  <input type="submit" name="changePDF" id="changePDF" value="Replace" />
		  <input type="submit" name="removePDF" id="removePDF" value="Remove" />
          <?php }
		  else
		  {
		  ?>
		  <input type="submit" name="addPDF" id="addPDF" value="Add"/>
          <?php 
		  }
		   ?>          </td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Flipbook Folder</div></td>
		<td colspan="3"><input name="flipbook" type="text" id="flipbook" size="40" maxlength="50" value="<?php echo $flipbook; ?>"/>&nbsp;&nbsp;</td>
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
