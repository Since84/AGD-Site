<?php
function addPDF($pdf_file, $db_database, $db_connection) 
{
	require "db_utils.php";
	
	// adding an item
	$updateSQL = sprintf("INSERT INTO pdfs VALUE (NULL, %s, %s, %s, %s, %s)",
				   // id is NULL
				   GetSQLValueString($_POST['page_id'], "text"),
				   GetSQLValueString($_POST['display_order'], "text"), 
				   GetSQLValueString(addslashes($_POST['title']), "text"),
				   GetSQLValueString($pdf_file, "text"),
				   GetSQLValueString($_POST['flipbook'], "text")
				   );
	// echo '<br/>sql: ' . $updateSQL;
	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	// get product id that was just added and adding default shipping options
	$faq_id = mysql_insert_id();
	return $faq_id;
}
?>