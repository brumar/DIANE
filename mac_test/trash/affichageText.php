<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 
			require_once("conn.php");
			$Requete_SQL1 = "SELECT count(*) FROM comparaison";
			$result1 = mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
			//while ($enregistrement = mysql_fetch_array($result))
			//while ($enregistrement = mysql_fetch_object($result))
           $k= mysql_fetch_array($result1); 
           if( $k[0] > 0)  
         	{ 
			print("Le nombre d'enregistrement dans la table comparaison est : ".$k[0]."<br><br><br>");
			}
		   else 
		   {
		    print("pas d'enregistement<br><br><br>");
		   }
              
		for($i=1; $i<=$k[0]; $i++)
		{	
				$Requete_SQL2 = "SELECT * FROM comparaison where numero=".$i;
				$result2 = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
				//while ($enregistrement = mysql_fetch_array($result))
				//while ($enregistrement = mysql_fetch_object($result))
				while ($enregistrement = mysql_fetch_assoc($result2))
					{
					  $text1 =  $enregistrement["enonce1"];
					  $text1 = eregi_replace(" *\.",".",$text1);
					  $text1 = eregi_replace(" *,",",",$text1);
					  $text2 =  $enregistrement["question1"];
					  $text2 = eregi_replace(" *\.",".",$text2);
					  $text2 = eregi_replace(" *,",",",$text2);
					  $text3 =  $enregistrement["enonce2"];
					  $text3 = eregi_replace(" *\.",".",$text3);
					  $text3 = eregi_replace(" *,",",",$text3);
					  $text4 =  $enregistrement["question2"];
					  $text4 = eregi_replace(" *\.",".",$text4);
					  $text4 = eregi_replace(" *,",",",$text4);
					}
				print ($text1."<br>".$text2."<br>".$text3."<br>".$text4."<br><br>");
		}
  			  mysql_close();
		?>
</body>
</html>
