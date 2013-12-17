<?php
// dump database table
require_once('../../Connections/db.php');
include("../config.php");  // list of tables to dump

$day = date("M");

mysql_select_db($db_database, $db_connection);

// create filename
$backupFile = $day . '_' . $db_database . '.sql';

// delete file 
//$do = unlink($backupFile);

echo 'backing up to: ' . $backupFile;
	
exec("mysqldump $db_database > $backupFile -h$db_hostname -u$db_username -p$db_password");
	
echo ' - completed';
mysql_close();
?>