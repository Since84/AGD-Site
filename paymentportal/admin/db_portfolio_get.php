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

mysql_select_db($db_database, $db_connection);
$query_rsPortfolio = sprintf("SELECT * FROM portfolio WHERE page_id = %s AND active = 'on' AND archive is NULL ORDER BY group_id, sort_by, title", $page_id);
//echo $query_rsPortfolio;
$rsPortfolio = mysql_query($query_rsPortfolio, $db_connection) or die(mysql_error());
$row_rsPortfolio = mysql_fetch_assoc($rsPortfolio);
$varNumPortfolios = mysql_num_rows($rsPortfolio);

?>