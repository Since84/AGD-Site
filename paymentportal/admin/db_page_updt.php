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

function updatePage($db_database, $db_connection)
{
		// include("db_utils.php");
		$active 		= ( $_POST['active'] == 'on' ? 1 : 0 );
		$back_button 	= ( $_POST['back_button'] == 'on' ? 1 : 0 );
		$footer		 	= ( $_POST['footer'] == 'on' ? 1 : 0 );
		$main_menu	 	= ( $_POST['main_menu'] == 'on' ? 1 : 0 );
		
		if( is_array($_POST['admin_lvls']) )
		{
			$tmp = $_POST['admin_lvls'];
			if( !(in_array("9", $tmp )) )
				array_push($tmp, "9");
			$admin_lvls = arrayToString($tmp, ",");	
		}
		else
		{
			$admin_lvls = '9';
		}		
		// handle the special characters for MySQL
		$title = convertSpecChars($_POST['title']);
		$other2 = convertSpecChars($_POST['other2']);

		// make sure permalink is clean
		$permalink = convert2Permalink($_POST['permalink']);

		// update existing item
		$updateSQL = sprintf("UPDATE pages SET last_update=%s, parent_id=%s, header_id=%s, main_menu=%s, footer=%s, left_nav_pos=%s, title=%s, sub_title=%s,  sub_nav_title=%s,  alt_landing_page=%s, admin_lvls=%s,  snippet=%s,  other=%s,  other2=%s, other3=%s, other4=%s, other5=%s, other6=%s, other7=%s,  other8=%s,  other9=%s, complete_text=%s,  image_size=%s, image_pos=%s, back_button=%s, meta_description=%s, meta_keywords=%s, meta_title=%s, permalink=%s, active=%s WHERE page_id=%s",
							  
			   "NOW()",
			   GetSQLValueString($_POST['parent_id'], "text"),
			   GetSQLValueString($_POST['header_id'], "text"),
			   GetSQLValueString($main_menu, "text"),
			   GetSQLValueString($footer, "text"),
			   GetSQLValueString($_POST['left_nav_pos'], "text"),
			   GetSQLValueString($title, "text"),
			   GetSQLValueString($_POST['sub_title'], "text"),
			   GetSQLValueString($_POST['sub_nav_title'], "text"),
			   GetSQLValueString($_POST['alt_landing_page'], "text"),
			   GetSQLValueString($admin_lvls, "text"), 
			   GetSQLValueString($_POST['snippet'], "text"), 
			   GetSQLValueString($_POST['other'], "text"), 
			   GetSQLValueString($other2, "text"), 
			   GetSQLValueString($_POST['other3'], "text"), 
			   GetSQLValueString($_POST['other4'], "text"), 
			   GetSQLValueString($_POST['other5'], "text"), 
			   GetSQLValueString($_POST['other6'], "text"), 
			   GetSQLValueString($_POST['other7'], "text"), 
			   GetSQLValueString($_POST['other8'], "text"), 
			   GetSQLValueString($_POST['other9'], "text"), 
			   GetSQLValueString($_POST['complete_text'], "text"), 
			   GetSQLValueString($_POST['image_size'], "text"), 
			   GetSQLValueString($_POST['image_pos'], "text"), 
			   GetSQLValueString($back_button, "text"), 
			   GetSQLValueString($_POST['meta_description'], "text"), 
			   GetSQLValueString($_POST['meta_keywords'], "text"), 
			   GetSQLValueString($_POST['meta_title'], "text"), 
			   GetSQLValueString($permalink, "text"), 
			   GetSQLValueString($active, "text"),
			   GetSQLValueString($_POST['page_id'], "text")
			   	);		  

		//echo '<br/>sql: ' . $updateSQL;
	
		mysql_select_db($db_database, $db_connection);
		$Result1 = mysql_query($updateSQL, $db_connection) or die(mysql_error());

}
?>