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

function textCount($field, $max_limit)
{
	$DEBUGGING = false;
	
	$start_html = 0;
	$len = strlen($field);
	$real_length = 0;
	
	if( $DEBUGGING )
		echo '<br/>' . $field . ' : ' . $len;
		
	$bl = 0;
	$bl_rep = 0;
	$nl = 0;
	$trunc_len = 0;
	
	for( $i=0; $i < $len; $i++)
	{
		if( substr($field, $i, 1) == '<' )
		{
			$start_html = 1;
		}
		else
		if( $start_html )
		{
			if( substr($field, $i, 1) == '>' )
				$start_html = 0;
		}
		else
		{
			if( substr($field, $i, 1) == " " )
			{
					$bl++;
					if( $blank )
						$bl_rep++;
					else
						$real_length++;
					$blank = 1;
			}
			else
			{
				$blank = 0;
				$real_length++;
			}
		}
		
		if( $real_length == $max_limit )
			$trunc_len = $i+1;
	}
	
	$ret_text = $field;
	//echo $ret_text;
	// if exceeds maximum, truncation
	if( $real_length > $max_limit )
	{
		$ret_text = substr($field, 0, $trunc_len);
		$truncated = true;
	}
	if( $DEBUGGING )
	{
		echo '<br/>';
		echo $ret_text;
		echo ', max  limit: ' . $max_limit;
		echo ', real length: ' . $real_length;
		if( $real_length > $max_limit )
			echo ', trunc len: ' . $trunc_len;
	}
	
	$ret_array = array ($truncated, $ret_text);
	return $ret_array;
}
?>