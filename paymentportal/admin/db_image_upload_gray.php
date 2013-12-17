<?php
require_once("db_image_calc_dim.php");

$TESTING = false;

// input defines
//	$input_maxsize 			= 8000000;
//	$input_maximagesize 	= 8000000;
//	$input_imagefolder  	= $folder;
//	$input_grayfolder  		= $folder . 'gray/';
//	$input_largefolder  	= $folder . 'fullsize/';
//	$input_imagesize	    = array("250","250"); 	// w , h
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

			$gray_filename 		= $filename;
			$image_filename 	= $filename;

			$full_gray_filename 	= "../" . $input_grayfolder . $filename;
			$full_image_filename 	= "../" . $input_imagefolder . $filename;

			if( $TESTING )
			{
				echo '<br/>full_image_filename: ' . $image_filename . ', ' . $full_image_filename;
			}

			// check if file already exists
			if( file_exists($full_gray_filename) )
				$do = unlink($full_gray_filename);
			if( file_exists($full_image_filename) )
				$do = unlink($full_image_filename);

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
				// use for proportional gray
				// $gray_dims 	= calc_photo_dims(60, 60,   $size[0], $size[1]);  
				$image_dims 	= calc_photo_dims($input_imagesize[0], $input_imagesize[1], $size[0], $size[1]);
				
                
				$gray 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				$image 		= imagecreatetruecolor($image_dims[0], $image_dims[1]);
				
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
				
				// for proportional gray use this	
                imagecopyresampled($gray, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                imagecopyresampled($image, $original, 0, 0, 0, 0, $image_dims[0], $image_dims[1], $size[0], $size[1]);
                
				/////////////////////////////////////////////////////////////////////////////
				// create gray scale image				
				if (imageistruecolor($gray)) {
					imagetruecolortopalette($gray, false, 256);
				}
			
				for ($c = 0; $c < imagecolorstotal($gray); $c++) {
					$col = imagecolorsforindex($gray, $c);
					$grays = round(0.299 * $col['red'] + 0.587 * $col['green'] + 0.114 * $col['blue']);
					imagecolorset($gray, $c, $grays, $grays, $grays);
				}
				///////////////////////////////////////////////////////////////	
				
						
				
				if( $TESTING )
				{
					echo '<br/>saving...';
					echo '<br/>' . $full_gray_filename;
					echo '<br/>' . $full_image_filename;
				}
				
			  	// Save JPEG
				if($extension[1] == 'jpg' || $extension[1] == 'jpeg')
				{
					imageJPEG($gray, $full_gray_filename, 80);
					imageJPEG($image, $full_image_filename, 80);
				}
				// Save PNG
				elseif($extension[1] == 'png')
				{
					imagePNG($gray, $full_gray_filename);
					imagePNG($image, $full_image_filename);
				}
				// Save GIF
				elseif($extension[1] == 'gif')
				{
					imageGIF($gray, $full_gray_filename);
					imageGIF($image, $full_image_filename);
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