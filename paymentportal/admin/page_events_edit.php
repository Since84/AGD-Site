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

if( isset($_POST['event_id']) )
	$event_id		= $_POST['event_id'];
else
	$event_id		= $_GET['event_id'];

if( isset($_POST['page_id']) )
	$page_id		= $_POST['page_id'];
else
	$page_id		= $_GET['page_id'];

if( $DEBUGGING )
	echo 'event id: ' . $event_id;

$page_type_id 	= -2;

$returnURL = "page_events.php";

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
	if( $_POST['delete'] == true  )
	{
			$updateSQL = sprintf("DELETE FROM events WHERE event_id = %s LIMIT 1", $event_id );
			mysql_select_db($db_database, $db_connection);
			$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
			
			// echo '<br/>return: ' . $returnURL;
			
			header(sprintf("Location: %s", $returnURL));
			exit();
	}
	else
	{
		// edits
		if( $_POST['active'] == 'on' )
			$active = 1;
		else
			$active = NULL;
		
	$course_id 		= $_POST['course_id'];	
	$event_date		= $_POST['event_date'];	
	$event_name		= $_POST['event_name'];	
	$place			= $_POST['place'];	
	$active			= $_POST['active'];	
	$add_info		= $_POST['add_info'];	
	$description	= $_POST['description'];	
			
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
	
		if($edits_ok)
		{
			require('db_event_update.php'); 
			$result = updateEvent($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['event_id']) )
		$event_id = $_POST['event_id'];
	else
		$event_id = $_GET['event_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsEvents = sprintf("SELECT * FROM events WHERE event_id = %s", $event_id);
	if( $DEBUGGING )
		echo $query_rsEvents;
	$rsEvents = mysql_query($query_rsEvents, $db_connection) or die(mysql_error());
	$row_rsEvents = mysql_fetch_assoc($rsEvents);

	$course_id 		= $row_rsEvents['course_id'];	
	$event_date		= $row_rsEvents['event_date'];	
	$event_name		= $row_rsEvents['event_name'];	
	$place			= $row_rsEvents['place'];	
	$active			= $row_rsEvents['active'];	
	$add_info		= $row_rsEvents['add_info'];	
	$description	= $row_rsEvents['description'];	
	
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
<span class="pagetitle"><?php echo ($deleting ? "DELETE" : "EDIT"); ?> AN EVENT</span>
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
      <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="800" cellpadding="1">
	 
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
		?>          </td>
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
		
		$oFCKeditor->Height = 600;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>      
       
             </td>
	  </tr>
      <tr>
	  	<td width="135" valign="top">&nbsp;</td>
		<td>
        <input name="Update2" type="submit" id="Update2" value="<?php echo ($deleting ? "Confirm Delete" : "Update"); ?>" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
        </td>
	  </tr>
       <tr>
	  	<td width="135" valign="top">&nbsp;</td>
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
