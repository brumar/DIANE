<?php
     require_once("conn.php");
     $c = trim($_POST["enonce"]);
 	 $c = addslashes($c);//$c = str_replace("'","\'",$c);
     $q = trim($_POST["question"]);
	 $q = addslashes($q);//$q = str_replace("'","\'",$q);
     $variable = $_POST["variable"];
     $typePb = $_POST["typePb"];
     
	 $inconnu = $_POST["inconnu"];
	 
	 $charge_cognitive=$_POST["charge_cognitive"];
	 
	 $strategie=trim($_POST["strategie"]);
  	 $strategie = addslashes($strategie);

 	 $descripteur=trim($_POST["description"]);
  	 $descripteur = addslashes($descripteur);
	 
	 $suggestions=trim($_POST["suggestions"]);
  	 $suggestions = addslashes($suggestions);
	 
	 $nombre = trim(eregi_replace ('[^0-9]', " ",$c));
	 $res =  array_values(preg_split ("/[\s]+/", $nombre));
	 $nbVar=count($res)-1;
	 
   switch($inconnu)
	{
		case 'EFP' : if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					 else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;
						
		case 'EFA' : 	$partie1=$res[0];
						$partie2=$res[1];
						$tout=$res[0]+$res[1];
						break;
		case 'EIA' : if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					 else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;
						
		case 'EIP' : 	$partie1=$res[0];
						$partie2=$res[1];
						$tout=$res[0]+$res[1];
						break;
						
		case 'TrP' : if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					 else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;
						
		case 'TrA' : 	if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					 else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;
						
						/* $partie1=$res[0];
						$partie2=$res[1];
						$tout=$res[0]+$res[1];
						break; */
		
		case 'partie' : if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					 	else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;	
						  			
		case 'tout' : 	$partie1=$res[0];
						$partie2=$res[1];
						$tout=$res[0]+$res[1];
						break;
		case 'diff' : if($res[0]>$res[1])
							{
								$partie1=$res[0]-$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					  else if($res[0]<$res[1])
							{
								$partie1=$res[1]-$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
						  break;
		case 'mult' : 	$partie1=$res[0];
						$partie2=$res[1];
						$tout=$res[0]*$res[1];
						break;
		case 'divq' : 	if($res[0]>$res[1])
							{
								$partie1=$res[0]/$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					  else if($res[0]<$res[1])
							{
								$partie1=$res[1]/$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
		case 'divp' : 	if($res[0]>$res[1])
							{
								$partie1=$res[0]/$res[1];
								$partie2=$res[1];
								$tout=$res[0];
							}
					  else if($res[0]<$res[1])
							{
								$partie1=$res[1]/$res[0];
								$partie2=$res[0];
								$tout=$res[1];
							}
	}
	
      // Creation de la requete SQL pour l'insertion dans la base.
	if (isset($_POST["numExo"]))
	{
		$Requete_SQL1 = "UPDATE etape SET enonce='$c',question='$q',charge_cognitive='$charge_cognitive',partie1='$partie1',partie2='$partie2',tout='$tout',typePb='$typePb',inconnu='$inconnu',variable='$variable',strategie='$strategie',descripteur='$descripteur',suggestions='$suggestions' WHERE numero=".$numExo;		 
	}
	else
	{
		$Requete_SQL1 = "insert into etape (enonce,question,charge_cognitive,partie1,partie2,tout,typePb,inconnu,variable,strategie,descripteur,suggestions) VALUES ('".$c."','".$q."','".$charge_cognitive."',$partie1,$partie2,$tout,'".$typePb."','".$inconnu."','".$variable."','".$strategie."','".$descripteur."','".$suggestions."')";
	}
       // Execution de la requete SQL.
		$result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
?>
<?php
header('Location: affichage_etape.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head>
<title>Traitement des problèmes à une étape</title></head><body>
<p align="center">
<a href="index.php">Accueil</a> &nbsp;&nbsp;
<a href="profil_enseignant.php">Interface Enseignant</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<h3 align="center">L'énoncé est enregistré avec succès</h3>
<table border="1">
<tr align="center">
    <td>Enoncé</td>
    <td>question</td>
    <td>charge cognitive</td>
    <td>partie1</td>
    <td>partie2</td>
    <td>tout</td>
    <td>Type de problème</td>
    <td>Inconnu</td>
	<td>Type de variable</td>
    <td>Stratégie</td>
    <td>Descripteur</td>
    <td>Suggestions</td>    
</tr>
<tr>
    <td><?php echo $c; ?></td>
    <td><?php echo $_POST['question']; ?></td>
    <td><?php echo $_POST['charge_cognitive']; ?></td>
    <td><?php if(isset($partie1)) echo $partie1;?></td>
    <td><?php if(isset($partie2)) echo $partie2; ?></td>
    <td><?php if(isset($tout)) echo $tout; ?></td>
	<td><?php if(isset($typePb)) echo $typePb; ?></td>
    <td><?php if(isset($inconnu)) echo $inconnu; ?></td>
	<td><?php if(isset($variable)) echo $variable; ?></td>
	<td><?php if(isset($strategie)) echo $strategie; ?></td>
	<td><?php if(isset($descripteur)) echo $descripteur; ?></td>
	<td><?php if(isset($suggestions)) echo $suggestions; ?></td>

</tr>
</table>
<a href="formEtape.html">Retour</a>
</body>
</html>



