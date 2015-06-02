<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	// on veut pouvoir :
	/* 
	- créer une session = choisir des séries
	- modifier / supprimer (QUE POUR CHERCHEUR)
	- promote problem (promote problem selection) : QUE POUR CHERCHEUR
	- ajouter
	- voir les infos = code de la série, nombre d'exos, etc
	*/
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" charset="utf-8">
		<title>Séries de Problèmes</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css">
	</head>

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Création d'une nouvelle série de problèmes</h2>
			<form action="TraitSerie_D2.php" method="post" class="appnitro">
				<ul>
					<li id="li_999" >
						<label class="description" for="element_999">Nom de la série </label>
						<div>
							<input id="element_999" name="name" class="element text large" type="text" maxlength="255" value="<?php if (isset($name)){echo($keywords);}?>"/> 
						</div>
						<p class="guidelines" id="guide_999"><small>Indiquez le nom de la série pour que vous puissiez la retrouver plus tard </small></p> 
					</li>

					<li id="li_998" >
						<label class="description" for="element_998">Commentaire associée à la série </label>
						<div>
							<textarea id="textarea" name="comments" class="element textarea small"  ></textarea>
						</div><p class="guidelines" id="guide_998"><small>Vous pouvez décrire ici les caractéristiques de cette série d'exercices.</small></p> 
					</li>


					<li>
						Liste de problèmes
					</li>
				</ul>		
				<ul>
				<input type="submit" value="Créer la série">
			</form>

			<h2>Gérer les séries</h2>
			<?php
				// TODO : il me faut un if(isset($_SESSION)) qui englobe tout !
				$self=$_SERVER['PHP_SELF'];
				require_once("conn_pdo.php");
				if (isset($_GET['page'])){$page=$_GET['page'];}
				if (isset($_GET['total'])){ $total=$_GET['total'];}

				$limText=110;
				$nb=30;
				if(empty($page)) $page = 1;
				if(empty($total)){ // nombre total de résultats
					$series = $bdd->query('SELECT * FROM serieVieille');
					$total= $series->rowCount();
				}

				// on determine debut du limit
				$debut = ($page - 1) * $nb;

				$result = $bdd-> query('SELECT * FROM serieVieille order by numSerie desc LIMIT '.$debut.','.$nb) or die(); //try - catch ?



				if ($result) 
				{ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $result->fetch())
					{
						$text1 = $enregistrement['nomSerie'];
						$id= $enregistrement['numSerie'];

						if (strlen($text1) > $limText) 
						{
							$text1=substr($text1, 0, $limText).'[...]';
						}
			?>

			<li id="li_<?php echo($t);$t++;?>">

				
					<div class="serie_s">
						<span class="serie_select">
							<input type=checkbox name="s_sel<?php echo($id);?>" value="<?php echo($id);?>"></input>
						</span>
						<span class="serie_text"> 
							<?php echo $text1; ?>
						</span>
						<span class="serie_see"> 
							<a id="serie_see<?php echo($id);?>" href="s_see<?php echo($id);?>.php"><img src="static/images/loupe.gif" alt="voir cette série"/></a>
						</span>

						<?php
						if(isset($_SESSION['typeAccount'])){
							if($_SESSION['typeAccount']=='chercheur'){
								echo "<span class=\"serie_delete\">";
								echo "<a id=\"serie_delete".$id."\" href=\"s_del".$id.".php\"><img src=\"static/images/delete.png\" alt=\"supprimer cette série\"/></a>";
								echo "</span>";
								echo "<span class=\"serie_promote\">";
								echo "<a id=\"serie_promote".$id."\" href=\"s_pro".$id.".php\"><img src=\"static/images/star.png\" alt=\"promouvoir cette série\"/></a>";
								echo "</span>";
							}
						}
						?>
					</div>
			</li>
				<?php
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucune série.";
				}
				$result->closeCursor();

			?></ul>
			<p>

			<?php
				// calcul du nombre de pages
				$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
				// on affiche les pages
				for($i = 1;$i <= $nbpages; $i ++)
				{
					if ($i==1) {echo("<h4>pages</h4>");}
					echo "<a href=\"$self?page=$i&total=$total\">$i</a>";
					if($i < $nbpages) echo " - ";
				}
				unset($bdd);
			?>
			</p>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


