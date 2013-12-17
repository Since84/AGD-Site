<?php
//------------------------------------------------------------------------------------------------------------------
// SKY HIGH CMS - Sky High Software Custom Content Management System - http://www.skyhighsoftware.com
// Copyright (C) 2008 - 2010 Sky High Software.  All Rights Reserved. 
// Permission to use and modify this software is for a single website installation as per written agreement.
//
// DO NOT DISTRIBUTE OR COPY this software to any additional purpose, websites, or hosting.  If the original website
// is move to new hosting, this software may also be moved to new location.
//
// IN NO EVENT SHALL SKY HIGH SOFTWARE BE LIABLE TO ANY PARTY FOR DIRECT, INDIRECT, OR INCIDENTAL DAMAGES, 
// INCLUDING LOST PROFITS, ARISING FROM USE OF THIS SOFTWARE.
//
// THIS SOFTWARE IS PROVIDED "AS IS". SKY HIGH SOFTWARE HAS NO OBLIGATION TO PROVIDE MAINTENANCE, SUPPORT, UPDATES, 
// ENHANCEMENTS, OR MODIFICATIONS BEYOND THAT SPECIFICALLY AGREED TO IN SEPARATE WRITTEN AGREEMENT.
//------------------------------------------------------------------------------------------------------------------

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