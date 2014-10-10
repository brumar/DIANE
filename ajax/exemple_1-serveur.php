<?php
    sleep(1);
    
    $nbr = 1;

	
    $str = @file_get_contents('exemple_1.data');
    if($str !== FALSE)
        $nbr = unserialize($str)+1;
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    echo $nbr;
    
    file_put_contents('exemple_1.data', serialize($nbr));
	
?>
