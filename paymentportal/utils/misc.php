<?php
function  badEmail($email) 
{
	if( !eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", stripslashes(trim($email))) )
	{
		return true;
	}
	return false;
}

function  formatArrayList($array) 
{
	$str = " ";
	$cnt = count($array);
	for($i=0; $i<$cnt; $i++)
	{
		$str = $str . $array[$i];
		if( $i < $cnt )
			$str = $str . ", ";
	}
	
	return $str;
}

?>