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
      <td width="95" valign="top" ><div align="right">PDF</div></td>
		<td colspan="3" valign="top">
          <?php if( strlen($pdf_file) > 0 ) { ?>
          &nbsp;<a href="../<?php echo $PAGES_PDF_FOLDER . $pdf_file;?>" target="_blank"><?php echo $baseURL . '/' . $PAGES_PDF_FOLDER . $pdf_file;?></a>&nbsp;&nbsp;&nbsp;
		  <input type="submit" name="changePDF" id="changePDF" value="Replace" />
		  <input type="submit" name="removePDF" id="removePDF" value="Remove" />
          <?php }
		  else
		  {
		  ?>
		  <input type="submit" name="addPDF" id="addPDF" value="Add"/>
          <?php 
		  }
		   ?>          </td>
      </tr>