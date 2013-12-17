<?php 
require_once('../Connections/dbCMS.php'); 
require('checkaccess.php'); 
include("config.php");
include("db_utils.php");
include("image_defines.php"); 	// photo defines
	
$DEBUGGING = false;
if( $DEBUGGING )
	echo 'testing...';
	
$returnURL 	= $_SESSION['returnURL'];

if( isset($_POST['page_id']) )
{
	$page_id 		= $_POST['page_id'];
	$title 			= $_POST['title'];
	$page_type_id 	= $_POST['page_type_id'];
	$image_file 	= $_POST['image_file'];
}
else
{
	$page_id 		= $_GET['page_id'];
	$title 			= $_GET['title'];
	$page_type_id 	= $_GET['page_type_id'];
	$image_file 	= $_GET['image_file'];
}
if( $DEBUGGING )
{
	echo 'page id: ' . $page_id;
	echo 'page_type_id: ' . $page_type_id;
	echo 'image_file: ' . $image_file;
}
if( isset($_GET['a']) )
	$a = $_GET['a'];
else
	$a = $_POST['a'];
$isAdding = ($a == 1 ? true : false);

if( isset($_GET['i']) )
	$i = $_GET['i'];
else
	$i = $_POST['i'];
$cropImage = ($i == 1 ? true : false);
		
$img_no = '1';
if( isset($_GET['img_no']) )
	$img_no = $_GET['img_no'];
else
if( isset($_POST['img_no']) )
	$img_no = $_POST['img_no'];

$msg = '';
	
if( isset($_POST['Cancel']) )
{
	header(sprintf("Location: %s", $returnURL));
	exit();
}

$imageDef = new imageDefines($page_type_id, $db_database, $db_connection);

/////////////////////////////////
// NOTE ON code below
// Changed to integrate into CMS
// by Sky High Software 2010
/////////////////////////////////
/*
* Copyright (c) 2008 http://www.webmotionuk.com
* "PHP & Jquery image upload & crop"
* Date: 2008-05-15
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/

//Constants
//You can alter these options

$max_file 			= $imageDef->getMaxSize();			// Approx 3.5MB

if( $cropImage )
{
	$max_width 			= $imageDef->getImageWidth();		// Max width allowed for the large image
	$thumb_width 		= $imageDef->getImageWidth();		// Width of thumbnail image
	$thumb_height 		= $imageDef->getImageHeight();		// Height of thumbnail image
}
else
{
	$max_width 			= $imageDef->getThumbWidth();		// Max width allowed for the large image
	$thumb_width 		= $imageDef->getThumbWidth();		// Width of thumbnail image
	$thumb_height 		= $imageDef->getThumbHeight();		// Height of thumbnail image
}

//Image functions
//You do not need to alter these functions
function resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,100);
	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	if( $DEBUGGING )
	{
		echo '<br/>start_width: ' . $start_width;
		echo '<br/>start_height: ' . $start_height;
		echo '<br/>newImageWidth: ' . $newImageWidth;
		echo '<br/>newImageHeight: ' . $newImageHeight;
		echo '<br/>width: ' . $width;
		echo '<br/>height: ' . $height;
	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$thumb_image_name,100);
	chmod($thumb_image_name, 0777);
	//echo $thumb_image_name;
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}

///////////////////////////////////////////////////////////////////////
//Image Locations
if( $cropImage )
{
	$description = "Main Image";
	$large_image_location = '../' . $imageDef->getImageFolder() . 'fullsize/' . $image_file;
	$thumb_image_location = '../' . $imageDef->getImageFolder() . $image_file;
}
else
{
	$description = "thumb";
	$large_image_location = '../' . $imageDef->getImageFolder() . $image_file;
	$thumb_image_location = '../' . $imageDef->getImageFolder() . 'thumbs/' . $image_file;
}

if( $DEBUGGING )
{
	echo '<br/>large: ' . $large_image_location;
	echo '<br/>thumb: ' . $thumb_image_location;
	echo '<br/>width: ' . $thumb_width;
	echo '<br/>height: ' . $thumb_height;
}

$temp_name = 'temp_' . date("ymds") . '.jpg';

if (isset($_POST["upload_thumbnail"]) ) {

	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($temp_name, $large_image_location,$w,$h,$x1,$y1,$scale);

	// only delete original thumb when new one created successfully	
	if(file_exists($thumb_image_location))
		unlink($thumb_image_location);
	rename($temp_name, $thumb_image_location);
	
	if( $isAdding )
	{
		if( $i == 1 )
			$returnURL = 'photo_crop.php?page_id='.$page_id.'&page_type_id='.$page_type_id.'&title='.$title.'&image_file='.$image_file.'&a=1&i=0';
	}

	header(sprintf("Location: %s", $returnURL));
	exit();
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
<script type="text/javascript" src="../js/jquery-pack.js"></script>
<script type="text/javascript" src="../js/jquery.imgareaselect-0.3.min.js"></script>
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
    
    <!-- 
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* Date: 2008-05-15
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php

<ul>
	<li><a href="http://www.webmotionuk.co.uk/php-jquery-image-upload-and-crop/">Back to project page</a></li>
	<li><a href="http://www.webmotionuk.co.uk/jquery_upload_crop.zip">Download Files</a></li>
</ul>
-->
<?php
//Only display the javacript if an image has been uploaded
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width; ?>', onSelectChange: preview }); 
});

</script>
<hr/>
			
     <table width="90%" border="0" cellspacing="0" cellpadding="2" style="margin-left:10px;">
  <tr>
  <td colspan="3" class="pagetitle"><br />
    Crop to create new <?php echo $description; ?></td>
  </tr>
  <tr>
  <td colspan="3">
  <?php echo $msg; ?>  </td>
      <tr>
	  	<td width="116" valign="top" class="Bold"><div align="right">Title </div></td>
		<td width="1335" colspan="3"><?php echo $title; ?> <?php if( $type_id == -1 ) { if( $img_no == '1' ) echo '(on state)'; else echo '(off state)';  } ?></td>
      </tr>
      <tr>
	  	<td width="116" valign="top" ><div align="right">Image (jpg)</div></td>
		<td colspan="3">
        <!--image stuff -->
       
          <div align="left">
			<img src="<?php echo $large_image_location; ?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
			<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $large_image_location; ?>" style="position: relative;" alt="Thumbnail Preview" />
            </div>
			<br style="clear:both;"/>
			
		<br/>
          
          <form name="thumbnailForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <input type="hidden" name="MM_crop" value="<?php echo $type_id; ?>">
    <input type="hidden" name="type_id" value="<?php echo $type_id; ?>">
    <input type="hidden" name="page_type_id" value="<?php echo $page_type_id; ?>">
    <input type="hidden" name="image_file" value="<?php echo $image_file; ?>">
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
       <input type="hidden" name="img_no" value="<?php echo $img_no; ?>">
       <input type="hidden" name="a" value="<?php echo $a; ?>">
       <input type="hidden" name="i" value="<?php echo $i; ?>">
       
    			<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
    	<input type="submit" name="upload_thumbnail" value="Crop" id="save_thumb" />
		<input name="Cancel" type="submit" id="Cancel" value="Cancel" />
      	  </form>
          </div>
          <br/>
           Left click inside the large image and drag to select thumbnail outline. 
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
