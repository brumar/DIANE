<?php
// scinde la phrase grâce aux virgules et espacements
// ce qui inclus les " ", \r, \t, \n et \f

$text2 = "dans la famille dubois, il y 5 personnes. quand les Dubois vont manger en forêt avec les Lambert, il sont 12 au pique-nique. combien sont-il dans la famille Lambert?";
$chaine ="";
$tabMot = preg_split ("/[,]+/", $text2);
for ($i=0; $i < sizeof($tabMot);$i++)
{
//print $tabMot[$i];
$chaine = $chaine.$tabMot[$i];
if ($i != sizeof($tabMot)-1)
{
//print " , ";
$chaine = $chaine." , ";
}
}
print $chaine;

print "<br><br><br><br>" ;
for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
  {
  print $piece." ";

  if(ereg("/[\s,.,-]+/",$piece))
  {
     print "espace";//strlen($piece);
  }
}

 $c ="";
 $c1 ="";
print "<br><br>";
$string = "Ceci est,    un exemple\ninteressant";
/* Utilisez aussi les nouvelles lignes et les tabulations comme s&eacute;parateur de mots */
  $tok = strtok($string," \n    ");
  while ($tok) {
    $Mot = $tok." ";
    $c =$c.$Mot;
    $tok = strtok("\n    ");
 }
 print $c."<br>";
 


?>
