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

function addPage($filename_pdf, $image_filename, $db_database, $db_connection) 
{
	$today = date("Y-m-d");
	
	$tmp = $_POST['admin_lvls'];
	if( !(in_array("9", $tmp )) )
		array_push($tmp, "9");
	$admin_lvls = arrayToString($tmp, ",");
	
	if( strlen($_POST['sub_nav_title']) > 0 )
		$sub_nav_title = $_POST['sub_nav_title'];
	else
		$sub_nav_title = $_POST['title'];
	
	$active 		= ( $_POST['active'] == 'on' ? 1 : 0 );
	$back_button 	= ( $_POST['back_button'] == 'on' ? 1 : 0 );
	$footer		 	= ( $_POST['footer'] == 'on' ? 1 : 0 );
	$main_menu		= ( $_POST['main_menu'] == 'on' ? 1 : 0 );

	// create permalink
	$permalink = convert2Permalink($_POST['title']);
	
	// adding an item
	$insertSQL = sprintf("INSERT INTO `pages` ( `page_id`  , `page_type_id`  , `header_id`  , `main_menu`   , `footer`  , `parent_id`  , `left_nav_pos`  , `alt_landing_page`  , `title` , `sub_title` , `sub_nav_title` , `admin_lvls` , `snippet` ,`other` , `other2` ,`other3` , `other4` , `other5` , `other6` , `other7` , `other8` , `other9` , `complete_text` , `image_file`, `image_size`, `image_pos`, `pdf_file` , `active` , `back_button` , `meta_description` , `meta_keywords` , `meta_title` , `permalink` , `last_update`, `create_date` ) 
VALUES (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				   // id is NULL
				   GetSQLValueString($_POST['page_type_id'], "text"),
				   GetSQLValueString($_POST['header_id'], "text"),
				   GetSQLValueString($main_menu, "text"),
				   GetSQLValueString($footer, "text"),
				   GetSQLValueString($_POST['parent_id'], "text"),
				   GetSQLValueString($_POST['left_nav_pos'], "text"),
				   GetSQLValueString($_POST['alt_landing_page'], "text"),
				   GetSQLValueString($_POST['title'], "text"), 
				   GetSQLValueString($_POST['sub_title'], "text"), 
				   GetSQLValueString($sub_nav_title, "text"), 
				   GetSQLValueString($admin_lvls, "text"), 
				   GetSQLValueString($_POST['snippet'], "text"), 
				   GetSQLValueString($_POST['other'], "text"), 
				   GetSQLValueString($_POST['other2'], "text"), 
				   GetSQLValueString($_POST['other3'], "text"), 
				   GetSQLValueString($_POST['other4'], "text"), 
				   GetSQLValueString($_POST['other5'], "text"), 
				   GetSQLValueString($_POST['other6'], "text"), 
				   GetSQLValueString($_POST['other7'], "text"), 
				   GetSQLValueString($_POST['other8'], "text"), 
				   GetSQLValueString($_POST['other9'], "text"), 
				   GetSQLValueString(addslashes($_POST['complete_text']), "text"), 
				   GetSQLValueString($image_filename, "text"), 
				   GetSQLValueString($_POST['image_size'], "text"), // 1=small, 2=medium, 3=large
				   GetSQLValueString($_POST['image_pos'], "text"), 	// 1=left, 2=right
				   GetSQLValueString($filename_pdf, "text"), 
				   GetSQLValueString($active, "text"),
				   GetSQLValueString($back_button, "text"),
				   GetSQLValueString($_POST['meta_description'], "text"), 
				   GetSQLValueString($_POST['meta_keywords'], "text"), 
				   GetSQLValueString($_POST['meta_title'], "text"), 
				   GetSQLValueString($permalink, "text"), 
				   'NOW()',		// last_updated
				   GetSQLValueString($today, "text")  // create date
				   );
	//echo $insertSQL;;
	mysql_select_db($db_database, $db_connection);
	$Result1 = mysql_query($insertSQL, $db_connection) or die(mysql_error());
	
	return mysql_insert_id($db_connection);
}
?>