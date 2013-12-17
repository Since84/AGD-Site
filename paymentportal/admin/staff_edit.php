<?php 
require_once('../Connections/dbCMS.php'); 
include("config.php");
include("config_cms.php");
require('image_defines.php');

$MM_AuthorizedLevels = "1,3,9";
require('checkaccess.php'); 
 
include("fckeditor/fckeditor.php") ; 

$DEBUGGING = false;
$staffphoto_imagefolder = "cms/staffphotos/";

if( isset($_POST['staff_id']) )
{
	$staff_id		= $_POST['staff_id'];
}
else
{
	$staff_id		= $_GET['staff_id'];
}
$page_type_id 	= 0;

$returnURL = "staff.php";

$_SESSION['returnURL'] = sprintf("%s?staff_id=%s", "staff_edit.php", $staff_id);

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
	$staff_id 		= $_POST['staff_id'];
	
	$sort_by		= $_POST['sort_by'];	
	$active			= $_POST['active'];	
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
	$table_1	 	= $_POST['table_1'];	
	$table_2	 	= $_POST['table_2'];	
	$other_1	 	= $_POST['other_1'];	
	

	if( isset($_POST['ImageAdd'])  )
	{
		$gotoURL = 'photoadd.php?id=' . $staff_id . '&type_id=' . $page_type_id . '&title=' . $last_name;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageReplace'])  )
	{
		$gotoURL = 'photoreplace.php?id=' . $staff_id . '&type_id=' . $page_type_id . '&title=' . $last_name;
		header(sprintf("Location: %s", $gotoURL));
		exit();
	}
	if( isset($_POST['ImageRemove'])  )
	{
		$gotoURL = 'photoremove.php?id=' . $staff_id . '&type_id=' . $page_type_id . '&title=' . $last_name;
		header(sprintf("Location: %s", $gotoURL));
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
			$updateSQL = sprintf("DELETE FROM staff WHERE staff_id = %s LIMIT 1", $staff_id );
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
		if( 0 ) //empty($_POST['first_name'])  )
		{
			$msg = $msg . '<font color="red">Please enter a first name.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['last_name'])  )
		{
			$msg = $msg . '<font color="red">Please enter a name.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['description'])  )
		{
			$msg = $msg . '<font color="red">Please enter general bio information".</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['desc_2'])  )
		{
			$msg = $msg . '<font color="red">Please select a Location.</font><br/>';
			$edits_ok = false;
		}
		if( empty($_POST['desc_3'])  )
		{
			$msg = $msg . '<font color="red">Please select alma mater. ".</font><br/>';
			$edits_ok = false;
		}
	
		
		if($edits_ok)
		{
			require('db_staff_update.php'); 
			$result = updateStaff($db_database, $db_connection);	
			
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
	}
}
else
{
	if( isset($_POST['staff_id']) )
		$staff_id = $_POST['staff_id'];
	else
		$staff_id = $_GET['staff_id'];
		
	mysql_select_db($db_database, $db_connection);
	$query_rsStaff = sprintf("SELECT * FROM staff WHERE staff_id = %s", $staff_id);
	if( $DEBUGGING )
		echo $query_rsStaff;
	$rsStaff = mysql_query($query_rsStaff, $db_connection) or die(mysql_error());
	$row_rsStaff = mysql_fetch_assoc($rsStaff);

	$sort_by		= $row_rsStaff['sort_by'];	
	$active		 	= $row_rsStaff['active'];	
	$first_name 	= $row_rsStaff['first_name'];	
	$middle_name 	= $row_rsStaff['middle_name'];	
	$last_name 		= $row_rsStaff['last_name'];	
	$title 			= $row_rsStaff['title'];	
	$phone 			= $row_rsStaff['phone'];	
	$email	 		= $row_rsStaff['email'];	
	$image_file		= $row_rsStaff['image_file'];	
	$short_desc 	= stripslashes($row_rsStaff['short_desc']);	
	$description 	= stripslashes($row_rsStaff['description']);	
	$desc_2		 	= stripslashes($row_rsStaff['desc_2']);	
	$desc_3		 	= stripslashes($row_rsStaff['desc_3']);	
	$desc_4		 	= stripslashes($row_rsStaff['desc_4']);	
	$desc_5		 	= stripslashes($row_rsStaff['desc_5']);	
	$table_1	 	= $row_rsStaff['table_1'];	
	$table_2	 	= $row_rsStaff['table_2'];	
	$other_1	 	= $row_rsStaff['other_1'];		
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
<span class="pagetitle"><?php echo ($deleting ? "DELETE" : "EDIT"); ?> STAFF</span>
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
      <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
      <?php if( $deleting ) echo '<span class="errorMsg"><b>CONFIRM DELETE BELOW</b></span><br/>'; ?> 
	  <table width="800" cellpadding="1">
	 
	  <tr>
	  	<td width="135" valign="top" ><div align="right">Display Order</div></td>
		<td width="653">
 <input name="sort_by" type="text" id="sort_by" size="20" maxlength="20" value="<?php echo $sort_by; ?>"/> 
        </td>
	  </tr>
      <!--
       <tr>
	  	<td valign="top" class="Bold"><div align="right">First Name</div></td>
		<td><input name="first_name" type="text" id="first_name" size="30" maxlength="50" value="<?php //echo $first_name; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Middle Name</div></td>
		<td><input name="middle_name" type="text" id="middle_name" size="30" maxlength="50" value="<?php //echo $middle_name; ?>"/></td>
	  </tr>
      -->
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td  colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
      <tr>
	  	<td valign="top" class="Bold"><div align="right">Name</div></td>
		<td><input name="last_name" type="text" id="last_name" size="30" maxlength="50" value="<?php echo $last_name; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Title</div></td>
		<td><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $title; ?>"/></td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right">Title Group</div></td>
		<td>
        	  <select name="other_1" id="other_1">
              <?php
			  include("db_staff_type_get.php");
              do { 
			  
                ?>
              <option value="<?php echo $row_rsStaffTypes['staff_type_id']; ?>"<?php if($other_1 == $row_rsStaffTypes['staff_type_id']) echo ' selected="selected" '; ?>><?php echo $row_rsStaffTypes['title']; ?></option>
              <?php
			  }  while($row_rsStaffTypes = mysql_fetch_assoc($rsStaffTypes)); 
              ?>
            </select>

        </td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Phone</div></td>
		<td><input name="phone" type="text" id="phone" size="30" maxlength="50" value="<?php echo $phone; ?>"/></td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right">Email</div></td>
		<td><input name="email" type="text" id="email" size="30" maxlength="50" value="<?php echo $email; ?>"/></td>
	  </tr>
      <tr>
	  	<td width="135" valign="top" ><div align="right">Photo (jpg)</div></td>
		<td colspan="1">
        <input type="hidden" name="image_file" value="<?php echo $image_file; ?>" />
        <?php if( strlen($image_file) > 0 ) { 
		//echo $image_file; ?>
        <img src="../<?php echo $photo_imagefolder . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
        <?php } ?>
         <?php if( strlen($image_file) > 0 ) { ?>
         <input type="submit" name="ImageReplace" id="ImageReplace" value="Replace" />
         <?php } else { ?>
         <img src="../<?php echo $photo_imagefolder . "NoPhoto.jpg"; ?>" border="1" style="float:left; margin-right:20px;" />
         <input type="submit" name="ImageAdd" id="ImageAdd" value="Add"/>
         <?php } ?>  
          <?php if( strlen($image_file) > 0 ) { ?>
          <input type="submit" name="ImageRemove" id="ImageRemove" value="Remove" />
          <?php } ?>    
         
        </td>
	  </tr>
      <tr>
	  	<td valign="top" class="Bold"><div align="right">General</div></td>
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
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Location </strong></div></td>
		<td>
		<select name="desc_2" id="desc_2">
              <option value=""></option>
              <option value="Atlanta"<?php if($desc_2 == "Atlanta") echo ' selected="selected" '; ?>>Atlanta</option>
              <option value="San Francisco"<?php if($desc_2 == "San Francisco") echo ' selected="selected" '; ?>>San Francisco</option>
            </select>
		 </td>
	  </tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Alma Mater </strong></div></td>
		<td>
		<select name="desc_3" id="desc_3">
              <option value="" >&nbsp; </option>
              <?php
			  include("db_campus_get.php");
              do { 
			  
                ?>
              <option value="<?php echo $row_rsCampus['campus_id']; ?>"<?php if($desc_3 == $row_rsCampus['campus_id']) echo ' selected="selected" '; ?>><?php echo $row_rsCampus['name']; ?></option>
              <?php
			  }  while($row_rsCampus = mysql_fetch_assoc($rsCampus)); 
              ?>
            </select>
		 </td>
	  </tr>
      <!--
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Business Background </strong></div></td>
		<td><?php/* 
		$oFCKeditor = new FCKeditor('desc_2') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_2;
		if( $_SESSION['AdminLevel'] < 1 )
			$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
        */
		?>   </td>
	  </tr>
     
      
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Educational Background </strong></div></td>
		<td><?php
		/*
		$oFCKeditor = new FCKeditor('desc_3') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_3;
		if( $_SESSION['AdminLevel'] < 1 )
			$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		*/
		?>   </td>
	  </tr>
             <tr>
	  	<td valign="top" ><div align="right"><strong>Current Activities&nbsp;</strong></div></td>
		<td><?php
		/* 
		$oFCKeditor = new FCKeditor('desc_4') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_4;
		if( $_SESSION['AdminLevel'] < 1 )
			$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		*/
		?>   </td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right"><strong>Self-description&nbsp;</strong></div></td>
		<td><?php 
		/*
		$oFCKeditor = new FCKeditor('desc_5') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_5;
		if( $_SESSION['AdminLevel'] < 1 )
			$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		*/
		?>   </td>
	  </tr>
      <tr>
	  	<td valign="top" ><div align="right"><strong>Industry Experience<br/>
	  	</strong><small>Enter industries separated by semi-colons</small></div></td>
		<td>
		<textarea name="table_1" id="table_1" cols="60" rows="3"><?php //echo $table_1; ?></textarea>
		</td>
      </tr>
             <tr>
	  	<td valign="top" ><div align="right"><strong>Area  Expertise<br/>
	  	</strong><small>Enter areas separated by semi-colons</small></div></td>
		<td>
		<textarea name="table_2" id="table_2" cols="60" rows="3"><?php //echo $table_2; ?></textarea>
	   </td>
      </tr>
      -->
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
