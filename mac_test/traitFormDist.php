<?php
     require_once("conn.php");
     $c = trim($_POST["enonce"]);
 	 $c = addslashes($c);//$c = str_replace("'","\'",$c);
     $q = trim($_POST["question"]);
	 $q = addslashes($q);//$q = str_replace("'","\'",$q);
     $facteur = trim($_POST["facteur"]);
     $varFacteur = trim($_POST["varFacteur"]);
     $varFactorise = trim($_POST["varFactorise"]);
	 $nombre = trim(eregi_replace ('[^0-9]', " ",$c));
	 $res =  array_values(preg_split ("/[\s]+/", $nombre));

	$element=$_POST["element"];

	 $element_str = trim($_POST["element_str"]);
  	 $element_str = addslashes($element_str);
	 
	 $strategie=trim($_POST["strategie"]);
  	 $strategie = addslashes($strategie);

 	 $descripteur=trim($_POST["description"]);
  	 $descripteur = addslashes($descripteur);
	 
	 $suggestions=trim($_POST["suggestions"]);
  	 $suggestions = addslashes($suggestions);
	 
	 $nbVar=count($res)-1;
	 
		 if($facteur=="debut")
		 {
			$fact = (int)$res[0];
			for($i=1; $i<=$nbVar;$i++)
	 		{
				${"va".$i} = (int)$res[$i]; 
				 //echo(	${"va".$i} );
			} 
		 }
		 else if($facteur=="fin")
		 {
			$fact= (int)$res[$nbVar];
			for($i=0; $i<=$nbVar-1;$i++)
	 		{
				$j=$i+1;
				${"va".$j} = (int)$res[$i]; 
				// echo(	${"va".$j} );
			} 
		 }
	    
	 //exit();
	 for ($i=1; $i<=5; $i++)
	 {
	 	if(!isset(${"va".$i} )) 
			${"va".$i} = 0 ;
	 }
      // Creation de la requete SQL pour l'insertion dans la base.
       if (isset($_POST["numExo"]))
		 {
 $Requete_SQL1 = "UPDATE distributivite SET enonce='$c',question='$q',va1='$va1',va2='$va2',va3='$va3',va4='$va4',va5='$va5',nva='$nbVar',fact='$fact',varFacteur='$varFacteur',varFactorise='$varFactorise',facteur='$facteur',element=$element, element_str=$element_str,strategie='strategie',descripteur='$descripteur',suggestions='$suggestions' WHERE numero=".$numExo;		 
 }
 else
 {
	 $Requete_SQL1 = "insert into distributivite (enonce,question,va1,va2,va3,va4,va5,nva,fact,varFacteur,varFactorise,facteur,element,element_str,strategie,descripteur,suggestions) VALUES ('".$c."','".$q."',$va1,$va2,$va3,$va4,$va5,$nbVar,$fact,'".$varFacteur."','".$varFactorise."','".$facteur."','".$element."','".$element_str."','".$strategie."','".$descripteur."','".$suggestions."')";
 }
       // Execution de la requete SQL.
       $result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error()); 
?>
<?php
header('Location: ../mac_test/affichage_d.php');
?>

<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head>
<title>Traitement Formulaire</title></head><body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<table border="1">
<tr>
        <td>Enoncé</td>
        <td>question</td>
        <td>va1</td>
        <td>va2</td>
        <td>va3</td>
        <td>va4</td>
        <td>va5</td>
        <td>Nombre de variable</td>
        <td>Facteur</td>
        <td>Fact</td>
        <td>variable Facteur</td>
        <td>variable Factorisés</td>
        <td>Element</td>
        <td>Element structurant</td>
        <td>Strategie</td>
        <td>Descripteur</td>
        <td>Suggestions</td>
</tr>
<tr>
    <td><?php echo $c; ?></td>
    <td><?php echo $_POST['question']; ?></td>
    <td><?php if(isset($va1)) echo $va1;?></td>
    <td><?php if(isset($va2)) echo $va2; ?></td>
    <td><?php if(isset($va3)) echo $va3; ?></td>
    <td><?php if(isset($va4)) echo $va4; ?></td>
    <td><?php if(isset($va5)) echo $va5; ?></td>
    <td><?php echo $nbVar; ?></td>
    <td><?php echo $facteur; ?></td>
    <td><?php echo $fact;?></td>
    <td><?php echo $varFacteur; ?></td>
	<td><?php echo $varFactorise; ?></td>
	<td><?php echo $element; ?></td>
	<td><?php if(isset($element_str)) echo $element_str; ?></td>
    <td><?php if(isset($strategie)) echo $strategie; ?></td>
    <td><?php if(isset($descripteur)) echo $descripteur; ?></td>
	<td><?php if(isset($suggestions)) echo $suggestions; ?></td>

</tr>
</table>

</body>
</html>


