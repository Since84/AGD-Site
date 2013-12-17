<?php
function addStaff($image_filename, $db_database, $db_connection) 
{
	require "db_utils.php";
	$active 		= ( $_POST['active'] == 'on' ? 1 : 0 );

	// adding an item
	$updateSQL = sprintf("INSERT INTO staff VALUE (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				   // id is NULL
				   GetSQLValueString($_POST['page_id'], "text"),
				   GetSQLValueString($_POST['sortby'], "text"), 
				   GetSQLValueString($active, "text"), 
				   GetSQLValueString($_POST['first_name'], "text"),
				   GetSQLValueString($_POST['middle_name'], "text"),
				   GetSQLValueString($_POST['last_name'], "text"), 
				   GetSQLValueString($_POST['title'], "text"), 
				   GetSQLValueString($_POST['phone'], "text"),  
				   GetSQLValueString($_POST['email'], "text"), 
				   GetSQLValueString(addslashes($_POST['short_desc']), "text"), 
				   GetSQLValueString(addslashes($_POST['description']), "text"), // description
				   GetSQLValueString(addslashes($_POST['desc_2']), "text"),
				   GetSQLValueString(addslashes($_POST['desc_3']), "text"),
				   GetSQLValueString(addslashes($_POST['desc_4']), "text"),
				   GetSQLValueString(addslashes($_POST['desc_5']), "text"),
				   GetSQLValueString($_POST['table_1'], "text"),
				   GetSQLValueString($_POST['table_2'], "text"),
				   GetSQLValueString($_POST['other_1'], "text"),
				   GetSQLValueString($image_filename, "text"),	// mid
				   'NOW()', // create_date
				   'NOW()'  // update_date
				   );
	//echo '<br/>sql: ' . $updateSQL;
	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	// get product id that was just added and adding default shipping options
	$people_id = mysql_insert_id();
	return $people_id;
}
?>