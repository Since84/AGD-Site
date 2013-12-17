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

function updateAdmin($db_database, $db_connection) 
{
	require_once("db_utils.php");


	// adding an item
	$updateSQL = sprintf("UPDATE admin SET email=%s, password=%s, admin_lvl=%s, first_name=%s, last_name=%s, update_date=%s WHERE admin_id=%s  LIMIT 1",
				GetSQLValueString($_POST['email'], "text"), 
				GetSQLValueString($_POST['password'], "text"), 
				GetSQLValueString($_POST['admin_lvl'], "text"), 
				GetSQLValueString($_POST['first_name'], "text"), 
				GetSQLValueString($_POST['last_name'], "text"), 
				   'NOW()', // update date
				GetSQLValueString($_POST['admin_id'], "text")
				   );
	 // echo '<br/>sql: ' . $updateSQL;
	
	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
		
	return $Result;
}
?>