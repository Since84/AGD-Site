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

if( 0 ) { ?>
      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;LOCATION</td></tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Location </strong></div></td>
		<td>
		<select name="desc_2" id="desc_2">
              <option value=""></option>
              <option value="Atlanta"<?php if($desc_7 == "Atlanta") echo ' selected="selected" '; ?>>Atlanta</option>
              <option value="San Francisco"<?php if($desc_7 == "San Francisco") echo ' selected="selected" '; ?>>San Francisco</option>
            </select>
		 </td>
	  </tr>
      <?php } ?>
       <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;ADDTIONAL INFORMATION</td></tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Signature Analysis </strong></div></td>
		<td><?php
		$oFCKeditor = new FCKeditor('desc_2') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_2;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
        
		?> </td>
	  </tr>
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>I Can't Live Without </strong></div></td>
		<td><?php
		$oFCKeditor = new FCKeditor('desc_3') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_3;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
        
		?> </td>
	  </tr>
     
      
       <tr>
	  	<td valign="top" class="Bold"><div align="right"><strong>Biggest Pet Peeve</strong></div></td>
		<td><?php
		$oFCKeditor = new FCKeditor('desc_4') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_4;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
	  </tr>
             <tr>
	  	<td valign="top" ><div align="right"><strong>Last Place I Visited</strong></div></td>
		<td><?php
		$oFCKeditor = new FCKeditor('desc_5') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_5;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
	  </tr>
       <tr>
	  	<td valign="top" ><div align="right"><strong>I'm Currently Reading</strong></div></td>
		<td><?php 
		$oFCKeditor = new FCKeditor('desc_6') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;	// '/fckeditor/' is the default value.
		$oFCKeditor->Value		= $desc_6;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 200;
		$oFCKeditor->Width = 600;
		$oFCKeditor->Create() ;
		?>   </td>
	  </tr>
      <?php if( 0 ) { ?>
      <tr>
	  	<td valign="top" ><div align="right"><strong>Industry Experience<br/>
	  	</strong><small>Enter industries separated by semi-colons</small></div></td>
		<td>
		<textarea name="table_1" id="table_1" cols="60" rows="3"><?php echo $table_1; ?></textarea>
		</td>
      </tr>
             <tr>
	  	<td valign="top" ><div align="right"><strong>Area  Expertise<br/>
	  	</strong><small>Enter areas separated by semi-colons</small></div></td>
		<td>
		<textarea name="table_2" id="table_2" cols="60" rows="3"><?php echo $table_2; ?></textarea>
	   </td>
      </tr>
      <?php } ?>