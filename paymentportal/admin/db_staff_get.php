<?php
mysql_select_db($db_database, $db_connection);
$query_rsStaff = sprintf("SELECT * FROM staff ORDER BY sort_by, last_name, first_name");
//echo $query_rsStaff;
$rsStaff = mysql_query($query_rsStaff, $db_connection) or die(mysql_error());
$row_rsStaff = mysql_fetch_assoc($rsStaff);
$varNumStaff = mysql_num_rows($rsStaff);

?>