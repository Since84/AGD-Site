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

function updateEvent($db_database, $db_connection) 
{
	require "db_utils.php";
	$active 		= ( $_POST['active'] == 'on' ? 1 : 0 );

	// update existing item
	$updateSQL = sprintf("UPDATE events SET page_id=%s, event_type=%s, event_name=%s, event_date=%s, event_time=%s, duration=%s, place=%s, description=%s, course_id=%s, event_coordinator=%s, event_cost=%s, member_cost=%s, deadline=%s, holes=%s, cart=%s, cart_cost=%s, play_type=%s, start_date=%s, end_date=%s, day_of_week=%s, deadline_day=%s, deadline_time=%s, accept_late_reg=%s, update_date=%s, spaces_avail=%s, add_info=%s, start_show=%s, stop_show=%s, active=%s WHERE event_id=%s  LIMIT 1",
			   // id is NULL
				   GetSQLValueString($_POST['page_id'], "text"),
				   GetSQLValueString($_POST['event_type'], "text"), 
				   GetSQLValueString($_POST['event_name'], "text"), 
				   GetSQLValueString($_POST['event_date'], "text"), 
				   GetSQLValueString($_POST['event_time'], "text"), 
				   GetSQLValueString($_POST['duration'], "text"), 
				   GetSQLValueString($_POST['place'], "text"), 
				   GetSQLValueString($_POST['description'], "text"), 
				   GetSQLValueString($_POST['course_id'], "text"), 
				   GetSQLValueString($_POST['event_coordinator'], "text"), 
				   GetSQLValueString($_POST['event_cost'], "text"), 
				   GetSQLValueString($_POST['member_cost'], "text"), 
				   GetSQLValueString($_POST['deadline'], "text"), 
				   GetSQLValueString($_POST['holes'], "text"), 
				   GetSQLValueString($_POST['cart'], "text"), 
				   GetSQLValueString($_POST['cart_cost'], "text"), 
				   GetSQLValueString($_POST['play_type'], "text"), 
				   GetSQLValueString($_POST['start_date'], "text"), 
				   GetSQLValueString($_POST['end_date'], "text"), 
				   GetSQLValueString($_POST['day_of_week'], "text"), 
				   GetSQLValueString($_POST['deadline_day'], "text"), 
				   GetSQLValueString($_POST['deadline_time'], "text"), 
				   GetSQLValueString($_POST['accept_late_reg'], "text"), 
				   'NOW()', // update_date
				   GetSQLValueString($_POST['spaces_avail'], "text"), 
				   GetSQLValueString($_POST['add_info'], "text"), 
				   GetSQLValueString($_POST['start_show'], "text"), 
				   GetSQLValueString($_POST['stop_show'], "text"), 
				   GetSQLValueString($active, "text"),
			   		GetSQLValueString($_POST['event_id'], "text")
			   );		
			   
	//echo '<br/>sql: ' . $updateSQL;

	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	return $Result;
}
?>