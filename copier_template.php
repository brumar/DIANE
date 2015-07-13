<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	$self=$_SERVER['PHP_SELF'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Creation de problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Liste des énoncés</h2>
			<form action="selection.php" method="post" class="appnitro">
				<ul>
				<?php
				
				if (isset($_GET['page'])){$page=$_GET['page'];}
				if (isset($_GET['total'])){ $total=$_GET['total'];}

				$nb=6;
				if(empty($page)) $page = 1;
				if(empty($total)){ // nombre total de résultats
					//$sql1 = "SELECT * FROM pbm_globalcontent";
					//$total=mysql_num_rows(mysql_query($sql1));
					$res = $bdd->query("SELECT * FROM pbm_template");
					$total = $res->rowCount();
					$res->closeCursor();
					//$total = @mysql_result($p,"0","qte");
				}

				// on determine debut du limit
				$debut = ($page - 1) * $nb;
				$result = $bdd->query("SELECT * FROM pbm_template order by id desc LIMIT $debut,$nb");

				if($result){ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $result->fetch())
					{
						$text1 =  $enregistrement["Text_html"];
						$id= $enregistrement["id"];
						?>
						<li id="li_<?php echo($t);$t++;?>">
						<div style="width:350px;display:inline-block;margin:0 0 5px 40px;padding:10px;border:1px solid black"> 
						<?php echo( $text1); ?>
						</div>
						<div style="width:70px;display:inline-block;margin:0 0 5px 40px">
						<input type="button" value="copier ce modèle" id="Quest" onClick="parent.location='openPbm.php?id=<?php echo($id);?>'"/>
						</div></li>
						<?php
					} // Fin instruction while
				} 
				else{ // Pas de résultat trouvé
					echo "Pas de résultat";
				}
				?></ul>
				<p>
				<?php
				// calcul du nombre de pages
				$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
				// on affiche les pages
				for($i = 1;$i <= $nbpages;$i ++)
				{
				if ($i==1){echo("<h4>pages</h4>");}
				echo "<a href=\"$self?page=$i&total=$total\">$i</a>";
				if($i < $nbpages) echo " - ";
				}
				//mysql_free_result($result); // Libère la mémoire
				//mysql_close(); // Ferme la connexion
				$result->closeCursor();
				?>
				</p>
				<p><a href="creation_template.php">Créer un nouvel exercice</a></p>
				<p><a href="profil_enseignant.php">Retour</a></p>
			</form>
		</div>

		
		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>
