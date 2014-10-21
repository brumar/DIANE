<?php
     require_once("conn.php");
	 $numExo=$_POST["numExo"];
	 $typeExo=$_POST["typeExo"];
     $c1 = trim($_POST["enonce1"]);
 	 $c1 = addslashes($c1);//$c1 = str_replace("'","\'",$c1);
     $c2 = trim($_POST["enonce2"]);
     $c2 = addslashes($c2);//$c2 = str_replace("'","\'",$c2); 
	 $q1 = trim($_POST["question1"]);
	 $q1 = addslashes($q1);//$q1 = str_replace("'","\'",$q1);
     $q2 = trim($_POST["question2"]);
	 $q2 = addslashes($q2);//$q2 = str_replace("'","\'",$q2);
     $quest= trim($_POST["question"]);
     $var= trim($_POST["variable"]);
	 $tendance=$_POST["tendance"];
	 $taille_nombre=trim($_POST["taille_nombre"]);
	 $ordre_donnees=trim($_POST["ordre_donnees"]);
	 
	 $strategie=trim($_POST["strategie"]);
  	 $strategie = addslashes($strategie);

 	 $descripteur=trim($_POST["description"]);
  	 $descripteur = addslashes($descripteur);
	 
	 $suggestions=trim($_POST["suggestions"]);
  	 $suggestions = addslashes($suggestions);
     //echo $c3;
     //extraction des mot du text, scinde la phrase grace aux virgules et espacements
     // ce qui inclus les " ", \r, \t, \n et \f
		 //echo ('numExo='.$numExo.' typeExo='.$typeExo);exit();

	//supprime tous caractere different de [^\d+-=:*]
	 $nombre1 = trim(eregi_replace ('[^0-9]', " ",$c1));
 	 $nombre2 = trim(eregi_replace ('[^0-9]', " ",$c2));
	 //print($nombre1." ".$nombre2);
	 $res =  array_values(preg_split ("/[\s]+/", $nombre1));
	 $res2 = array_values(preg_split ("/[\s]+/", $nombre2));
	 //print_r($res);print_r($res2);exit();
	 //trie du tableau  $res
     sort($res);
     sort($res2);
     $partie1= (int)$res[0];
     $tout1= (int)$res[1];
     //$partie2= $res[1]-$res[0];
     $partie2= $tout1-$partie1;
     if ($_POST["typePB"]=="e")
     {
         if ($_POST["question"]=="p")
           {
             $tout2=(int)$res2[0];
             $partie3=$tout2-$partie2;
             if ($tout2>=$tout1)
			 	$valdiff= $tout2-$tout1;
			 else if ($tout1>=$tout2)
		 		$valdiff= $tout1-$tout2;	
             //ou bien $partie3=$tout2-$tout1+$partie1;
           }
         elseif ($_POST["question"]=="t")
            {
              $partie3=(int)$res2[0];
              $tout2=$partie2+$partie3;
              if ($partie3 >= $partie1)
			  	{
				$valdiff= $partie3-$partie1;
				//print ($valdiff."  "."$partie3-$partie1");
				}
			  else if ($partie1 >= $partie3)
			  	{
				$valdiff= $partie1-$partie3;
				}
              //ou bien $tout2=$tout1+($partir3-$partie1);
            }
            // Creation de la requete SQL pour l'insertion dans la base.
          if (isset($_POST["numExo"]) and $_POST["typeExo"]=="complement")
		 {
 $Requete_SQL1 = "UPDATE complement SET enonce1='$c1',question1='$q1',enonce2='$c2',question2='$q2',partie1='$partie1',partie2='$partie2',tout1='$tout1',partie3='$partie3',valdiff='$valdiff',tout2='$tout2', variable='$var', question='$quest',tendance='$tendance',taille_nombre='$taille_nombre',ordre_donnees='$ordre_donnees',strategie='$strategie',descripteur='$descripteur',suggestions='$suggestions' WHERE numero=".$numExo; 
 		}
		 else{
		   $Requete_SQL1 = "INSERT INTO complement (enonce1, question1, enonce2,question2,partie1,partie2,tout1,partie3,valdiff,tout2,variable,question,tendance,taille_nombre,ordre_donnees,strategie,descripteur,suggestions) VALUES ('".$c1."','".$q1."','".$c2."','".$q2."',$partie1,$partie2,$tout1,$partie3, $valdiff, $tout2,'".$var."','".$quest."','".$tendance."','".$taille_nombre."','".$ordre_donnees."','".$strategie."','".$descripteur."','".$suggestion."')";
		 }
            // Execution de la requete SQL.
            $result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());

      }
      elseif ($_POST["typePB"]=="a")
      {
          if ($_POST["question"]=="p")
             {
               $valdiff = (int)$res2[0];
				   if(eregi(" de plus | de plus$ ",$_POST["enonce2"]))
					{
						//echo("de plus");
						$tout2 = $tout1+$valdiff;
					}
					else if(eregi(" de moins | moins que | de moins$ | plus tôt | plus tôt$",$_POST["enonce2"]))
					{
					   //echo("de moins");
					   $tout2 = $tout1-$valdiff;
					}
               $partie3 = $tout2-$partie2;
               //ou bien $partie3 = $partie1-$valdiff;
             }
          elseif ($_POST["question"]=="t")
             {
			   $valdiff = (int)$res2[0];
				   if(eregi(" de plus | plus que | de plus$ ",$_POST["enonce2"]))
					{
						//echo("de plus");
						$partie3= $partie1+$valdiff;
					}
					else if(eregi(" de moins | moins que | de moins$ | plus tôt | plus tôt$",$_POST["enonce2"]))
					{
					   //echo("de moins");
					   $partie3= $partie1-$valdiff;
					}
               $tout2=$partie2+$partie3;
               //ou bien $tout2 = $tout1-$valdiff;
             }
             // Creation de la requete SQL pour l'insertion dans la base.
         if (isset($_POST["numExo"]) and $_POST["typeExo"]=="comparaison")
		 {
			 $Requete_SQL1 = "UPDATE comparaison SET enonce1='$c1',question1='$q1',enonce2='$c2',question2='$q2',partie1='$partie1',partie2='$partie2',tout1='$tout1',partie3='$partie3',valdiff='$valdiff',tout2='$tout2', variable='$var', question='$quest',tendance='$tendance',taille_nombre='$taille_nombre',ordre_donnees='$ordre_donnees',strategie='$strategie',descripteur='$descripteur',suggestions='$suggestions' WHERE numero=".$numExo;
		 }
		 else{
			 $Requete_SQL1 = "INSERT INTO comparaison (enonce1, question1, enonce2,question2 ,partie1, partie2, tout1, partie3, valdiff, tout2, variable, question,tendance,taille_nombre,ordre_donnees,strategie,descripteur,suggestions) VALUES ('".$c1."','".$q1."','".$c2."','".$q2."',$partie1,$partie2,$tout1,$partie3,$valdiff,$tout2,'".$var."','".$quest."','".$tendance."','".$taille_nombre."','".$ordre_donnees."','".$strategie."','".$descripteur."','".$suggestion."')";
		 }
            // Execution de la requete SQL.
            $result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
      }

