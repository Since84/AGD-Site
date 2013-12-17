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
<p><span class="pagetitle"> FAQS </span>
<br/><br/>
  <p>
  <table cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td width="641">
      <table width="600" border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td><span class="categorytitle">Why are there strange characters displaying in the text I pasted onto a page.</span></td>
      </tr>
      <tr>
      <td>
      <p>There are some differences in special characters from MS Word and other editors that don't translate well onto a webpage. Try deleting the character and re-typing it. 
        </p>
        </td>
        </tr>
        <tr>
        <td height="20"></td>
        </tr>
        <tr>
        <td><span class="categorytitle">After I updated my webpage, the live page is out of alignment including areas outside of my content.</span></td>
        </tr>
        <tr>
        <td>
      <p>If you copied and pasted from MS Word, special control characters may have been inserted that throw the entire page out of alignment.  To fix this problem, you may have to clear the  area and re-enter the content.  
      <br/>
      <br/>
      To avoid this problem, try using the "Paste from Word" feature in the editor.  See the help section for more information.  Another technique is to copy into a basic text editor, such as Notepad, first and then into the webpage editor.  Even more ideal is to create the content in the editor with the formatting you'd like.  
      <br/><br/>
      These techniques will help you keep your pages clean and consistent by avoiding the insertion of different fonts, text sizes, text colors, etc.</p>
      </td>
      </tr>
       <tr>
        <td height="20"></td>
        </tr>
      <tr>
      <td>     <span class="categorytitle">My photo upload failed. What could be wrong?</span></td>
      </tr>
      <tr>
      <td>
      
      <p>If you photo upload takes a long time or fails, the most likely reasons are: </p>
        <ul>
          <li>the photo file is too large</li>
          <li>filename contains special characters such as an extra period (ie filename.more.jpg) </li>
        </ul>
      </td>
      </tr>
       <tr>
        <td height="20"></td>
        </tr>
      </table>
	</td>
    <td width="349" valign="top">
    <div id="tipTrick">
        <span class="categorytitle">Editing Tip: <br />
        </span>For best results, do not copy text from MS Word. Copy from Word to NotePad or some other plain text editor and then copy to web editor. You can then format inside the web editor for bolding titles, lists, etc. <br/>
        </div>
</td>
</tr>
</table>      
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
