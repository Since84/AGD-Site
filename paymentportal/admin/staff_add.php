<?php 
require_once('../Connections/dbCMS.php'); 
include("config.php");
include("config_cms.php");
require('image_defines.php');

$MM_AuthorizedLevels = "1,3,9";
require('checkaccess.php'); 

include("fckeditor/fckeditor.php") ; 


$returnURL = "staff.php";
$active = 1;

if( isset($_POST["ADDSTAFF"]) )
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
	
	$first_name 	= $_POST['first_name'];	
	$middle_name 	= $_POST['middle_name'];	
	$last_name 		= $_POST['last_name'];	
	$title		 	= $_POST['title'];	
	$phone		 	= $_POST['phone'];	
	$email		 	= $_POST['email'];	
	$short_desc 	= stripslashes($_POST['short_desc']);	
	$description 	= stripslashes($_POST['description']);
	$desc_2		 	= stripslashes($_POST['desc_2']);	
	$desc_3		 	= stripslashes($_POST['desc_3']);	
	$desc_4		 	= stripslashes($_POST['desc_4']);	
	$desc_5		 	= stripslashes($_POST['desc_5']);	
	$table_1	 	= stripslashes($_POST['table_1']);	
	$table_2	 	= stripslashes($_POST['table_2']);	
	$other_1	 	= $_POST['other_1'];
	
	if( isset($_FILES['image_file']['name'])  )
		$image_file = $_FILES['image_file']['name'];
	else
		$image_file = NULL;
		
	// edits
	$edits_ok = true;
	if( empty($_POST['last_name'])  )
	{
		$msg = $msg . '<font color="red">Please enter a last name.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['description'])  )
	{
		$msg = $msg . '<font color="red">Please enter bio infomration.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['desc_2'])  )
	{
		$msg = $msg . '<font color="red">Please select a Location.</font><br/>';
		$edits_ok = false;
	}
	if( empty($_POST['desc_3'])  )
	{
		$msg = $msg . '<font color="red">Please select an Alma Mater.</font><br/>';
		$edits_ok = false;
	}
	
	// if passed edits, update	
	if($edits_ok)
	{
		if( $DEBUGGING )
			echo '<br/>addiing update';
	
		$upload_ok = true; 
		
		if( $image_file )
		{
			// input defines
			$input_maxsize 			= $photo_maxsize;
			$input_maximagesize 	= $photo_maximagesize;
			$input_maxthumbsize 	= $photo_maxthumbsize;	// max thumb size
			$input_imagefolder  	= $photo_imagefolder;
			$input_thumbfolder  	= $photo_imagefolder . 'thumbs/';
			$input_largefolder  	= $photo_imagefolder . 'fullsize/';
			$input_thumbsize	    = $photo_thumbsize; 	// w , h
			$input_imagesize	    = $photo_imagesize; 	// w , h
			$input_fullsize	    	= $photo_fullsize; 	// w , h
			$input_prefix	    	= $PHOTOS_IMG_PREFIX; 
			require('db_image_upload.php');	
		}
				
		if( $upload_ok )
		{
			//   GetSQLValueString($db_filename_pdf, "text"),
			
			// now update database
			require('db_staff_add.php'); 
			$product_id = addStaff($image_filename, $db_database, $db_connection);
			header(sprintf("Location: %s", $returnURL));
			exit();
		}
		else
		{
			$msg = $msg . '<font color="red">Photo missing or upload failed.</font><br/>';
			$edits_ok = false;
		}
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
<span class="pagetitle">ADD STAFF</span>
       <table width="100%">
     <tr>
     	<td width="16%" height="24">
        <?php if( strlen($msg) > 1 ) echo '<span class="errorMsg">' . $msg . '</span>'; ?>
             </td>
     </tr>
     </table>
      <form name="form1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="ADDSTAFF" id="ADDSTAFF" value="1" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
            
	  <table width="900" cellpadding="1">
	  
	 <tr>
	  	<td valign="top" class="Bold"><div align="right">Active</div></td>
		<td  colspan="2"><label>
		  <input type="checkbox" name="active" id="active" <?php if($active == 1) echo 'checked="checked"'; ?> />
		</label></td>
  	    
  	</tr> 
     <tr>
	  	<td width="105" valign="top" ><div align="right">Display Order</div></td>
		<td width="783">
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
	  	<td width="105" valign="top" ><div align="right">Photo (jpg)</div></td>
		<td colspan="1">
        <input type="file" name="image_file" size="70">        </td>
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
              <?php if( $_SESSION['AdminLevel'] > 1 ) { ?>
              <option value="San Francisco"<?php if($desc_2 == "San Francisco") echo ' selected="selected" '; ?>>San Francisco</option>
              <?php } ?>
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
	  	<td width="105" valign="top">&nbsp;</td>
		<td>
        <input name="Continue" type="submit" id="Continue" value="Add" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" /></td>
	  </tr>
       <tr>
	  	<td width="105" valign="top">&nbsp;</td>
		<td>
          <p>
                <span class="footer">
                  Note:  File uploading and resizing may take a several  minutes.  Please wait for it to complete.	
         </span></p>
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
