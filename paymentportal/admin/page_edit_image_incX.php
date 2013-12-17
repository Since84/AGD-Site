<?php // page type 5 ?>
  <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;IMAGE</td></tr>
  
      <tr>
	  	<td width="95" valign="top" ><div align="right">Main</div></td>
		<td colspan="2">
        <!--image stuff -->
        <table cellpadding="0" cellspacing="0" border="0">
        <?php if( strlen($image_file) > 0 ) { ?>
        <tr>
        <td valign="top">
            <table cellpadding="0" cellspacing="0" border="0">
            <tr><td valign="top">
	            <img src="../<?php echo $imageDef->getImageFolder() . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
            </td>
            <td valign="top">
            	<input type="submit" name="ImageReplace" id="ImageReplace" value="Replace" style="margin-bottom:2px;" /><br/>
              	<input type="submit" name="ImageRemove" id="ImageRemove" value="Remove"  style="margin-bottom:2px;" /><br/>          
              	<input type="submit" name="ImageCrop" id="ImageCrop" value="Re-Crop Image"  style="margin-bottom:2px;" />
            </td>
            </tr>
            </table>
		</td>
        </tr>
        <tr>
        <td>Thumbnail</td>
        </tr>
        <tr>
        <td>
        <img src="../<?php echo $imageDef->getImageFolder() . 'thumbs/' . $image_file; ?>" border="1" style="float:left; margin-right:20px;" />
         <input type="submit" name="ThumbCrop" id="ThumbCrop" value="Re-Crop Thumbnail"  style="margin-bottom:2px;" />
       
        </td>
       	</tr>
                  
         <?php } else { ?>
         <tr>
		<td colspan="2">
         <input type="submit" name="ImageAdd" id="ImageAdd" value="Add"/>
         </td>
         </tr>
         <?php } ?>  
          
          </table> 
          </td>
       </tr>
       
       <?php if( $imageDef->selectSize() ) { ?>
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
      	<td><div align="right">Note</div></td>
      	<td colspan="2" valign="top">
        Refresh page to see correct version of newly cropped thumbnail.
        </td>
        </tr>
       <tr>
       	<td></td>
       	<td colspan="2" height="20">
        <hr size="1" color="#eeeeee" />
        </td>
       </tr>