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

function updateVideo($db_database, $db_connection) 
{
	require "db_utils.php";

	// update existing item
	$updateSQL = sprintf("UPDATE videos SET display_order=%s, title=%s, other1=%s, other2=%s, other3=%s, other4=%s, last_update=%s WHERE video_id=%s  LIMIT 1",
			   // id is NULL
			     GetSQLValueString($_POST['display_order'], "text"), 
				 GetSQLValueString(addslashes($_POST['title']), "text"),
				 GetSQLValueString(addslashes($_POST['other1']), "text"), 
				 GetSQLValueString(addslashes($_POST['other2']), "text"), 
				 GetSQLValueString(addslashes($_POST['other3']), "text"), 
				 GetSQLValueString(addslashes($_POST['other4']), "text"), 
			   'NOW()',  // update_date
			   GetSQLValueString($_POST['video_id'], "text")
			   );		
			   
	//echo '<br/>sql: ' . $updateSQL;

	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	return $Result;
}
?>