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
<tr>
       	<td></td>
       	<td colspan="2" height="20">
        <hr size="1" color="#eeeeee" />
        </td>
       </tr>
       <tr>
	  	<td valign="top" ><div align="right">Sub Title</div></td>
		<td colspan="2"><input name="sub_title" type="text" id="sub_title" size="50" maxlength="100" value="<?php echo $sub_title; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Featured Quote</div></td>
		<td colspan="2"><textarea name="snippet" cols="40" id="snippet"><?php echo $_POST['snippet']; ?></textarea></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Author</div></td>
		<td colspan="2"><input name="other" type="text" id="other" size="50" maxlength="100" value="<?php echo $other; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Author's Title</div></td>
		<td colspan="2"><input name="other2" type="text" id="other2" size="50" maxlength="100" value="<?php echo $other2; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">PDF</div></td>
		<td colspan="2"><input type="file" name="pdf_file" size="40"></td>
      </tr>
      
      <tr>
       	<td></td>
       	<td colspan="2" height="20">
        <hr size="1" color="#eeeeee" />
        </td>
       </tr>
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
       <tr>
       	<td></td>
       	<td colspan="2" height="20">
        <hr size="1" color="#eeeeee" />
        </td>
       </tr>