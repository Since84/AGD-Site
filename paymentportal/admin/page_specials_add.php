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
$page_title = $_POST['page_title'];

//echo '<br/>page id: ' . $page_id;
//echo '<br/>title ' . $page_title;

$returnURL = "page_specials.php?page_id=" . $page_id . '&page_title=' . $page_title;
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}


if( isset($_POST["ADDSPEC"]) )
{
	$quick_links = $_POST['quick_links'];
	
	// edits
	$edits_ok = true;
	if( empty($_POST['title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step1_title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title under Step 1.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step1_sub1_title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title for first sub title under Step 1.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step1_sub1'])  )
	{
		$msg = $msg . '<font color="red">Please enter text under first sub title under Step 1.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step2_sub1_title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title for first sub title under Step 2.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step2_sub1'])  )
	{
		$msg = $msg . '<font color="red">Please enter text under first sub title under Step 2.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step3_sub1_title'])  )
	{
		$msg = $msg . '<font color="red">Please enter a title for first sub title under Step 3.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['step3_sub1'])  )
	{
		$msg = $msg . '<font color="red">Please enter text under first sub title under Step 3.</font><br/>';
		$edits_ok = false;
	}

	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
		
		// now update database
		require('db_specials_add.php'); 
		$product_id = addSpecial($db_database, $db_connection);
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
	  <input type="hidden" name="ADDSPEC" id="ADDSPEC" value="1" />
	   <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
       <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
            
	  <table width="700" cellpadding="1">
	  
	  <tr>
	  	<td valign="top" class="Bold"><div align="right">Guide</div></td>
		<td colspan="3"><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $_POST['title']; ?>"/></td>
	  </tr>
      <tr><td bgcolor="#efefef" ><div align="right">Step 1</div></td><td colspan="3" bgcolor="#efefef"></td></tr>
       <tr>
	  	<td valign="top" ><div align="right"> Title</div></td>
		<td colspan="3"><input name="step1_title" type="text" id="step1_title" size="30" maxlength="100" value="<?php echo $_POST['step1_title']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Subtitle 1</div></td>
		<td ><input name="step1_sub1_title" type="text" id="step1_sub1_title" size="20" maxlength="100" value="<?php echo $_POST['step1_sub1_title']; ?>"/></td>
	    <td > <div align="right">Text 1</div></td>
	    <td ><input name="step1_sub1" type="text" id="step1_sub1" size="40" maxlength="100" value="<?php echo $_POST['step1_sub1']; ?>"/></td>
       </tr>
      
       <tr>
	  	<td valign="top" ><div align="right">Subtitle 2</div></td>
		<td><input name="step1_sub2_title" type="text" id="step1_sub2_title" size="20" maxlength="100" value="<?php echo $_POST['step1_sub2_title']; ?>"/></td>
        <td><div align="right">Text 2</div></td>
        <td><input name="step1_sub2" type="text" id="step1_sub2" size="40" maxlength="100" value="<?php echo $_POST['step1_sub2']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Subtitle 3</div></td>
		<td><input name="step1_sub3_title" type="text" id="step1_sub3_title" size="20" maxlength="100" value="<?php echo $_POST['step1_sub3_title']; ?>"/></td>
	  	<td valign="top" ><div align="right">Text 3</div></td>
		<td><input name="step1_sub3" type="text" id="step1_sub3" size="40" maxlength="100" value="<?php echo $_POST['step1_sub3']; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"> Considerations<br/>
	  	separate with semi-colons</div></td>
		<td colspan="3"><textarea name="step1_consider" cols="50" rows="3" id="step1_consider"><?php echo $_POST['step1_consider']; ?></textarea></td>
	  </tr>
      
       <tr><td bgcolor="#efefef" ><div align="right">Step 2</div></td><td colspan="3" bgcolor="#efefef"></td></tr>
       <tr>
	  	<td valign="top" ><div align="right"> Title</div></td>
		<td  colspan="3"><input name="step2_title" type="text" id="step2_title" size="30" maxlength="100" value="<?php echo $_POST['step2_title']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Subtitle 1</div></td>
		<td ><input name="step2_sub1_title" type="text" id="step2_sub1_title" size="20" maxlength="100" value="<?php echo $_POST['step2_sub1_title']; ?>"/></td>
		  	<td valign="top" ><div align="right">  Text 1</div></td>
		<td ><input name="step2_sub1" type="text" id="step2_sub1" size="50" maxlength="100" value="<?php echo $_POST['step2_sub1']; ?>"/></td>
  </tr>
       <tr>
	  	<td valign="top" ><div align="right"> Subtitle 2</div></td>
		<td ><input name="step2_sub2_title" type="text" id="step2_sub2_title" size="20" maxlength="100" value="<?php echo $_POST['step2_sub2_title']; ?>"/></td>
	  	<td valign="top" ><div align="right"> Text 2</div></td>
		<td ><input name="step2_sub2" type="text" id="step2_sub2" size="50" maxlength="100" value="<?php echo $_POST['step2_sub2']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right"> Subtitle 3</div></td>
		<td ><input name="step2_sub3_title" type="text" id="step2_sub3_title" size="20" maxlength="100" value="<?php echo $_POST['step2_sub3_title']; ?>"/></td>
	  	<td valign="top" ><div align="right">  Text 3</div></td>
		<td ><input name="step2_sub3" type="text" id="step2_sub3" size="50" maxlength="100" value="<?php echo $_POST['step2_sub3']; ?>"/></td>
	  </tr>
      <tr>	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"> Considerations<br/>
	  	separate with semi-colons</div></td>
		<td colspan="3"><textarea name="step2_consider" cols="50" rows="3" id="step2_consider"><?php echo $_POST['step2_consider']; ?></textarea></td>
	  </tr>
      
       <tr><td bgcolor="#efefef" ><div align="right">Step 3</div></td><td colspan="3" bgcolor="#efefef"></td></tr>
       <tr>
	  	<td valign="top" ><div align="right"> Title</div></td>
		<td colspan="3"><input name="step3_title" type="text" id="step3_title" size="30" maxlength="100" value="<?php echo $_POST['step3_title']; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Subtitle 1</div></td>
		<td ><input name="step3_sub1_title" type="text" id="step3_sub1_title" size="20" maxlength="100" value="<?php echo $_POST['step3_sub1_title']; ?>"/></td>
	  	<td valign="top" ><div align="right">  Text 1</div></td>
		<td ><input name="step3_sub1" type="text" id="step3_sub1" size="50" maxlength="100" value="<?php echo $_POST['step3_sub1']; ?>"/></td>
	  </tr>
        <tr>
	  	<td valign="top" ><div align="right"> Subtitle 2</div></td>
		<td ><input name="step3_sub2_title" type="text" id="step3_sub2_title" size="20" maxlength="100" value="<?php echo $_POST['step3_sub2_title']; ?>"/></td>
	  	<td valign="top" ><div align="right">  Text 2</div></td>
		<td ><input name="step3_sub2" type="text" id="step3_sub2" size="50" maxlength="100" value="<?php echo $_POST['step3_sub2']; ?>"/></td>
	  </tr>
      <tr>	  </tr>
       <tr>
	  	<td valign="top" ><div align="right"> Subtitle 3</div></td>
		<td ><input name="step3_sub3_title" type="text" id="step3_sub3_title" size="20" maxlength="100" value="<?php echo $_POST['step3_sub3_title']; ?>"/></td>
	  	<td valign="top" ><div align="right">  Text 3</div></td>
		<td ><input name="step3_sub3" type="text" id="step3_sub3" size="50" maxlength="100" value="<?php echo $_POST['step3_sub3']; ?>"/></td>
	  </tr>
      <tr>	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"> Considerations<br/>
	  	separate with semi-colons</div></td>
		<td colspan="3"><textarea name="step3_consider" cols="50" rows="3" id="step3_consider"><?php echo $_POST['step3_consider']; ?></textarea></td>
	  </tr>
        <tr><td ><div align="right"></div></td><td colspan="3"></td></tr>
     <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Quick Resources<br/>
	  	enter links separate by semi-colons</strong></div></td>
		<td colspan="3"><?php 
		$oFCKeditor = new FCKeditor('quick_links') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $quick_links;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 300;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
	  </tr>
      <tr>
	  	<td width="119" valign="top">&nbsp;</td>
		<td colspan="3">
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
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
