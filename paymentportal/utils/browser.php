<?php
function isFirefox(){
    static $browser;
    if(!isset($browser)){
        $temp = $_SERVER['HTTP_USER_AGENT'];
		if( stristr($temp, "Firefox") )
			$browser = true;
		else
			$browser = false;
    }
    return $browser;
}
?>
