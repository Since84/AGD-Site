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


if( isset($_FILES['image2_file']['name']) && strlen($_FILES['image2_file']['name']) > 1 )
{
	if( $TESTING )
		echo '<br/>upload: ' . $_FILES['image2_file']['name'];
	
	// check for exceeding maximum file size
	$fsize_photo   = (int)$_FILES['image2_file']['size'];

	$checks_ok = true;
	if( $fsize_photo >  $imageDef->getMaxImageSize() || $_FILES['image2_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image2_file']['name'] . ') size exceeds maximum file size of ' . $imageDef->getMaxImageSize() . ' KB.</font></p>';
		$checks_ok = false;
	}
	else
	{
		if( $_FILES['image2_file']['error'] > 0 )
		{
			$msg .= '<p><font color="red">An error occurred when uploading the image file  (' . $_FILES['image2_file']['name'] . ').  Error Code: ' . $_FILES['image2_file']['error'] . '</font></p>';
			$checks_ok = false;
		}
		else
		{
			// create filename
			$extension = explode('.', $_FILES['image2_file']['name']);
			$date_time = date("YmdHis");
			$filename = $imageDef->getPrefix() . '2_' . $_POST['name'] . '_' . $date_time . '.' . $extension[1];

			$thumb_filename 	= $filename;
			$image2_filename 	= $filename;
			$fullsize_filename 	= $filename;

			$full_thumb_filename 	= "../" . $imageDef->getImageFolder() . 'thumbs/' . $filename;
			$full_image2_filename 	= "../" . $imageDef->getImageFolder() . $filename;
			$full_fullsize_filename = "../" . $imageDef->getImageFolder() . 'fullsize/' . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image2_filename: ' . $image2_filename . ', ' . $full_image2_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( file_exists($full_image2_filename) )
				$do = unlink($full_image2_filename);
			if( file_exists($full_fullsize_filename) )
				$do = unlink($full_fullsize_filename);

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
                
				$size   = getImageSize($_FILES['image2_file']['tmp_name']);
				
				if( $TESTING )
				{
					echo '<br/>owdith: ' . $size[0];
					echo '<br/>oheight: ' . $size[1];
					echo '<br/>exten: ' . $extension[1];
				}

				////////////////////////////////
				// create original image object
	            if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image2_file']['tmp_name']);
				
				
				$start_height = 0;
				$start_width = 0;

				///////////////////////////
				// processing thumb
				if( $imageDef->isCropThumb() ) 
				{
					$thumb = imagecreatetruecolor($imageDef->getThumbWidth(),$imageDef->getThumbHeight());
					imagecopyresampled($thumb,$original,0,0,$start_width,$start_height,$imageDef->getThumbWidth(),$imageDef->getThumbHeight(), $imageDef->getThumbWidth(), $imageDef->getThumbHeight());
				}
				else
				{
					$thumb_dims		= calc_photo_dims($imageDef->getThumbWidth(), $imageDef->getThumbHeight(), $size[0], $size[1]);
					$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
                	imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
				}

				///////////////////////////
				// processing image
				if( $imageDef->isCropImage() ) 
				{
					$image = imagecreatetruecolor($imageDef->getImageWidth(),$imageDef->getImageHeight());
					imagecopyresampled($image,$original,0,0,$start_width,$start_height,$imageDef->getImageWidth(),$imageDef->getImageHeight(), $imageDef->getImageWidth(), $imageDef->getImageHeight());
				}
				else
				{
					$image_dims 	= calc_photo_dims($imageDef->getImageWidth(), $imageDef->getImageHeight(), $size[0], $size[1]);
					$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
	                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
				}


				//////////////////////////////////////////////
				// processing original - NO CROPPING!
				$fullsize_dims	= calc_photo_dims($imageDef->getFullWidth(),  $imageDef->getFullHeight(),  $size[0], $size[1]);
				$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);
                imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
				
				
				//////////////////////////////////////////////
				
				if( $TESTING )
				{
					echo '<br/>saving...';
					echo '<br/>' . $full_thumb_filename;
					echo '<br/>' . $full_image2_filename;
					echo '<br/>' . $full_fullsize_filename;
				}
				
			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 80);
					imageJPEG($image, $full_image2_filename, 80);
					imageJPEG($fullsize, $full_fullsize_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					imagePNG($image, $full_image2_filename);
					imagePNG($fullsize, $full_fullsize_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					imageGIF($image, $full_image2_filename);
					imageGIF($fullsize, $full_fullsize_filename);
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
?>