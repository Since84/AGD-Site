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
// utility functions
// ========================================
function convert2Permalink($str) {
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

	return $clean;
}
function strip4Javascript($str)
{
	
	
	$len = strlen(	$str );
	for( $i = 0; $i < $len; $i++ )
	{
	
		//if( !ctype_print($str[$i]) )
		//	echo '<br/>not: ' . $str[$i] . ' (' .ord($str[$i]). ')';
	
		//echo '<br/>' . $str[$i] . ': ' . ord($str[$i]);
		if( ord($str[$i]) == 13 || 
		    ord($str[$i]) == 10 )
			$skipped ++;
		else
			$fixed .= $str[$i];
	}
	//echo $fixed;
	//echo '<br/>skipped: ' . $skipped;
	return $fixed;
}
function checkPwsd($password)
{
	$upperCase = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$lowerCase = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	
	$password_ok = true;
	$min_length = 12;
	
	$pswd = trim($password);
	
	///////////////////////////////////////////
	// check if long enough (min)
	if( strlen($pswd) < $min_length )
		$password_ok = false;
		
	// check strength
	$numberFound 		= false;
	$upperCaseFound 	= false;
	$lowerCaseFound 	= false;
	for($i=0; $i<strlen($pswd); $i++)
	{
		if( in_array($pswd[$i], $upperCase, true) )
			$upperCaseFound = true;
		if( in_array($pswd[$i], $lowerCase, true) )
			$lowerCaseFound = true;
		if( is_numeric($pswd[$i]) )
			$numberFound = true;
	}
	if( !($numberFound && $upperCaseFound && $lowerCaseFound) )
		$password_ok = false;
	
	// general message if error
	$message = sprintf("Password requires at least one upper case letter, one lower case letter and one number and must be at least %s in length.",
						$min_length);
	/*
	if( !$upperCaseFound )
		$message .= ' - no upper ';
	if( !$lowerCaseFound )
		$message .= ' - no lower ';
	if( !$numberFound )
		$message .= ' - no num ';
	//echo ($password_ok ? 'password ok' : 'not ok');
	*/
	
	// return if ok and error message
	return( array($password_ok, $message) );
}

function convertSpecChars( $text_in )
{
	$text_in = str_replace("©", "&copy;", $text_in);
	$text_in = str_replace("®", "&reg;", $text_in);
	$text_in = str_replace("™", "&#8482;", $text_in);
	$text_in = str_replace("´", "&acute;", $text_in);
	$text_in = str_replace("‘", "&#8218;", $text_in);
	$text_in = str_replace("’", "&#8217;", $text_in);
	$text_in = str_replace("“", "&#8220;", $text_in);
	$text_in = str_replace("”", "&#8221;", $text_in);
		
	return $text_in;
}
function arrayToString($arrayIn, $separator=";")
{
	if( strlen(trim($arrayIn)) > 0 )
	{
		$first = true;
		$str = '';
		foreach ($arrayIn as $value) {
			if( $first )
				$first = false;
			else
				$str .= $separator;
			$str = $str . $value;
		}
	}
	else
	{
		$str = ' ';
	}	
	return $str;
}
function stripParagraphTags($text)
{
	//echo '<font color="white">';
	//echo 'before: ' . $text;
	
	$newText = $text;
	
	$text = trim($text);
	if( strlen($text) > 7 )
	{
		if( strncmp( substr($text, 0, 3), "<p>", 3 ) == 0  
			&& strncmp( substr($text, (strlen($text)-4), 4), "</p>", 4) == 0
			)
		{
			$newText = substr( $text, 3, (strlen($text)-7) );
		}
	}
	//echo 'before: ' . $text;
	//echo '</font>';
	return $newText;		
}
function stripHTMLTags($text)
{
	$openTag = false;
	
	$newText = '';
	for( $i = 0; $i < strlen($text); $i++ )
	{
		if( $text[$i] == "<" )
			$openTag = true;
		else
		if( $text[$i] == ">" )
			$openTag = false;
		else
		if( !$openTag )
			$newText .= $text[$i];
	}

	return $newText;		
}

function strtoupperSPECIAL($text)
{
	$len = strlen($text);
	
	if( strpos($text, ';') == FALSE )
	{
		return strtoupper($text);
	}
	
	$outText = '';
	$last	 = '';
	$special_on = false;
	for( $i=0; $i<$len; $i++)
	{
		// check if starting special char
		if( $text[$i] == '&' )
		{
			$special_on = true;
		}
		
		// now change to upper case if not special char
		if( $special_on && !($last == '&') )
			$outText .= $text[$i];
		else
			$outText .= strtoupper($text[$i]);
		
		// check if ending special char
		if( $text[$i] == ';' )
		{
			$special_on = false;
		}
		
		$last = $text[$i];
	}
	
	return $outText;
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function formatPrice($price)
{
  	$floorPrice = floor($price);
	$decPresent = ( $floorPrice == $price ? false : true );
	
	if( $decPresent )
		$formattedPrice = number_format($price,2);
	else
		$formattedPrice = number_format($price,0);

    return $formattedPrice;
}
?>