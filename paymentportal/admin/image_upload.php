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

require_once("image_calc_dim.php");

$TESTING = false;

if( $imageDef == NULL )
	echo 'Need to create $imageDef obj for image_upload.php';

if( $TESTING )
{
	echo '<br/>upload: ' . $_FILES['image_file']['name'];
	echo '<br/>filesize: ' . (int)$_FILES['image_file']['size'];

	echo '<br/>upload2: ' . $_FILES['image2_file']['name'];
	echo '<br/>upload3: ' . $_FILES['image3_file']['name'];
	echo '<br/>upload4: ' . $_FILES['image4_file']['name'];
	
	echo '<br/>thumbonly: ' . $thumbonly;
	echo '<br/>thumb_file: ' . $thumb_file;
	
	echo '<br/>getPrefix: ';
	echo $imageDef->getPrefix();
	echo '<br/>getMaxSize: ';
	echo $imageDef->getMaxSize();
	echo '<br/>getMaxImageSize: ';
	echo $imageDef->getMaxImageSize();
	echo '<br/>getMaxThumbSize: ';
	echo $imageDef->getMaxThumbSize();
	echo '<br/>getImageFolder: ';
	echo $imageDef->getImageFolder();
	echo '<br/>getThumbWidth: ';
	echo $imageDef->getThumbWidth();
	echo '<br/>getThumbHeight: ';
	echo $imageDef->getThumbHeight();
	echo '<br/>getImageWidth: ';
	echo $imageDef->getImageWidth();
	echo '<br/>getImageHeight: ';
	echo $imageDef->getImageHeight();
	echo '<br/>getFullWidth: ';
	echo $imageDef->getFullWidth();
	echo '<br/>getFullHeight: ';
	echo $imageDef->getFullHeight();
	echo '<br/>isCropThumb: ';
	echo ($imageDef->isCropThumb() ? "true" : "false");
	echo '<br/>isCropImage: ';
	echo ($imageDef->isCropImage() ? "true" : "false");
	echo '<br/>isManualCrop: ';
	echo ($imageDef->isManualCrop() ? "true" : "false");
	echo '<hr/><br/>';
}

$tmp = '../' . $imageDef->getImageFolder();
if( !file_exists($tmp) ) {
	mkdir($tmp,0777);
	if( $TESTING )
		echo 'attempting to create dir: ' . $imageDef->getImageFolder();
} 
$tmp = '../' . $imageDef->getImageFolder() . 'thumbs/';
if( !file_exists($tmp) ) {
	mkdir($tmp,0777);
} 
$tmp = '../' . $imageDef->getImageFolder() . 'fullsize/';
if( !file_exists($tmp) ) {
	mkdir($tmp,0777);
} 

