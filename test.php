<?php    
 $fd = fopen("diagnostic.xml","r"); 
 $myXML = fread($fd,filesize("diagnostic.xml")); 
 fclose($fd);     
 $docTree = xmltree($myXML);
 echo("<html><title>test</title><body>");     
 echo("<h1>Vivian's test for xml dom for PHP</h1>");     
 print("<pre>");     
 print_r( $docTree ); 
 print( "</pre>" );    
 echo("</body></html>"); 
?>  