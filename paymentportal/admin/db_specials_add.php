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

function addSpecial($db_database, $db_connection, $image1_filename, $image2_filename, $image3_filename) 
{
	require "db_utils.php";

	// adding an item
	$updateSQL = sprintf("INSERT INTO specials VALUE (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
				   // id is NULL
				   GetSQLValueString($_POST['page_id'], "text"),
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

 				   GetSQLValueString($image1_filename, "text"),
  				   GetSQLValueString($image2_filename, "text"),
  				   GetSQLValueString($image3_filename, "text"),

				   'NOW()', // last udpate
				   'NOW()'  // create date
				   );
	//echo '<br/>sql: ' . $updateSQL;
	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());
	
	// get product id that was just added and adding default shipping options
	$people_id = mysql_insert_id();
	return $people_id;
}
?>