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

  ///////////////////////////////////
  // used in pages.php
  if( $varNumMain > 0 )
  {
  	  //echo 'num: ' . $varNumMain . ' ';
  	  $i=0;
	  do
	  {
	  	$admin_lvls = explode(",", $row_rsPages['admin_lvls']);
		if( in_array( $_SESSION['AdminLevel'], $admin_lvls ) ) 
		{
			$i++;
  ?>
  	<form id="form<?php echo $row_rsPages['page_id']; ?>" name="form<?php echo $row_rsPages['page_id']; ?>" method="post" action="<?php echo getEditPage($row_rsPages['page_type_id'], $db_database, $db_connection); ?>">
	<input type="hidden" name="page_id" value="<?php echo $row_rsPages['page_id']; ?>">
	<input type="hidden" name="page_type_id" value="<?php echo $row_rsPages['page_type_id']; ?>">
    <input type="hidden" name="title" value="<?php echo $row_rsPages['title']; ?>">
    <input type="hidden" name="page_title" value="<?php echo $row_rsPages['title']; ?>">
  <tr>
    <td valign="top" class="tableFields"><?php echo $row_rsPages['title'];?>
    <?php 
	if(  $_SESSION['AdminLevel'] == 9 ) 
		echo ' (' . $row_rsPages['page_id'] . ' / ' . $row_rsPages['admin_lvls'] . ' / ' . $row_rsPages['page_type_id'] . ')'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
    <?php 
	if( $_SESSION['AdminLevel'] > 2 ) 
	{ 
	?>
   		<td valign="top" class="tableFields"><?php echo $row_rsPages['left_nav_pos']; ?>	</td>
    	<td valign="top" class="tableFields"><?php if( $row_rsPages['active'] < 1 ) echo 'No'; ?>	</td>
	 	<td valign="top" class="tableFields">
		<?php 
		$disp_page =  getDisplayPage($row_rsPages['page_id'], $db_database, $db_connection);
		echo '<a href="' . $baseURL . '/' . $disp_page . '" target="_blank">';
		if(  $_SESSION['AdminLevel'] == 9 ) 
			echo $disp_page . '&nbsp;&nbsp;'; 
		else
			echo 'Preview '; 
		echo '</a>';
		?>&nbsp;&nbsp;
    	</td>
    <?php 
	} 
	?>
    
	<td valign="top" class="tableFields"><?php echo getPageTypeTitle($row_rsPages['page_type_id'], $db_database, $db_connection); ?>	</td>
    <td valign="top" class="tableFields"><?php if( $row_rsPages['main_menu'] == 1 ) echo 'Yes'; ?>	</td>
    <td valign="top" class="tableFields"><?php if( $row_rsPages['footer'] == 1 ) echo 'Yes'; ?>	</td>
    
    <td valign="top" class="tableFields"><?php echo $row_rsPages['last_update']; ?>	</td>
    <td valign="top" class="tableFields">
    <?php if( $row_rsPages['page_type_id'] != 70 || $_SESSION['AdminLevel'] >= 9 ) { ?>
    <input name="Update" type="submit" id="Update" value="Edit" />
     <?php if( $row_rsPages['page_type_id'] < 90 ) { ?>
     <input name="Delete" type="submit" id="Delete" value="Delete" /> 
     <?php } ?>
     <?php 
	 } 
	 ?>
	 </td>
  </tr>
        </form>
  <?php
		//////////////////////////////////////////
		// get sub pages based on parent id
  		displaySubPages($row_rsPages['page_id'], 1, $db_database, $db_connection);
		
	
  		}  // end page admin check
		
		//echo 'test: ' . $i;
	  } while($row_rsPages = mysql_fetch_assoc($rsPages) );
	}
?>