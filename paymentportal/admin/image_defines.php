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

$PAGES_VIDEO_FOLDER	= "cms/video/";
$PAGES_VIDEO_PREFIX	= "video";

$PAGES_PDF_FOLDER	= "cms/pdfs/";
$PAGES_PDF_PREFIX	= "pdf";

class imageDefines
{
	// default values for image types
	private $prefix			= "page";
	private $maxsize 		= 1524288;
	private $maximagesize 	= 1524288;
	private $maxthumbsize 	= 90000;	// max thumb size
	private $imagefolder  	= 'cms/def/';
	private $thumbwidth	    = 50;
	private $thumbheight     = 150;
	private $imagewidth	    = 300;
	private $imageheight     = 550;
	private $fullwidth	    = 1000; 
	private $fullheight	    = 800; 
	private $crop_thumb		= true;
	private $crop_image		= false;
	private $manual_crop 	= false;
	private $select_size 	= false;
	private $select_pos 	= false;

	// default values for page types
	private $table_name	 	= "pages";
	private $table_id	 	= "page_id";

	// constructor
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
   
    public function __construct3($page_type_id, $db_database, $db_connection) {

		mysql_select_db($db_database, $db_connection);
		
		// get image type id from page types table
		$query = sprintf("SELECT * FROM page_types WHERE page_type_id = %s", $page_type_id);
		$rs = mysql_query($query, $db_connection) or die(mysql_error());
		$row_rs = mysql_fetch_assoc($rs);
		
		$this->table_name = $row_rs['table_name'];
		$this->table_id	  = $row_rs['table_id'];
		
		// get image type record and set private class vars
		$query = sprintf("SELECT * FROM image_types WHERE image_type_id = %s", $row_rs['image_type_id']);
		$rs = mysql_query($query, $db_connection) or die(mysql_error());
		$row_rs = mysql_fetch_assoc($rs);
		if( mysql_num_rows($rs) > 0 )
		{
			$this->prefix			= $row_rs['prefix'];
			$this->maxsize 			= $row_rs['maxsize'];
			$this->maximagesize 	= $row_rs['maximagesize'];
			$this->maxthumbsize 	= $row_rs['maxthumbsize'];
			$this->imagefolder  	= $row_rs['imagefolder'];
			$this->thumbwidth	    = $row_rs['thumb_width'];
			$this->thumbheight     	= $row_rs['thumb_height'];
			$this->imagewidth	    = $row_rs['image_width'];
			$this->imageheight    	= $row_rs['image_height'];
			$this->fullwidth	    = $row_rs['full_width'];
			$this->fullheight	    = $row_rs['full_height'];
			$this->crop_thumb		= $row_rs['crop_thumb'];
			$this->crop_image		= $row_rs['crop_image'];
			$this->manual_crop 		= $row_rs['manual_crop'];
			$this->select_size 		= $row_rs['select_size'];
			$this->select_pos 		= $row_rs['select_pos'];
		}
		
	}
	
	private function getRecord($image_type_id) {
	
	}
	
    // method declaration
    public function getPrefix() {
        return $this->prefix;
    }
    public function getMaxSize() {
        return $this->maxsize;
    }
    public function getMaxImageSize() {
        return $this->maximagesize;
    }
    public function getMaxThumbSize() {
        return $this->maxthumbsize;
    }
    public function getImageFolder() {
        return $this->imagefolder;
    }
    public function getThumbWidth() {
        return $this->thumbwidth;
    }
    public function getThumbHeight() {
        return $this->thumbheight;
    }
    public function getImageWidth() {
        return $this->imagewidth;
    }
    public function getImageHeight() {
        return $this->imageheight;
    }
    public function getFullWidth() {
        return $this->fullwidth;
    }
    public function getFullHeight() {
        return $this->fullheight;
    }
    public function isCropThumb() {
		return ($this->crop_thumb == 1 ? true : false);
    }
    public function isCropImage() {
		return ($this->crop_image == 1 ? true : false);
    }
    public function isManualCrop() {
		return ($this->manual_crop == 1 ? true : false);
    }
    public function selectSize() {
		return ($this->select_size == 1 ? true : false);
    }
    public function selectPosition() {
		return ($this->select_pos == 1 ? true : false);
    }
    public function getTableName() {
		return $this->table_name;
    }
    public function getTableID() {
		return $this->table_id;
    }
}

?>