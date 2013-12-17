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

function calc_photo_dims($max_width, $max_height, $act_width, $act_height)
{
	$x_ratio = $max_width / $act_width;
	$y_ratio = $max_height / $act_height;
	if ( ($act_width <= $max_width) && ($act_height <= $max_height) ) 
	{
		$calc_dims[0]= $act_width;
		$calc_dims[1] = $act_height;
	}
	else if (($x_ratio * $act_height) < $max_height) 
	{
		$calc_dims[1] = ceil($x_ratio * $act_height);
		$calc_dims[0] = $max_width;
	}
	else 
	{
		$calc_dims[0] = ceil($y_ratio * $act_width);
		$calc_dims[1] = $max_height;
	}
	
	return $calc_dims;
}
?>