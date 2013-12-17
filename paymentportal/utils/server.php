<?php
function secureConnection()
{
	if (isSet($_SERVER['HTTPS']))
		return (0 == strcmp(strtolower($_SERVER['HTTPS']), 'on')) ? TRUE : FALSE;
	else
		return FALSE;
}
?>
