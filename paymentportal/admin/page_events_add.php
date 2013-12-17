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
//echo $page_id;

$returnURL = "page_events.php?page_id=" . $page_id;
$active = 1;


if( isset($_POST["ADDEVENT"]) )
{
	if( isset($_POST['Cancel']) )
	{
		header(sprintf("Location: %s", $returnURL));
		exit();
	}
	
	if( $_POST['active'] == 'on' )
		$active = 1;
	else
		$active = NULL;
	
	$description	= $_POST['description'];	
	$event_date 	= $_POST['event_date'];	
	$event_name 	= $_POST['event_name'];	
	$place		 	= $_POST['place'];
	$active			= $_POST['active'];	
	$add_info		= $_POST['add_info'];	
		
	// edits
	$edits_ok = true;
	if( empty($_POST['place'])  )
	{
		$msg = $msg . '<font color="red">Please enter a location.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['event_date'])  )
	{
		$msg = $msg . '<font color="red">Please enter an event date.</font><br/>';
		$edits_ok = false;
	}
	
	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
	
		//   GetSQLValueString($db_filename_pdf, "text"),
		
		// now update database
		require('db_event_add.php'); 
		$product_id = addEvent($db_database, $db_connection);
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
<span class="pagetitle">ADD AN  EVENT</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDEVENT" id="ADDEVENT" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
	  <input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
            
	  <table width="900" cellpadding="1">
	   <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td  colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	</tr> 
	   <tr>
	  	<td valign="top" class="Bold"><div align="right">Date</div></td>
		<td><input name="event_date" type="text" id="event_date" size="15" maxlength="10" value="<?php echo $event_date; ?>"/>
		<img onclick="showCal('event_date')" src="../calendar/icon.gif" width="16" height="16" /> (YYYY-MM-DD)</td>
	  </tr>
	   <tr>
	  	<td valign="top" class="Bold"><div align="right">Title</div></td>
		<td><input name="event_name" type="text" id="event_name" size="30" maxlength="50" value="<?php echo $event_name; ?>"/>
		</td>
	  </tr>
      <tr>
	  	<td width="105" valign="top" ><div align="right">Location</div></td>
		<td colspan="1">
         <?php 
		$oFCKeditor = new FCKeditor('place') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $place;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>             </td>
	  </tr>
       <tr>
	  	<td width="105" valign="top" ><div align="right">Time</div></td>
		<td colspan="1">
        <input name="add_info" type="text" id="add_info" size="30" maxlength="50" value="<?php echo $add_info; ?>"/>        </td>
	  </tr>
       <tr>
	  	<td width="105" valign="top" ><div align="right">Description</div></td>
		<td colspan="1">
         <?php 
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $description;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 300;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>      
       
             </td>
	  </tr>
     <tr>
	  	<td width="105" valign="top">&nbsp;</td>
		<td>
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
       <tr>
	  	<td width="105" valign="top">&nbsp;</td>
		<td>           </td>
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
