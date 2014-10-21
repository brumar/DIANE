<?php
     require_once("conn.php");
     $c1 = trim($_POST[enonce1]);
	 $c1 = addslashes($c1);//str_replace("'","\'",$c1);
     $c2 = trim($_POST[enonce2]);
	 $c2 = addslashes($c2);//str_replace("'","\'",$c2);
	 $c3 = $c2."0";
     $q1 = trim($_POST[question1]);
	 $q1 = addslashes($q1);//str_replace("'","\'",$q1);
     $q2 = trim($_POST[question2]);
	 $q2 = addslashes($q2);//str_replace("'","\'",$q2);
     $quest= trim($_POST[question]);
     $var= trim($_POST[variable]);
     //echo$c1;
     //echo $c3;
     //extraction des mot du text, scinde la phrase grace aux virgules et espacements
     // ce qui inclus les " ", \r, \t, \n et \f

     $tabMot = preg_split ("/[\s,.,-]+/", $c1);
     $tabMot2 = preg_split ("/[\s,.,-]+/", $c3);
     //recherche les nombre dans le tableau tabMot
     $res = preg_grep("/\d/", $tabMot);
     $res2 = preg_grep("/\d/", $tabMot2);
     //trie du tableau  $res
     sort($res);
     sort($res2);
     $partie1= (int)$res[0];
     $tout1= (int)$res[1];
     //$partie2= $res[1]-$res[0];
     $partie2= $tout1-$partie1;
     if ($_POST[typePB]=="e")
     {

         if ($_POST[question]=="p")
           {
             $tout2=(int)$res2[1];
             $partie3=$tout2-$partie2;
             if ($tout2>=$tout1)
			 	$valdiff= $tout2-$tout1;
			 else if ($tout1>=$tout2)
		 		$valdiff= $tout1-$tout2;	
             //ou bien $partie3=$tout2-$tout1+$partie1;
           }
         elseif ($_POST[question]=="t")
            {
              $partie3=(int)$res2[1];
              $tout2=$partie2+$partie3;
              if ($partie3 >= $partie1)
			  	{
				$valdiff= $partie3-$partie1;
				print ($valdiff."  "."$partie3-$partie1");
				}
			  else if ($partie1 >= $partie3)
			  	{
				$valdiff= $partie1-$partie3;
				}
              //ou bien $tout2=$tout1+($partir3-$partie1);
            }
            // Creation de la requete SQL pour l'insertion dans la base.
           $Requete_SQL1 = "INSERT INTO complement (enonce1, question1, enonce2,question2,partie1,partie2,tout1,partie3,valdiff,tout2,variable,question) VALUES ('".$c1."','".$q1."','".$c2."','".$q2."',$partie1,$partie2,$tout1,$partie3, $valdiff, $tout2,'".$var."','".$quest."')";
            // Execution de la requete SQL.
            $result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());

      }
      elseif ($_POST[typePB]=="a")
      { if ($_POST["question"]=="p")
             {
               $valdiff = (int)$res2[0];
				   if(eregi(" de plus | de plus$",$_POST["enonce2"]))
					{
						echo("de plus");
						$tout2 = $tout1+$valdiff;
					}
					else if(eregi(" de moins | de moins$",$_POST["enonce2"]))
					{
					   echo("de moins");
					   $tout2 = $tout1-$valdiff;
					}
               $partie3 = $tout2-$partie2;
               //ou bien $partie3 = $partie1-$valdiff;
             }
          elseif ($_POST["question"]=="t")
             {
			   $valdiff = (int)$res2[0];
				   if(eregi(" de plus | de plus$",$_POST["enonce2"]))
					{
						echo("de plus");
						$partie3= $partie1+$valdiff;
					}
					else if(eregi(" de moins | de moins$",$_POST["enonce2"]))
					{
					   echo("de moins");
					   $partie3= $partie1-$valdiff;
					}
               $tout2=$partie2+$partie3;
               //ou bien $tout2 = $tout1-$valdiff;
             }
             // Creation de la requete SQL pour l'insertion dans la base.
            $Requete_SQL1 = "INSERT INTO comparaison (enonce1, question1, enonce2,question2 ,partie1, partie2, tout1, partie3, valdiff, tout2, variable, question) VALUES ('".$c1."','".$q1."','".$c2."','".$q2."',$partie1,$partie2,$tout1,$partie3,$valdiff,$tout2,'".$var."','".$quest."')";
            // Execution de la requete SQL.
            $result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
      }
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
</tr>
<tr>
    <td><?php echo $c1; ?></td>
    <td><?php echo $_POST[question1]; ?></td>
    <td><?php echo $c2; ?></td>
    <td><?php echo $_POST[question2]; ?></td>
    <td><?php echo $partie1;?></td>
    <td><?php echo $partie2; ?></td>
    <td><?php echo $tout1; ?></td>
    <td><?php echo $partie3; ?></td>
    <td><?php echo $tout2; ?></td>
    <td><?php echo $_POST[variable]; ?></td>
    <td><?php echo $_POST[typePB]; ?></td>
    <td><?php echo $_POST[question];?></td>
    <td><?php echo $valdiff; ?></td>
</tr>
</table>
</body>
</html>