<?php
// ========================================
// query all news items for display on page
// ========================================
mysql_select_db($db_database, $db_connection);
$query_rsStaffTypes = sprintf("SELECT * FROM staff_types ORDER BY title");
//echo $query_rsStaffTypes;
$rsStaffTypes = mysql_query($query_rsStaffTypes, $db_connection) or die(mysql_error());
$row_rsStaffTypes = mysql_fetch_assoc($rsStaffTypes);
$varNumStaffTypes = mysql_num_rows($rsStaffTypes);

function getStaffTypeTitle ($staff_type_id, $db_database, $db_connection)
{
	$query_rsStaffTypes = sprintf("SELECT * FROM staff_types WHERE staff_type_id = %s", $staff_type_id);
	$rsStaffTypes = mysql_query($query_rsStaffTypes, $db_connection) or die(mysql_error());
	$row_rsStaffTypes = mysql_fetch_assoc($rsStaffTypes);
	
	return $row_rsStaffTypes['title'];
}
?>