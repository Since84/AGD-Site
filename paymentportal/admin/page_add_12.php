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
  <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;CONTACT INFORMATION</td></tr>
  
       <tr>
	  	<td valign="top" ><div align="right">Page Title</div></td>
		<td colspan="2"><input name="sub_title" type="text" id="sub_title" size="50" maxlength="100" value="<?php echo $sub_title; ?>"/></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Phone</div></td>
		<td colspan="2"><input name="other5" type="text" id="other5" size="50" maxlength="100" value="<?php echo $other5; ?>"/></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Fax</div></td>
		<td colspan="2"><input name="other7" type="text" id="other7" size="50" maxlength="100" value="<?php echo $other7; ?>"/></td>
      </tr>
       <tr>
	  	<td valign="top" ><div align="right">Email</div></td>
		<td colspan="2"><input name="other6" type="text" id="other6" size="50" maxlength="100" value="<?php echo $other6; ?>"/></td>
      </tr>
      <tr>
	  	<td valign="top" ><div align="right">Address</div></td>
		<td colspan="2">
        <?php 
		  
		$oFCKeditor = new FCKeditor('snippet') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $snippet;
		$oFCKeditor->ToolbarSet = $EDITOR_TOOLBAR;
		$oFCKeditor->Height = 140;
		$oFCKeditor->Create() ;
		
		?>
        
        </td>
	</tr>
       <tr>
	  	<td valign="top" ><div align="right">OTHER</div></td>
		<td colspan="2"><input name="other8" type="text" id="other8" size="50" maxlength="100" value="<?php echo $other8; ?>"/></td>
      </tr>
	
    <?php if ( 0 ) { ?>
     <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;CONTACT CATEGORIES</td></tr>

     <tr>
	  	<td valign="top" ><div align="right">separate areas using semi-colons (;)</div></td>
		<td colspan="2">
          <textarea name="other" cols="50" rows="4" id="other"><?php echo $other; ?></textarea>
        </td>
      </tr>
      <?php } ?>
      
     <?php include("page_edit_image_inc.php"); ?>
      
      
	  <tr><td colspan="3" height="20" class="pageEditBars">&nbsp;&nbsp;OTHER</td></tr>
      <tr>
	  	<td valign="top" ><div align="right">Portfolio Submissions</div></td>
		<td colspan="2">
        <?php 
		  
		$oFCKeditor = new FCKeditor('other2') ;
		$oFCKeditor->BasePath = 'fckeditor/'; // is the default value.
		$oFCKeditor->Value		= $other2;
		$oFCKeditor->ToolbarSet = htmlspecialchars('Basic');
		$oFCKeditor->Height = 80;
		$oFCKeditor->Create() ;
		
		?>
        </td>
      </tr>
      
            <tr>
	  	<td valign="top" ><div align="right">Google Map<br/>Embed<br/>size 250x250</div></td>
		<td colspan="2">
          <textarea name="other3" cols="50" rows="3" id="other3"><?php echo $other3; ?></textarea>
        </td>
      </tr>
            <tr>
	  	<td valign="top" ><div align="right">Google Directions<br/>Link</div></td>
		<td colspan="2">
		  <textarea name="other4" cols="50" rows="3" id="other4"><?php echo $other4; ?></textarea>
        </td>
      </tr>