//echo $Requete_SQL1;exit();

if($_POST['typePB']=="a")
header('Location: affichage_a.php');
else if($_POST['typePB']=="e")
header('Location: affichage_e.php'); 
?>
<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head>
<title>Traitement Formulaire</title></head><body>
<p align="center">
<a href="index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<table border="1">
<tr>
    <td>Enoncé1</td>
    <td>question1</td>
    <td>Enoncé2</td>
    <td>Question2</td>
    <td>Partie1</td>
    <td>Partie2</td>
    <td>Tout1</td>
    <td>partie3</td>
    <td>Tout2</td>
    <td>Variable</td>
    <td>Type de probleme</td>
    <td>Question</td>
    <td>valeur de la difference</td>
    <td>Tendance</td>
    <td>Taille Nombre</td>
    <td>Ordre données</td>
    <td>Stratégie</td>
    <td>Descripteur</td>
    <td>Suggestions</td>
</tr>
<tr>
    <td><?php echo $c1; ?></td>
    <td><?php echo $_POST['question1']; ?></td>
    <td><?php echo $c2; ?></td>
    <td><?php echo $_POST['question2']; ?></td>
    <td><?php echo $partie1;?></td>
    <td><?php echo $partie2; ?></td>
    <td><?php echo $tout1; ?></td>
    <td><?php echo $partie3; ?></td>
    <td><?php echo $tout2; ?></td>
    <td><?php echo $_POST['variable']; ?></td>
    <td><?php echo $_POST['typePB']; ?></td>
    <td><?php echo $_POST['question'];?></td>
    <td><?php echo $valdiff; ?></td>
    <td><?php if(isset($tendance)) echo $tendance; ?></td>
	<td><?php if(isset($taille_nombre)) echo $taille_nombre; ?></td>
	<td><?php if(isset($ordre_donnees)) echo $ordre_données; ?></td>
    <td><?php if(isset($strategie)) echo $strategie; ?></td>
	<td><?php if(isset($descripteur)) echo $descripteur; ?></td>
	<td><?php if(isset($suggestions)) echo $suggestions; ?></td>
</tr>
</table>

</body>
</html>


