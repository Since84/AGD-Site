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

function getDisclaimer($db_database, $db_connection)
{
	mysql_select_db($db_database, $db_connection);
	$query_rs = sprintf("SELECT * FROM pages WHERE page_id = 82 ");
	$rs = mysql_query($query_rs, $db_connection) or die(mysql_error());
	$row_rs = mysql_fetch_assoc($rs);
	
	return ($row_rs['complete_text']);	
}
function gen_path($page_id, &$page_path, $db_database, $db_connection)
{
	mysql_select_db($db_database, $db_connection);
	$query_rs = sprintf("SELECT * FROM pages WHERE page_id = %s ", $page_id);
	$rs = mysql_query($query_rs, $db_connection) or die(mysql_error());
	$row_rs = mysql_fetch_assoc($rs);
	
	if( $row_rs['parent_id'] > 0 )
		gen_path($row_rs['parent_id'], $page_path, $db_database, $db_connection);
		
	array_push($page_path, $row_rs['page_id']);
}


function getPageTitle( $page_id, $db_database, $db_connection)
{
	mysql_select_db($db_database, $db_connection);
	$query_rsPages = sprintf("SELECT * FROM pages WHERE page_id = %s", $page_id);
	$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
	$row_rsPages = mysql_fetch_assoc($rsPages);
	
	return ($row_rsPages['title']);
}
function getCampusName( $campus_id, $db_database, $db_connection)
{
	mysql_select_db($db_database, $db_connection);
	$query_rsPages = sprintf("SELECT * FROM campus WHERE campus_id = %s", $campus_id);
	$rsPages = mysql_query($query_rsPages, $db_connection) or die(mysql_error());
	$row_rsPages = mysql_fetch_assoc($rsPages);
	
	return ($row_rsPages['name']);
}
function stripNewline($text)
{
	$newlines = array("<br/>", "<br>", "<p>", "</p>" );
	return str_replace($newlines," ", $text);
}
?>