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

?>
      <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE</td></tr>
      <tr>
	  	<td valign="top" ><div align="right">Image</div></td>
		<td colspan="2"><input type="file" name="image_file" size="40"></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Image Size</div></td>
		<td colspan="2">
        <input name="image_size" type="radio" value="1"  <?php if($image_size == 1) echo 'checked="checked"';?> /> Small <input name="image_size" type="radio" value="2" <?php if($image_size == 2) echo 'checked="checked"';?> /> Medium <input name="image_size" type="radio" value="3" <?php if($image_size == 3) echo 'checked="checked"';?> /> Large
        </td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Image Alignment</div></td>
		<td colspan="2">
        <input name="image_pos" type="radio" value="1"  <?php if($image_pos == 1) echo 'checked="checked"';?> /> Left <input name="image_pos" type="radio" value="2" <?php if($image_pos == 2) echo 'checked="checked"';?> /> Right
        </td>
      </tr>
