<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$db_hostname = "h50mysql107.secureserver.net";
$db_database = "db4agcms";
$db_username = "db4agcms";
$db_password = "pw4skyhighCMS";
$db_connection = mysql_connect($db_hostname, $db_username, $db_password) or DIE("Failed to connect to database.  Contact site administrator.");
?>