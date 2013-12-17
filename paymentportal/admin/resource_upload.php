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

// print_r($_FILES);

$TESTING = false;

// the following variable must be set by file including this routine

//$max_pdf_size = 3000000;
//$pdf_folder   = "membersOnly/docs";
//$pdf_prefix   = 'res_';

////////////////////////////////////////////////////////////////////////////////////////
// upload a file and return file name
$upload_ok = false;
if( isset($_FILES['resource_file']['name']) && strlen($_FILES['resource_file']['name']) > 1 )
{
	if( $TESTING )
	{
		echo '<br/>upload: ' . $_FILES['resource_file']['name'];
		echo 'max pdf size: ' . $max_pdf_size;
		echo ', pdf folder: ' . $pdf_folder;
		echo ', pdf pref: ' . $pdf_prefix;
	}
	
	// check for exceeding maximum file size
	$fsize_pdf   = (int)$_FILES['resource_file']['size'];

	$checks_ok = true;
	if( $fsize_pdf > $max_pdf_size || $_FILES['resource_file']['error'] == 2 )
	{
			$msg .= '<p><font color="red">The file (' . $_FILES['resource_file']['name'] . ') size exceeds maximum file size of ' . $max_pdf_size . ' KB.</font></p>';
		$checks_ok = false;
	}
	else
	{
		if( $_FILES['resource_file']['error'] > 0 )
		{
			$msg .= '<p><font color="red">An error occurred when uploading the file  (' . $_FILES['resource_file']['name'] . ').  Error Code: ' . $_FILES['resource_file']['error'] . '</font></p>';
			$checks_ok = false;
		}
		else
		{
			// create filename
			$extension = explode('.', $_FILES['resource_file']['name']);
			//$filename_pdf = $_FILES['resource_file']['name'];
			$date_time = date("YmdHis");
			$filename_pdf = $date_time . '.' . $extension[1];
			$db_filename_pdf = $pdf_prefix . $filename_pdf;
			$full_filename_pdf = $pdf_folder . '/' . $pdf_prefix . $filename_pdf;

			if( $TESTING )
			{
				echo '<br/>pdf: ' . $filename_pdf . ', ' . $full_filename_pdf;
			}

			// check if file already exists
			if( file_exists($full_filename_pdf) )
			{
				// now delete actual files
				$do = unlink($full_filename_pdf);
				if($do!="1")
					$msg .= '<p></br><font color="red">There was an error trying to delete the file: ' . $full_filename_pdf . '</font></p>'; 
			}

			// move the thumbnail file over
			if(!(move_uploaded_file($_FILES['resource_file']['tmp_name'], $full_filename_pdf)))
			{
				$msg .= '<p><font color="red">The file could not be moved.</font></p>';
			}
			else
			{
				$upload_ok = true;
			}
		}
	}
}

// 
// upload error codes ($_FILES['file']['error']
//
// UPLOAD_ERR_OK
// Value: 0; There is no error, the file uploaded with success. 
//
// UPLOAD_ERR_INI_SIZE
// Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini. 
//
// UPLOAD_ERR_FORM_SIZE
// Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. 
//
// UPLOAD_ERR_PARTIAL
// Value: 3; The uploaded file was only partially uploaded. 
// 
// UPLOAD_ERR_NO_FILE
// Value: 4; No file was uploaded. 
// 
// UPLOAD_ERR_NO_TMP_DIR
// Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3. 
// 
// UPLOAD_ERR_CANT_WRITE
// Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0. 
// 
// UPLOAD_ERR_EXTENSION
// Value: 8; File upload stopped by extension. Introduced in PHP 5.2.0. 
// 
// Note: These became PHP constants in PHP 4.3.0.
// 
// ========================================

?>