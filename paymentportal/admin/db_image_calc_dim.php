<?php 
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