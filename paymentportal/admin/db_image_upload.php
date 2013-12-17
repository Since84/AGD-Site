<?php
require_once("db_image_calc_dim.php");

$TESTING = false;

// input defines
//	$input_maxsize 			= 8000000;
//	$input_maximagesize 	= 8000000;
//	$input_maxthumbsize 	= 100000;	// max thumb size
//	$input_imagefolder  	= $folder;
//	$input_thumbfolder  	= $folder . 'thumbs/';
//	$input_largefolder  	= $folder . 'fullsize/';
//	$input_thumbsize	    = array("60","60"); 	// w , h
//	$input_imagesize	    = array("250","250"); 	// w , h
//	$input_fullsize	    	= array("700","500"); 	// w , h
//	$input_prefix	    	= "news"; 

// input:  $_POST['image_file']
// output: $image_filename
//         $upload_ok

if( $TESTING )
{
	echo '<br/>upload: ' . $_FILES['image_file']['name'];
	echo '<br/>filesize: ' . (int)$_FILES['image_file']['size'];
	//mkdir("../test",0777); 
}

// echo 'Upload failed.  Try sizing the photo down below 2MB.  <a href="home.php">Click here to return.</a>';
		
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
	if( $fsize_photo > $input_maxsize || $_FILES['image_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image_file']['name'] . ') size exceeds maximum file size of ' . $input_maxsize . ' KB.</font></p>';
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
			// create filename
			$extension = explode('.', $_FILES['image_file']['name']);
			$date_time = date("YmdHis");
			$filename = $input_prefix . '_' . $_POST['name'] . '_' . $date_time . '.' . $extension[1];

			$thumb_filename 	= $filename;
			$image_filename 	= $filename;
			$fullsize_filename 	= $filename;

			$full_thumb_filename 	= "../" . $input_thumbfolder . $filename;
			$full_image_filename 	= "../" . $input_imagefolder . $filename;
			$full_fullsize_filename = "../" . $input_largefolder . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image_filename . ', ' . $full_image_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( file_exists($full_image_filename) )
				$do = unlink($full_image_filename);
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
                
				$size   = getImageSize($_FILES['image_file']['tmp_name']);
				
				if( $TESTING )
				{
					echo '<br/>owdith: ' . $size[0];
					echo '<br/>oheight: ' . $size[1];
				}

				// first set max width and height
				// use for proportional thumb
				// $thumb_dims 	= calc_photo_dims(60, 60,   $size[0], $size[1]);  
				$thumb_dims		= calc_photo_dims($input_thumbsize[0], $input_thumbsize[1], $size[0], $size[1]);
				$image_dims 	= calc_photo_dims($input_imagesize[0], $input_imagesize[1], $size[0], $size[1]);
				$fullsize_dims	= calc_photo_dims($input_fullsize[0], $input_fullsize[1], $size[0], $size[1]);
				
                
				$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
				$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);

				if( $TESTING )
					echo '<br/>exten: ' . $extension[1];
				
                if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image_file']['tmp_name']);
				
				if( $TESTING )
					echo '<br/>resampling...';
				
				// for proportional thumb use this	
                imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
				
				//////////////////////////////////////////////
				// for square thumb use this
				if($size[0] > $size[1]) 
					$biggestSide = $size[0]; //find biggest length
			    else 
					$biggestSide = $size[1]; 
                     
				//The crop size will be half that of the largest side 
				$cropPercent = .5; // This will zoom in to 50% zoom (crop)
				$cropWidth   = $biggestSide*$cropPercent; 
				$cropHeight  = $biggestSide*$cropPercent; 
									 
									 
				//getting the top left coordinate
				$x = ($size[0]-$cropWidth)/2;
				$y = ($size[1]-$cropHeight)/2;
				//imagecopyresampled($thumb, $original, 0, 0,$x, $y, "60", "60", $cropWidth, $cropHeight); 
				//////////////////////////////////////////////
				
				if( $TESTING )
				{
					echo '<br/>saving...';
					echo '<br/>' . $full_thumb_filename;
					echo '<br/>' . $full_image_filename;
					echo '<br/>' . $full_fullsize_filename;
				}
				
			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 80);
					imageJPEG($image, $full_image_filename, 80);
					imageJPEG($fullsize, $full_fullsize_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					imagePNG($image, $full_image_filename);
					imagePNG($fullsize, $full_fullsize_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					imageGIF($image, $full_image_filename);
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

////////////////////////////////////////////////////////////////////////////////////////
// TO HANDLE TWO FILES at a time - SECOND IMAGE
if( isset($_FILES['image2_file']['name']) && strlen($_FILES['image2_file']['name']) > 1 )
{
	if( $TESTING )
		echo '<br/>upload: ' . $_FILES['image2_file']['name'];
	
	// check for exceeding maximum file size
	$fsize_photo   = (int)$_FILES['image2_file']['size'];

	$checks_ok = true;
	if( $fsize_photo > $input_maxsize || $_FILES['image2_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image2_file']['name'] . ') size exceeds maximum file size of ' . $input_maxsize . ' KB.</font></p>';
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
			$filename = $input_prefix . '_' . $_POST['name'] . '2_' . $date_time . '.' . $extension[1];

			$thumb2_filename 	= $filename;
			$image2_filename 	= $filename;
			$fullsize2_filename 	= $filename;

			$full_thumb_filename 	= "../" . $input_thumbfolder . $filename;
			$full_image_filename 	= "../" . $input_imagefolder . $filename;
			$full_fullsize_filename = "../" . $input_largefolder . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image2_filename . ', ' . $full_image_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( file_exists($full_image_filename) )
				$do = unlink($full_image_filename);
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
				}

				// first set max width and height
				// use for proportional thumb
				// $thumb_dims 	= calc_photo_dims(60, 60,   $size[0], $size[1]);  
				$thumb_dims		= calc_photo_dims($input_thumbsize[0], $input_thumbsize[1], $size[0], $size[1]);
				$image_dims 	= calc_photo_dims($input_imagesize[0], $input_imagesize[1], $size[0], $size[1]);
				$fullsize_dims	= calc_photo_dims($input_fullsize[0], $input_fullsize[1], $size[0], $size[1]);
				
                
				$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
				$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);

				if( $TESTING )
					echo '<br/>exten: ' . $extension[1];
				
                if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image2_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image2_file']['tmp_name']);
				
				if( $TESTING )
					echo '<br/>resampling...';
				
				// for proportional thumb use this	
                // imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
				
				//////////////////////////////////////////////
				// for square thumb use this
				if($size[0] > $size[1]) 
					$biggestSide = $size[0]; //find biggest length
			    else 
					$biggestSide = $size[1]; 
                     
				//The crop size will be half that of the largest side 
				$cropPercent = .5; // This will zoom in to 50% zoom (crop)
				$cropWidth   = $biggestSide*$cropPercent; 
				$cropHeight  = $biggestSide*$cropPercent; 
									 
									 
				//getting the top left coordinate
				$x = ($size[0]-$cropWidth)/2;
				$y = ($size[1]-$cropHeight)/2;
				imagecopyresampled($thumb, $original, 0, 0,$x, $y, "60", "60", $cropWidth, $cropHeight); 
				//////////////////////////////////////////////
				
				if( $TESTING )
					echo '<br/>saving...';

			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 80);
					imageJPEG($image, $full_image_filename, 80);
					imageJPEG($fullsize, $full_fullsize_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					imagePNG($image, $full_image_filename);
					imagePNG($fullsize, $full_fullsize_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					imageGIF($image, $full_image_filename);
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

////////////////////////////////////////////////////////////////////////////////////////
// TO HANDLE THREE FILES at a time - THIRD IMAGE
if( isset($_FILES['image3_file']['name']) && strlen($_FILES['image3_file']['name']) > 1 )
{
	if( $TESTING )
		echo '<br/>upload: ' . $_FILES['image3_file']['name'];
	
	// check for exceeding maximum file size
	$fsize_photo   = (int)$_FILES['image3_file']['size'];

	$checks_ok = true;
	if( $fsize_photo > $input_maxsize || $_FILES['image3_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image3_file']['name'] . ') size exceeds maximum file size of ' . $input_maxsize . ' KB.</font></p>';
		$checks_ok = false;
	}
	else
	{
		if( $_FILES['image3_file']['error'] > 0 )
		{
			$msg .= '<p><font color="red">An error occurred when uploading the image file  (' . $_FILES['image3_file']['name'] . ').  Error Code: ' . $_FILES['image3_file']['error'] . '</font></p>';
			$checks_ok = false;
		}
		else
		{
			// create filename
			$extension = explode('.', $_FILES['image3_file']['name']);
			$date_time = date("YmdHis");
			$filename = $input_prefix . '_' . $_POST['name'] . '3_' . $date_time . '.' . $extension[1];

			$thumb3_filename 	= $filename;
			$image3_filename 	= $filename;
			$fullsize3_filename 	= $filename;

			$full_thumb_filename 	= "../" . $input_thumbfolder . $filename;
			$full_image_filename 	= "../" . $input_imagefolder . $filename;
			$full_fullsize_filename = "../" . $input_largefolder . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image3_filename . ', ' . $full_image_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( file_exists($full_image_filename) )
				$do = unlink($full_image_filename);
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
                
				$size   = getImageSize($_FILES['image3_file']['tmp_name']);
				
				if( $TESTING )
				{
					echo '<br/>owdith: ' . $size[0];
					echo '<br/>oheight: ' . $size[1];
				}

				// first set max width and height
				// use for proportional thumb
				// $thumb_dims 	= calc_photo_dims(60, 60,   $size[0], $size[1]);  
				$thumb_dims		= calc_photo_dims($input_thumbsize[0], $input_thumbsize[1], $size[0], $size[1]);
				$image_dims 	= calc_photo_dims($input_imagesize[0], $input_imagesize[1], $size[0], $size[1]);
				$fullsize_dims	= calc_photo_dims($input_fullsize[0], $input_fullsize[1], $size[0], $size[1]);
				
                
				$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
				$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);

				if( $TESTING )
					echo '<br/>exten: ' . $extension[1];
				
                if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image3_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image3_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image3_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image3_file']['tmp_name']);
				
				if( $TESTING )
					echo '<br/>resampling...';
				
				// for proportional thumb use this	
                // imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
				
				//////////////////////////////////////////////
				// for square thumb use this
				if($size[0] > $size[1]) 
					$biggestSide = $size[0]; //find biggest length
			    else 
					$biggestSide = $size[1]; 
                     
				//The crop size will be half that of the largest side 
				$cropPercent = .5; // This will zoom in to 50% zoom (crop)
				$cropWidth   = $biggestSide*$cropPercent; 
				$cropHeight  = $biggestSide*$cropPercent; 
									 
									 
				//getting the top left coordinate
				$x = ($size[0]-$cropWidth)/2;
				$y = ($size[1]-$cropHeight)/2;
				imagecopyresampled($thumb, $original, 0, 0,$x, $y, "60", "60", $cropWidth, $cropHeight); 
				//////////////////////////////////////////////
				
				if( $TESTING )
					echo '<br/>saving...';

			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 80);
					imageJPEG($image, $full_image_filename, 80);
					imageJPEG($fullsize, $full_fullsize_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					imagePNG($image, $full_image_filename);
					imagePNG($fullsize, $full_fullsize_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					imageGIF($image, $full_image_filename);
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

////////////////////////////////////////////////////////////////////////////////////////
// TO HANDLE FOUR FILES at a time - FOURTH
if( isset($_FILES['image4_file']['name']) && strlen($_FILES['image4_file']['name']) > 1 )
{
	if( $TESTING )
		echo '<br/>upload: ' . $_FILES['image4_file']['name'];
	
	// check for exceeding maximum file size
	$fsize_photo   = (int)$_FILES['image4_file']['size'];

	$checks_ok = true;
	if( $fsize_photo > $input_maxsize || $_FILES['image4_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The image file (' . $_FILES['image4_file']['name'] . ') size exceeds maximum file size of ' . $input_maxsize . ' KB.</font></p>';
		$checks_ok = false;
	}
	else
	{
		if( $_FILES['image4_file']['error'] > 0 )
		{
			$msg .= '<p><font color="red">An error occurred when uploading the image file  (' . $_FILES['image4_file']['name'] . ').  Error Code: ' . $_FILES['image4_file']['error'] . '</font></p>';
			$checks_ok = false;
		}
		else
		{
			// create filename
			$extension = explode('.', $_FILES['image4_file']['name']);
			$date_time = date("YmdHis");
			$filename = $input_prefix . '_' . $_POST['name'] . '_' . $date_time . '.' . $extension[1];

			$thumb4_filename 	= $filename;
			$image4_filename 	= $filename;
			$fullsize4_filename 	= $filename;

			$full_thumb_filename 	= "../" . $input_thumbfolder . $filename;
			$full_image_filename 	= "../" . $input_imagefolder . $filename;
			$full_fullsize_filename = "../" . $input_largefolder . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image4_filename . ', ' . $full_image_filename;
			}

			// check if file already exists
			if( file_exists($full_thumb_filename) )
				$do = unlink($full_thumb_filename);
			if( file_exists($full_image_filename) )
				$do = unlink($full_image_filename);
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
                
				$size   = getImageSize($_FILES['image4_file']['tmp_name']);
				
				if( $TESTING )
				{
					echo '<br/>owdith: ' . $size[0];
					echo '<br/>oheight: ' . $size[1];
				}

				// first set max width and height
				// use for proportional thumb
				// $thumb_dims 	= calc_photo_dims(60, 60,   $size[0], $size[1]);  
				$thumb_dims		= calc_photo_dims($input_thumbsize[0], $input_thumbsize[1], $size[0], $size[1]);
				$image_dims 	= calc_photo_dims($input_imagesize[0], $input_imagesize[1], $size[0], $size[1]);
				$fullsize_dims	= calc_photo_dims($input_fullsize[0], $input_fullsize[1], $size[0], $size[1]);
				
                
				$thumb 		= imagecreatetruecolor($thumb_dims[0], $thumb_dims[1]);
				$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				$fullsize 	= imagecreatetruecolor($fullsize_dims[0], $fullsize_dims[1]);

				if( $TESTING )
					echo '<br/>exten: ' . $extension[1];
				
                if($extension[1] == 'png')
                    $original = imagecreatefrompng($_FILES['image4_file']['tmp_name']);
                if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
                    $original = imagecreatefromjpeg($_FILES['image4_file']['tmp_name']);
                if($extension[1] == 'gif')
                    $original = imagecreatefromgif($_FILES['image4_file']['tmp_name']);
                if($extension[1] == 'bmp')
                    $original = imagecreatefromwbmp($_FILES['image4_file']['tmp_name']);
				
				if( $TESTING )
					echo '<br/>resampling...';
				
				// for proportional thumb use this	
                // imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_dims[0], $thumb_dims[1], $size[0], $size[1]);
                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                imagecopyresampled($fullsize, $original, 0, 0, 0, 0, $fullsize_dims[0], $fullsize_dims[1], $size[0], $size[1]);
				
				//////////////////////////////////////////////
				// for square thumb use this
				if($size[0] > $size[1]) 
					$biggestSide = $size[0]; //find biggest length
			    else 
					$biggestSide = $size[1]; 
                     
				//The crop size will be half that of the largest side 
				$cropPercent = .5; // This will zoom in to 50% zoom (crop)
				$cropWidth   = $biggestSide*$cropPercent; 
				$cropHeight  = $biggestSide*$cropPercent; 
									 
									 
				//getting the top left coordinate
				$x = ($size[0]-$cropWidth)/2;
				$y = ($size[1]-$cropHeight)/2;
				imagecopyresampled($thumb, $original, 0, 0,$x, $y, "60", "60", $cropWidth, $cropHeight); 
				//////////////////////////////////////////////
				
				if( $TESTING )
					echo '<br/>saving...';

			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($thumb, $full_thumb_filename, 80);
					imageJPEG($image, $full_image_filename, 80);
					imageJPEG($fullsize, $full_fullsize_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($thumb, $full_thumb_filename);
					imagePNG($image, $full_image_filename);
					imagePNG($fullsize, $full_fullsize_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($thumb, $full_thumb_filename);
					imageGIF($image, $full_image_filename);
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