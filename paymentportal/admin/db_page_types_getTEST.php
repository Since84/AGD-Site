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

// ========================================
// query all news items for display on page
// ========================================
mysql_select_db($db_database, $db_connection);
$query_rsPageTypes = sprintf("SELECT * FROM page_types ORDER BY display_order");
//echo $query_rsPageTypes;
$rsPageTypes = mysql_query($query_rsPageTypes, $db_connection) or die(mysql_error());
$row_rsPageTypes = mysql_fetch_assoc($rsPageTypes);
$varNumPageTypes = mysql_num_rows($rsPageTypes);

function getPageTypeTitle ($page_type_id, $db_database, $db_connection)
{
	$query_rsPageTypes = sprintf("SELECT * FROM page_types WHERE page_type_id = %s", $page_type_id);
	$rsPageTypes = mysql_query($query_rsPageTypes, $db_connection) or die(mysql_error());
	$row_rsPageTypes = mysql_fetch_assoc($rsPageTypes);
	
	return $row_rsPageTypes['title'];
}
function getEditPage ($page_type_id, $db_database, $db_connection)
{
	$query_rsPageTypes = sprintf("SELECT * FROM page_types WHERE page_type_id = %s", $page_type_id);
	$rsPageTypes = mysql_query($query_rsPageTypes, $db_connection) or die(mysql_error());
	$row_rsPageTypes = mysql_fetch_assoc($rsPageTypes);
	
	return $row_rsPageTypes['edit_page'];
}
function getDisplayPage ($page_id, $db_database, $db_connection)
{
	include("config_cms.php");
	
	mysql_select_db($db_database, $db_connection);
	$query_rsPages = sprintf("SELECT * FROM pages WHERE page_id = %s", $page_id);
	//echo $query_rsPages;
	$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
	$row_rsPages = mysql_fetch_assoc($rsPages);

	if( $row_rsPages['alt_landing_page'] )
	{
		return getDisplayPage($row_rsPages['alt_landing_page'], $db_database, $db_connection);
	}
	else
	{
		$query_rsPageTypes = sprintf("SELECT * FROM page_types WHERE page_type_id = %s", $row_rsPages['page_type_id']);
		$rsPageTypes = mysql_query($query_rsPageTypes, $db_connection) or die(mysql_error());
		$row_rsPageTypes = mysql_fetch_assoc($rsPageTypes);

		if( $PERMALINKS_ON )
			return ($row_rsPages['permalink'] == NULL ? "index.php" : $row_rsPages['permalink']);
		else
			return $row_rsPageTypes['display_page'] . '?page_id=' . $page_id;
		
	}
	
}
?>