<?php
function updateStaff($db_database, $db_connection) 
{
	require "db_utils.php";
	$active 		= ( $_POST['active'] == 'on' ? 1 : 0 );

	// update existing item
	$updateSQL = sprintf("UPDATE staff SET sort_by=%s, active=%s, first_name=%s, middle_name=%s, last_name=%s, title=%s, phone=%s, email=%s, short_desc=%s, description=%s, desc_2=%s, desc_3=%s, desc_4=%s, desc_5=%s, table_1=%s, table_2=%s, other_1=%s, last_update=%s WHERE staff_id=%s  LIMIT 1",
			   // id is NULL
			   GetSQLValueString($_POST['sort_by'], "text"), 
			   GetSQLValueString($active, "text"), 
			   GetSQLValueString($_POST['first_name'], "text"),
			   GetSQLValueString($_POST['middle_name'], "text"), 
			   GetSQLValueString($_POST['last_name'], "text"), 
			   GetSQLValueString($_POST['title'], "text"), 
			   GetSQLValueString($_POST['phone'], "text"), 
			   GetSQLValueString($_POST['email'], "text"), 
			   GetSQLValueString(addslashes($_POST['short_desc']), "text"), 
			   GetSQLValueString(addslashes($_POST['description']), "text"), 
			   GetSQLValueString(addslashes($_POST['desc_2']), "text"),
			   GetSQLValueString(addslashes($_POST['desc_3']), "text"),
			   GetSQLValueString(addslashes($_POST['desc_4']), "text"),
			   GetSQLValueString(addslashes($_POST['desc_5']), "text"),
			   GetSQLValueString($_POST['table_1'], "text"),
			   GetSQLValueString($_POST['table_2'], "text"),
			   GetSQLValueString($_POST['other_1'], "text"),
			   'NOW()',  // update_date
			   GetSQLValueString($_POST['staff_id'], "text")
			   );		
			   
	//echo '<br/>sql: ' . $updateSQL;

	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	return $Result;
}
?>