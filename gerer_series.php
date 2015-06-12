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
	function displaySerie($enregistrement){ //,$count){ //TODO : ajouter $droits, etc
		$limText=110;
		$text1 = $enregistrement['nomSerie'];
		$id= $enregistrement['idSerie'];

		if (strlen($text1) > $limText) 
		{
			$text1=substr($text1, 0, $limText).'[...]';
		}

		//echo "<li id=\"li_".$count."\">";
		echo "<li>";
			echo "<div class=\"serie_s\">";
				echo "<span class=\"serie_select\">";
					echo "<input type=\"checkbox\" name=\"".$id."\" value=\"".$id."\"></input>";
				echo "</span>";
				echo "<span class=\"serie_text\">";
					echo $text1;
				echo"</span>";
				echo"<span class=\"serie_see\">";
					echo"<a id=\"serie_see".$id."\" href=\"s_see".$id."\"><img src=\"static/images/loupe.gif\" alt=\"voir cette série\"/></a>";
				echo"</span>";


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
			echo"</div>";
		echo"</li>";
	}
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
			<form action="gerer_series.php" method="post" class="appnitro">

			<h2>Gérer les séries</h2>
			<?php
				// TODO : il me faut un if(isset($_SESSION)) qui englobe tout !
				require_once("conn_pdo.php");
				$limText=110;
				
				// Séries crées par l'id en session

				//$vosSeries = $bdd->query("SELECT * FROM serie WHERE idCreator = ".$_SESSION['id']."ORDER BY ordrePres"); //try - catch ?
				$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? ORDER BY ordrePres");
				$vosSeries->execute(array($_SESSION['id']));
				$vosSeriesFlag = False; //flag, vaut vrai quand l'account connecté a créé des séries
				if($vosSeries->rowCount()!=0){
					echo"<h3>Vos séries d'exercices</h3>";
					$vosSeriesFlag = True;

					//$t=0;
					while ($enregistrement = $vosSeries->fetch())
					{
						//$t++;
						//displaySerie($enregistrement, $t);
						displaySerie($enregistrement);
					} 
				} 
				$vosSeries->closeCursor();


				
				//récupération de toutes les séries (il faudra passer en "toutes les séries qui ne m'appartiennent pas")
				
				if($vosSeriesFlag){
					echo"<h3>Autres séries d'exercices</h3>";
					$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
					$autresSeries->execute(array($_SESSION['id']));
				}
				else{
					$autresSeries = $bdd->query('SELECT * FROM serie ORDER BY ordrePres'); //try - catch ?
				}
				if ($autresSeries->rowCount()!=0) 
				{ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $autresSeries->fetch())
					{
						displaySerie($enregistrement);
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucune autre série.";
				}
				$autresSeries->closeCursor();
				?>
			</ul>
			<p>

			
			</p>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


