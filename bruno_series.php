<?php require_once("conn.php");

$Requete_SQL = "INSERT INTO serie (`nomSerie`, `commentaire`,nbExo, `exo1`, `type1`, `questi1`, `exo2`, `type2`, `questi2`, `exo3`, `type3`, `questi3`,
 `exo4`, `type4`, `questi4`, `exo5`, `type5`, `questi5`, `exo6`, `type6`, `questi6`, `exo7`, `type7`, `questi7`, 
 `exo8`, `type8`, `questi8`, `exo9`, `type9`, `questi9`, `exo10`, `type10`, `questi10`, `exo11`, `type11`, `questi11`, 
 `exo12`, `type12`, `questi12`, `exo13`, `type13`, `questi13`, `exo14`, `type14`, `questi14`, `exo15`, `type15`, `questi15`,
 `exo16`, `type16`, `questi16`, `exo17`, `type17`, `questi17`, `exo18`, `type18`, `questi18`, `questi19`, `exo19`, `type19`,
 `exo20`, `type20`, `questi20`, `exo21`, `type21`, `questi21`, `exo22`, `type22`, `questi22`, `exo23`, `type23`, `questi23`, 
 `exo24`, `type24`, `questi24`) VALUES 
 ('".$nomSerie."','".$commentaire."','".$nbExo."','".$exo1."', '".$type1."','".$questi1."' ,'".$exo2."' , '".$type2."', '".$questi2."', '".$exo3."', '".$type3."', '".$questi3."', 
 '".$exo4."', '".$type4."','".$questi4."' ,'".$exo5."' ,'".$type5."' ,'".$questi5."','".$exo6."' ,'".$type6."', '".$questi6."',
 '".$exo7."' , '".$type7."', '".$questi7."', '".$exo8."', '".$type8."', '".$questi8."', '".$exo9."', '".$type9."', '".$questi9."',
 '".$exo10."' , '".$type10."', '".$questi10."', '".$exo11."', '".$type11."', '".$questi11."','".$exo12."' , '".$type12."', '".$questi12."',
 '".$exo13."', '".$type13."', '".$questi13."', '".$exo14."', '".$type14."', '".$questi14."', '".$exo15."', '".$type15."', '".$questi15."', 
 '".$exo16."', '".$type16."', '".$questi16."', '".$exo17."', '".$type17."', '".$questi17."', '".$exo18."', '".$type18."', '".$questi18."', 
 '".$questi19."', '".$exo19."', '".$type19."', '".$exo20."', '".$type20."', '".$questi20."', '".$exo21."', '".$type21."', '".$questi21."', 
 '".$exo22."', '".$type22."', '".$questi22."', '".$exo23."', '".$type23."', '".$questi23."', '".$exo24."', '".$type24."', '".$questi24."')"; 

$result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error()); 

//type : a e d et
//questi : 0 1 

?>