<?php
// dump database table
include("../config.php");  // list of tables to dump

$day = date("D");

// create filename
$backupFolder = '../../cms_backup/' . $day . '_daily';

// delete file 
//$do = unlink($backupFile);

echo 'backing up to: ' . $backupFolder;
	
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
				//echo '<br/>' . $src . '/' . $file . ' to ' . $dst . '/' . $file;			
	            copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
} 

recurse_copy( "../../cms/", $backupFolder);
	
echo ' - completed';
?>