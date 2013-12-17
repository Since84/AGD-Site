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

function displaySubPages($parent_id, $lvl, $db_database, $db_connection)
{
		include("config.php");
		
		$indent_spaces = '';
		$num = $lvl * 6;
		for( $i=0; $i < $num; $i++ )
			$indent_spaces .= '&nbsp;';
			
		//echo '<br/>parent id: ' . $parent_id . ' lvl ' . $lvl;
		
		//////////////////////////////////////////
		// get sub pages based on parent id
		include("db_pages_sub_get_all.php");

  		if( $varNumSubPages > 0 )
		{
			do {
			
			  	$admin_lvls = explode(",", $row_rsSubPages['admin_lvls']);
				if( in_array( $_SESSION['AdminLevel'], $admin_lvls ) ) 
				{
				  ?>
					<form id="form<?php echo $row_rsSubPages['page_id']; ?>" name="form<?php echo $row_rsSubPages['page_id']; ?>" method="post" action="<?php echo getEditPage($row_rsSubPages['page_type_id'], $db_database, $db_connection); ?>">
					<input type="hidden" name="page_id" value="<?php echo $row_rsSubPages['page_id']; ?>">
					<input type="hidden" name="page_type_id" value="<?php echo $row_rsSubPages['page_type_id']; ?>">
					<input type="hidden" name="title" value="<?php echo $row_rsSubPages['title']; ?>">
					<input type="hidden" name="page_title" value="<?php echo $row_rsSubPages['title']; ?>">
				  <tr>
					<td valign="top" class="tableFields"><?php echo $indent_spaces . $row_rsSubPages['title'];?>
					<?php if(  $_SESSION['AdminLevel'] == 9 ) echo ' (' . $row_rsSubPages['page_id'] . ' / ' . $row_rsSubPages['admin_lvls'] . ')'; ?>&nbsp;&nbsp;&nbsp;&nbsp;	 </td>
					<td valign="top" class="tableFields"><?php echo $row_rsSubPages['left_nav_pos']; ?>	</td>
                    <td valign="top" class="tableFields"><?php if( $row_rsSubPages['active'] < 1 ) echo 'No'; ?>	</td>
                   <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
					<td valign="top" class="tableFields">
					<?php 
					$disp_page =  getDisplayPage($row_rsSubPages['page_id'], $db_database, $db_connection);
					echo '<a href="' . $baseURL . '/' . $disp_page . '" target="_blank">';
					if(  $_SESSION['AdminLevel'] == 9 ) 
						echo $disp_page . '&nbsp;&nbsp;'; 
					else
						echo 'Preview '; 
					echo '</a>';
					?>&nbsp;&nbsp;
					</td>
					<?php } ?>
					 <td valign="top" class="tableFields"><?php echo getPageTypeTitle($row_rsSubPages['page_type_id'], $db_database, $db_connection); ?>	</td>
                    <td valign="top" class="tableFields"><?php if( $row_rsSubPages['main_menu'] == 1 ) echo 'Yes'; ?>	</td>
                   <td valign="top" class="tableFields"><?php if( $row_rsSubPages['footer'] == 1 ) echo 'Yes'; ?>	</td>
					
					<td valign="top" class="tableFields"><?php echo $row_rsSubPages['last_update']; ?>	</td>
					<td valign="top" class="tableFields"><input name="Update" type="submit" id="Update" value="Edit" />
					 <input name="Delete" type="submit" id="Delete" value="Delete" /> 
					 </td>
				  </tr>
						</form>
						<?php
						//////////////////////////////////////////
						// get sub pages based on parent id
						//echo '** calling sub sub: ' . $row_rsSubPages['page_id'] . '(' . $row_rsSubPages['parent_id'] . ')';
  						displaySubPages($row_rsSubPages['page_id'], ($lvl + 1 ), $db_database, $db_connection);
		
				}  // end sub admin check
			} while($row_rsSubPages = mysql_fetch_assoc($rsSubPages));
			
			
		
		} // end subs
}	
?>