////////////////////////////////////////////////////////////////////////////////////////
// upload a file and return file name
$upload_ok = false;
if( isset($_FILES['image_file']['name']) && strlen($_FILES['image_file']['name']) > 1 )
{
	if( $TESTING )
		echo '<br/>upload: ' . $_FILES['image_file']['name'];
	
	// check for exceeding maximum file size
	$fsize_photo   = (int)$_FILES['image_file']['size'];

	$checks_ok = true;
	if( $fsize_photo >  $imageDef->getMaxImageSize() || $_FILES['image_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image_file']['name'] . ') size exceeds maximum file size of ' . $imageDef->getMaxImageSize() . ' KB.</font></p>';
		$checks_ok = false;
	}
	else
	{
		if( $_FILES['image_file']['error'] > 0 )
		{
			$msg .= '<p><font color="red">An error occurred when uploading the image file  (' . $_FILES['image_file']['name'] . ').  Error Code: ' . $_FILES['image_file']['error'] . '</font></p>';
			$checks_ok = false;
		}
		else
		{
			$extension = explode('.', $_FILES['image_file']['name']);
			if( $thumbonly ) 
			{
				$filename = $thumb_file;
			}
			else
			{
				// create filename
				$date_time = date("YmdHis");
				$filename = $imageDef->getPrefix() . '_' . $_POST['name'] . '_' . $date_time . '.' . $extension[1];
			}
			
			$thumb_filename 	= $filename;
			$image_filename 	= $filename;
			$fullsize_filename 	= $filename;

			$full_thumb_filename 	= "../" . $imageDef->getImageFolder() . 'thumbs/' . $filename;
			$full_image_filename 	= "../" . $imageDef->getImageFolder() . $filename;
			$full_fullsize_filename = "../" . $imageDef->getImageFolder() . 'fullsize/' . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image_filename . ', ' . $full_image_filename;
				if( $thumbonly )
							echo '<br/>thumb_image_filename: ' . $full_thumb_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( !$thumbonly )
			{
				if( file_exists($full_image_filename) )
					$do = unlink($full_image_filename);
				if( file_exists($full_fullsize_filename) )
					$do = unlink($full_fullsize_filename);
			}
			
			$extension[1] = strtolower($extension[1]);
			if( $TESTING )
				echo '<br/>ext: ' . $extension[1];
				
			if( $TESTING )
				echo (function_exists('imagecreatefromjpeg') ? "true" : "false");
			if( $TESTING )
				echo ($extension[1] == 'jpg' ? "true" : "false");
			// 
			if($extension[1] == 'png' && function_exists('imagecreatefrompng') || $extension[1] == 'jpg' && function_exists('imagecreatefromjpeg') || $extension[1] == 'jpeg' && function_exists('imagecreatefromjpeg') || $extension[1] == 'gif' && function_exists('imagecreatefromgif')  || $extension[1] == 'bmp' && function_exists('imagecreatefromwbmp')) 
			{
                
				$size   = getImageSize($_FILES['image_file']['tmp_name']);
				
				if( $TESTING )
				{
					echo '<br/>owdith: ' . $size[0];
					echo '<br/>oheight: ' . $size[1];
					echo '<br/>exten: ' . $extension[1];
				}

				////////////////////////////////
				// create original image object
	            if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image_file']['tmp_name']);
				
				
				$start_height = 0;
				$start_width = 0;
				
				// calculate destination width and height... which cannot exceed actual size of incoming image
				$desThumbWidth 	= ( $size[0] < $imageDef->getThumbWidth()  ? $size[0] : $imageDef->getThumbWidth() ); 
				$desThumbHeight	= ( $size[1] < $imageDef->getThumbHeight() ? $size[1] : $imageDef->getThumbHeight() ); 
				
				$desImageWidth 	= ( $size[0] < $imageDef->getImageWidth()  ? $size[0] : $imageDef->getImageWidth() ); 
				$desImageHeight	= ( $size[1] < $imageDef->getImageHeight() ? $size[1] : $imageDef->getImageHeight() ); 
				
				$desFullWidth 	= ( $size[0] < $imageDef->getFullWidth()  ? $size[0] : $imageDef->getFullWidth() ); 
				$desFullHeight	= ( $size[1] < $imageDef->getFullHeight() ? $size[1] : $imageDef->getFullHeight() ); 
				
				///////////////////////////
				// processing thumb
				if( $imageDef->isCropThumb() ) 
				{
					$thumb = imagecreatetruecolor($imageDef->getThumbWidth(),$imageDef->getThumbHeight());
					imagecopyresampled($thumb,$original,0,0,$start_width,$start_height,$desThumbWidth,$desThumbHeight, $size[0], $size[1]);
				}
				else
				{
					$thumb_dims		= calc_photo_dims($desThumbWidth, $desThumbHeight, $size[0], $size[1]);
					$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
                	imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
				}

				if( !$thumbonly ) 
				{
	
					///////////////////////////
					// processing image
					if( $imageDef->isCropImage() ) 
					{
						$image = imagecreatetruecolor($desImageWidth,$desImageHeight);
						imagecopyresampled($image,$original,0,0,$start_width,$start_height,$desImageWidth,$desImageHeight, $size[0], $size[1]);
					}
					else
					{
						$image_dims 	= calc_photo_dims($desImageWidth, $desImageHeight, $size[0], $size[1]);
						$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
						imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
					}
	
	
					//////////////////////////////////////////////
					// processing original - NO CROPPING!
					$fullsize_dims	= calc_photo_dims($desFullWidth,  $desFullHeight,  $size[0], $size[1]);
					$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);
					imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
					
					
					//////////////////////////////////////////////
					
					if( $TESTING )
					{
						echo '<br/>saving...';
						echo '<br/>' . $full_thumb_filename;
						echo '<br/>' . $full_image_filename;
						echo '<br/>' . $full_fullsize_filename;
					}
				}
								
			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 100);
					if( !$thumbonly )
					{
						imageJPEG($image, $full_image_filename, 100);
						imageJPEG($fullsize, $full_fullsize_filename, 100);
					}
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					if( !$thumbonly )
					{
						imagePNG($image, $full_image_filename);
						imagePNG($fullsize, $full_fullsize_filename);
					}
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					if( !$thumbonly )
					{
						imageGIF($image, $full_image_filename);
						imageGIF($fullsize, $full_fullsize_filename);
					}
				}
                
				if( $TESTING ) 
					echo 'Successfully resized.';
				$upload_ok = true;
                
            } 
			else
			{
                $error = 'File type not supported!';
			}
		}
	}
}

////////////////////////////////////////////////////////////////////////////////////////
// TO HANDLE TWO FILES at a time - SECOND IMAGE
include("image_upload2.php");
include("image_upload3.php");

// 
// upload error codes ($_FILES['file']['error']
//
// UPLOAD_ERR_OK
// Value: 0; There is no error, the file uploaded with success. 
//
// UPLOAD_ERR_INI_SIZE
// Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini. 
//
// UPLOAD_ERR_FORM_SIZE
// Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. 
//
// UPLOAD_ERR_PARTIAL
// Value: 3; The uploaded file was only partially uploaded. 
// 
// UPLOAD_ERR_NO_FILE
// Value: 4; No file was uploaded. 
// 
// UPLOAD_ERR_NO_TMP_DIR
// Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3. 
// 
// UPLOAD_ERR_CANT_WRITE
// Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0. 
// 
// UPLOAD_ERR_EXTENSION
// Value: 8; File upload stopped by extension. Introduced in PHP 5.2.0. 
// 
// Note: These became PHP constants in PHP 4.3.0.
// 
// ========================================

?>