<?php
$xh = xslt_create();

$file=fopen("diagXML.xml","r");
$xml=fread($file,1638400);
fclose($file);

$file=fopen("diag.xsl","r");
$xsl=fread($file,1638400);
fclose($file);

$arguments = array(
  '/_xml' => $xml,
  '/_xsl' => $xsl
  );

$result = xslt_process($xh, 'arg:/_xml', 'arg:/_xsl', NULL, $arguments);

xslt_free($xh);

print "$result";
?>