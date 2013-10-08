<?php 
if (strpos($_SERVER['HTTP_HOST'], 'agdesigngroup.dev') !== false) {
	$abspath = '/Users/damonhastings/AGD/AGD Site/'; 
} else if (strpos($_SERVER['HTTP_HOST'], 'agdesigngroup.com') !== false) {
	$abspath = '/var/www/vhosts/agdesigngroup.com/httpdocs/dev/'; 
}
?>