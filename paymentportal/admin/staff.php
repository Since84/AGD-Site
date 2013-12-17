<?php 
require_once('../Connections/dbCMS.php'); 
include("config.php");
include("config_cms.php");
include("db_utils.php");
require('db_misc_functions.php');

$MM_AuthorizedLevels = "1,3,9";
require('checkaccess.php'); 

include("fckeditor/fckeditor.php") ; 


$admin_lvl = $_SESSION['AdminLevel'];
if( $admin_lvl > 1 )
	include("db_staff_get.php");	
else
	include("db_staff_get_atl.php");	

if( isset($_GET['alpha']) )
	$alpha = $_GET['alpha'];
else
	$alpha = 'ALL';
	
$alphabet = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","ALL");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $companyFROM; ?> - Admin</title>
<!-- InstanceEndEditable -->
<link href="adminstyle.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr bgcolor="#ffffff">
    <td width="992" height="80"><a href="<?php echo $baseURL; ?>"><img src="images/logo.gif" width="74" height="74" border="0" style="margin-left:20px;" /></a></td>
    <td valign="bottom" align="left">
	<div id="loginText">
	<?php
	echo 'You are logged in as: <b>'; 
	echo $_SESSION['FirstName'];
	echo '</b><br/>'; 
	?>
    </div>
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#6E0025" height="12"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="150" valign="top" bgcolor="#ededed">
	  <div id="divVert">
		<table width="100%" cellpadding="4">
        <tr>
        <td style="border-top:thin; border-top-color:#999999; border-top-style:solid"><a href="home.php">HOME</a></td>
        </tr>
       <tr>
		  <td><a href="crop_tool.php">IMAGE LIBRARY</a></td>
        </tr>
        <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
        <tr>
		  <td><a href="pages.php">MANAGE PAGES</a></td>
        </tr>
        <?php } ?>
        
        <?php if( $_SESSION['AdminLevel'] > 2 ) { ?>
        
        <tr>
		  <td><a href="admin.php">MANAGE USERS</a></td>
        </tr>
        <?php } ?>
        <tr>
          <td><a href="chgpswd.php">CHANGE&nbsp;PASSWORD</a></td>
		  </tr>
          <tr>
          <td><a href="faqs.php">FAQS</a></td>
		  </tr>
            <tr>
          <td><a href="help.php">HELP</a></td>
		  </tr>
        <tr>
          <td><a href="home.php?doLogout=true">LOGOUT</a></td>
		  </tr>
          </table>
	  </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </td>
    <td valign="top" style="padding:5px;">
    <div id="mainContent">
	<!-- InstanceBeginEditable name="mainContent" -->
   
    <span class="pagetitle">Staff Bios</span>
    <br/>
    <hr size="1" />
    <br/>
  <table width="1000" >
  
      <tr>
      	<td colspan="7">
            <table>
            <tr>
            <td>
          <form id="form0" name="form0" method="post" action="staff_add.php">
            <input type="submit" name="add" id="add" value="Add Staff" />
         </form>   
           <td>
             </td>
         </tr>
         </table>
     	</td>
        </tr>
      <tr>
      	<td colspan="7">
        
        <!-- alphebeta finder -->
        <table><tr><td class="Bold">
        <?php 
            // echo '<br/>alpha: ' . $alpha;
            
            for($i=0; $i<sizeof($alphabet); $i++)
            {
                if( $i > 0 )
                    echo '&nbsp;|&nbsp;';
                echo '<a href="' . $_SERVER['PHP_SELF'] . "?alpha=" . $alphabet[$i] . '">';
                if( $alpha == $alphabet[$i] )
                    echo '<span class="accentColor">';
                echo $alphabet[$i];
                if( $alpha == $alphabet[$i] )
                    echo '</span>';
                echo '</a>';
            }
        ?>
        </td>
        </tr>
        </table>
        <!-- end alphebeta finder -->
        
        </td>
      </tr>
      <tr>
      <td class="tableHeadings" width="100">Display Order</td>
      	<td class="tableHeadings">Name	</span>        </td>
      	<td class="tableHeadings">Active	</span>        </td>
      	<td class="tableHeadings"></span>Title       </td>
		<td class="tableHeadings"></span>Location       </td>
      	<td class="tableHeadings"></span>Alma Mater       </td>
        <td class="tableHeadings">&nbsp;</td>
      </tr>
  		 <!-- first look for sub categories -->
		 <?php          
	  	if( $varNumStaff > 0 ) 
		{
		  	do
			{
					if( $alpha == "ALL" || $alpha == strtoupper(substr($row_rsStaff['last_name'],0,1)) )
					{
		 ?>
         <tr>
             <!-- now look for any products for this category -->
            <form id="form<?php echo $row_rsStaff['staff_id']; ?>" name="form<?php echo $row_rsStaff['staff_id']; ?>" method="post" action="staff_edit.php">
      	<td  class="tableFields" ><?php echo $row_rsStaff['sort_by']; ?>        </td>
        <td  class="tableFields" >
         
         <?php echo $row_rsStaff['first_name'] . ' ' . $row_rsStaff['last_name']; ?>         </td>
        <td  class="tableFields" >
        <?php if( $row_rsStaff['active'] < 1 ) echo 'No'; ?>
       </td> 
       <td  class="tableFields" >
        <?php echo $row_rsStaff['title']; ?> 
       </td>
		<td  class="tableFields" >
        <?php echo $row_rsStaff['desc_2']; ?> 
       </td>
        <td  class="tableFields" >
        <?php if( $row_rsStaff['desc_3'] > 0 ) echo getCampusName( $row_rsStaff['desc_3'], $db_database, $db_connection); ?> 
       </td>
		<td width="150" class="tableFields" >
        <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
        <input type="hidden" name="page_title" value="<?php echo $page_title; ?>" />
         <input type="hidden" name="staff_id" value="<?php echo $row_rsStaff['staff_id']; ?>">
          <input name="Update" type="submit" id="Update" value="Edit" />
          <input name="Delete" type="submit" id="Delete" value="Delete" />    </td>
        </form>
        </tr>
    <?php  
				}
           } while ($row_rsStaff = mysql_fetch_assoc($rsStaff));
        }  
  ?>    
      </table>
  <br/>
<!-- InstanceEndEditable -->
    </div>
    </td>
  </tr>
   <tr valign="top">
    <td height="1" colspan="2" bgcolor="#ededed"></td>
  </tr>
  <tr valign="top">
    <td height="24" colspan="2" class="Copyright">&copy; 2011 Sky High Software</td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php mysql_close(); ?>
