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

function updateCampus($db_database, $db_connection) 
{
	require "db_utils.php";
	$show_on_events 		= ( $_POST['show_on_events'] == 'on' ? 1 : 0 );

	// update existing item
	$updateSQL = sprintf("UPDATE campus SET name=%s, show_on_events=%s WHERE campus_id=%s  LIMIT 1",
			   // id is NULL
			   GetSQLValueString($_POST['name'], "text"),
			    GetSQLValueString($show_on_events, "text"), 
			   GetSQLValueString($_POST['campus_id'], "text")
			   );		
			   
	//echo '<br/>sql: ' . $updateSQL;

	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	return $Result;
}
?>