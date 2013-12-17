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

function getPhotoHTML($picture, $max_width, $max_height, $border=0, $alt="", $style="")
{
	$DEBUGGING = false;
	
	$html = '';
 	if( strlen($picture) > 1 ) 
    {
		if( $DEBUGGING )
			echo 'pic: ' . $picture;
			
  		if ( 1 ) // file_exists ($picture) )
		{		
		
			if( $DEBUGGING )
				echo 'exists: ' . $picture;
							
			// resize if picture is too large
			$size   = getImageSize($picture);
			$width  = $size[0];
  			$height = $size[1];
			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;
			if ( ($width <= $max_width) && ($height <= $max_height) ) 
			{
				$tn_width = $width;
				$tn_height = $height;
			}
			else if (($x_ratio * $height) < $max_height) 
			{
				$tn_height = ceil($x_ratio * $height);
				$tn_width = $max_width;
			}
			else 
			{
				$tn_width = ceil($y_ratio * $width);
				$tn_height = $max_height;
			}
			
			$html = '<img src="' . $picture . '" width="' . $tn_width . '" height="' . $tn_height . '" alt="' . $alt . '" border="' . $border . '"';
			if( strlen($style) > 0 )
				$html .= 'style="' . $style . '"';
			$html .= ' >';
		}
	}
	
	return $html;
}

function getPhotoResizeSize($picture, $max_width, $max_height)
{
	$DEBUGGING = false;
	
	$html = '';
 	if( strlen($picture) > 1 ) 
    {
		if( $DEBUGGING )
			echo 'pic: ' . $picture;
			
  		if ( 1 ) // file_exists ($picture) )
		{		
		
			if( $DEBUGGING )
				echo 'exists: ' . $picture;
							
			// resize if picture is too large
			$size   = getImageSize($picture);
			$width  = $size[0];
  			$height = $size[1];
			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;
			if ( ($width <= $max_width) && ($height <= $max_height) ) 
			{
				$tn_width = $width;
				$tn_height = $height;
			}
			else if (($x_ratio * $height) < $max_height) 
			{
				$tn_height = ceil($x_ratio * $height);
				$tn_width = $max_width;
			}
			else 
			{
				$tn_width = ceil($y_ratio * $width);
				$tn_height = $max_height;
			}
			
			$photo_size = array($tn_width, $tn_height);
		}
	}
	
	return $photo_size;
}
?>