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
  <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE (.jpg only)</td></tr>
  
	<tr>
    <td valign="top">Main Image 
     <?php if( strlen($image_file) > 0 ) { ?>
       <br/><br/>
      	<input type="submit" name="ImageReplace" id="ImageReplace" value="Replace" style="margin-bottom:2px;" /><br/>
              	<input type="submit" name="ImageRemove" id="ImageRemove" value="Remove"  style="margin-bottom:2px;" /><br/>          
              	<input type="submit" name="ImageCrop" id="ImageCrop" value="Re-Crop Image"  style="margin-bottom:2px;" />
	<?php } else { ?>
          <input type="submit" name="ImageAdd" id="ImageAdd" value="Add"/>
    	 <?php } ?>

    </td>
    <td valign="top">
    <?php if( strlen($image_file) > 0 ) { ?>
	            <img src="../<?php echo $imageDef->getImageFolder() . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <?php }?>
    </td>
    <td valign="top">
   
    </td>
    </tr>
    <tr><td colspan="3" height="12"><hr size="1" /></td></tr>
    <tr>
    <td valign="top">Thumbnail
        <?php if( strlen($image_file) > 0 ) { ?>
        <br/><br/>
     <input type="submit" name="ThumbCrop" id="ThumbCrop" value="Re-Crop Thumbnail"  style="margin-bottom:2px;" />
      <input type="submit" name="ThumbReplace" id="ThumbReplace" value="Replace Thumbnail"  style="margin-bottom:2px;" />
    	<?php } ?>
	</td>
    <td valign="top"> 
    <?php if( strlen($image_file) > 0 ) { ?>
    <img src="../<?php echo $imageDef->getImageFolder() . 'thumbs/' . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <?php } ?>
         </td>
    <td></td>
    </tr>
     <?php if( strlen($image_file) > 0 ) { ?>   
       <?php if( $imageDef->selectSize() ) { ?>
         <tr><td colspan="3" height="12"><hr size="1" /></td></tr>
       <tr>
	  	<td valign="top" ><div align="right">Use for Main Image</div></td>
		<td colspan="2">
        <input name="image_size" type="radio" value="1"  <?php if($image_size == 1) echo 'checked="checked"';?> /> Thumb <input name="image_size" type="radio" value="2" <?php if($image_size == 2) echo 'checked="checked"';?> /> Standard <input name="image_size" type="radio" value="3" <?php if($image_size == 3) echo 'checked="checked"';?> /> Large
        </td>
      </tr>
      <?php } ?>
       <?php if( $imageDef->selectPosition() ) { ?>
      <tr>
	  	<td valign="top" ><div align="right">Image Alignment</div></td>
		<td colspan="2">
        <input name="image_pos" type="radio" value="1"  <?php if($image_pos == 1) echo 'checked="checked"';?> /> Left <input name="image_pos" type="radio" value="2" <?php if($image_pos == 2) echo 'checked="checked"';?> /> Right
        </td>
      </tr>
      <?php } ?>
      <tr>
      	<td><div align="right"><span class="accentColor">Note: </span></div></td>
      	<td colspan="2" valign="top">
        <span class="accentColor">Refresh page to see correct version of newly cropped images.</span>
        </td>
        </tr>
        <?php } ?>
       