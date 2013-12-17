<?php
// dump database table
require_once('../../Connections/db.php');
include("../config.php");  // list of tables to dump

$day = date("D");

mysql_select_db($db_database, $db_connection);

echo 'restoring: ' . $backupFile;

// mysql -u root -p[root_password] [database_name] < dumpfilename.sql
$cmd = sprintf("mysql -u root -p%s %s < %s", $db_password, $db_database, "restore.sql" );	
exec($cmd);
	
echo ' - completed';
mysql_close();
?>