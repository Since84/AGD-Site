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


// ====================================================================================
// initialize the session, check for logout request, and check for authorized access
// ====================================================================================
if (!isset($_SESSION)) {
  session_start();
}

// -----------------------------
// check for logout request
// -----------------------------
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['AdminName'] = NULL;
  $_SESSION['AdminLevel'] = NULL;
  $_SESSION['AdminID'] = NULL;
  $_SESSION['FirstName'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['AdminName']);
  unset($_SESSION['AdminLevel']);
  unset($_SESSION['AdminID']);
  unset($_SESSION['FirstName']);
  unset($_SESSION['PrevUrl']);
  
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

// -----------------------------
// check for authorized access
// -----------------------------

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUser, $AdminLvl, $authorizedLevels="") { 

  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = false; 

  if( $authorizedLevels )
  {
	   $authLevels = explode(",", $authorizedLevels);
	   if (in_array($AdminLvl, $authLevels)) 
	       $isValid = true;
  }
  if( $AdminLvl > 0 )
    $isValid = true;
	
  return $isValid;
   
}

$MM_restrictGoTo = "index.php";
if ( !((isset($_SESSION['AdminName'])) && 
      (isAuthorized($_SESSION['AdminName'], $_SESSION['AdminLevel'], $MM_AuthorizedLevels)))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>