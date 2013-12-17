<?php
// dump database table
require_once('../../Connections/dbCMS.php');

$day = date("D");

mysql_select_db($db_database, $db_connection);

// create filename
$backupFile = $day . '_' . $db_username . '.sql';

// delete file 
//$do = unlink($backupFile);

echo 'backing up to: ' . $backupFile;
	
exec("mysqldump db4agcms > $backupFile -h$db_hostname -u$db_username -p$db_password");
	
echo ' - completed';
mysql_close();
?>