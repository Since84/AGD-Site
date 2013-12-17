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

function updateSpecial($db_database, $db_connection) 
{
	require_once "db_utils.php";

	// update existing item
	$updateSQL = sprintf("UPDATE specials SET title=%s, step1_title=%s, step1_sub1_title=%s, step1_sub1=%s, step1_sub2_title=%s, step1_sub2=%s, step1_sub3_title=%s, step1_sub3=%s, step1_consider=%s, 
	step2_title=%s, step2_sub1_title=%s, step2_sub1=%s, step2_sub2_title=%s, step2_sub2=%s, step2_sub3_title=%s, step2_sub3=%s, step2_consider=%s, 
	step3_title=%s, step3_sub1_title=%s, step3_sub1=%s, step3_sub2_title=%s, step3_sub2=%s, step3_sub3_title=%s, step3_sub3=%s, step3_consider=%s, 
	
	quick_links=%s, other1=%s, other2=%s, other3=%s, last_update=%s WHERE special_id=%s  LIMIT 1",
			   // id is NULL
				   // id is NULL
				   GetSQLValueString($_POST['title'], "text"),
				   
				   GetSQLValueString($_POST['step1_title'], "text"),
				   GetSQLValueString($_POST['step1_sub1_title'], "text"),  
				   GetSQLValueString($_POST['step1_sub1'], "text"),  
				   GetSQLValueString($_POST['step1_sub2_title'], "text"),  
				   GetSQLValueString($_POST['step1_sub2'], "text"),  
				   GetSQLValueString($_POST['step1_sub3_title'], "text"),  
				   GetSQLValueString($_POST['step1_sub3'], "text"),  
				   GetSQLValueString($_POST['step1_consider'], "text"),
				   
				   GetSQLValueString($_POST['step2_title'], "text"),
				   GetSQLValueString($_POST['step2_sub1_title'], "text"),  
				   GetSQLValueString($_POST['step2_sub1'], "text"),  
				   GetSQLValueString($_POST['step2_sub2_title'], "text"),  
				   GetSQLValueString($_POST['step2_sub2'], "text"),  
				   GetSQLValueString($_POST['step2_sub3_title'], "text"),  
				   GetSQLValueString($_POST['step2_sub3'], "text"),  
				   GetSQLValueString($_POST['step2_consider'], "text"),
				   
				   GetSQLValueString($_POST['step3_title'], "text"),
				   GetSQLValueString($_POST['step3_sub1_title'], "text"),  
				   GetSQLValueString($_POST['step3_sub1'], "text"),  
				   GetSQLValueString($_POST['step3_sub2_title'], "text"),  
				   GetSQLValueString($_POST['step3_sub2'], "text"),  
				   GetSQLValueString($_POST['step3_sub3_title'], "text"),  
				   GetSQLValueString($_POST['step3_sub3'], "text"),  
				   GetSQLValueString($_POST['step3_consider'], "text"),
				   
				   GetSQLValueString(addslashes($_POST['quick_links']), "text"),

   				   GetSQLValueString(addslashes($_POST['other1']), "text"),
				   GetSQLValueString(addslashes($_POST['other2']), "text"),
				   GetSQLValueString(addslashes($_POST['other3']), "text"),

 				   'NOW()',  // update_date
			   GetSQLValueString($_POST['special_id'], "text")
			   );		
			   
	//echo '<br/>sql: ' . $updateSQL;

	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	return $Result;
}
?>