<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	// on veut pouvoir :
	/* 
	- modifier / supprimer (QUE POUR CHERCHEUR)
	- promote problem (promote problem selection) : QUE POUR CHERCHEUR
	- ajouter
	- voir les infos = code de la série, nombre d'exos, etc
	*/
	
	
	/*
	function test_flags($flags) {
	  if ($flags & FLAG_A) echo "A";
	  if ($flags & FLAG_B) echo "B";
	  if ($flags & FLAG_C) echo "C";
	}
	test_flags(FLAG_B | FLAG_C); */

	if(isset($_SESSION['feedbackSuppr'])){
		$feedbackSuppr = $_SESSION['feedbackSuppr'];
		unset($_SESSION['feedbackSuppr']);
	}

	if($_POST){
		

		if(isset($_POST['idToSee'])) {
			if(is_numeric($_POST['idToSee'])){
				$_SESSION['idToSee'] = (int)$_POST['idToSee'];

				// $req = $bdd->query('SELECT pbm from pbm_serie WHERE serie = '.$idToSee);
				// while ($res = $req->fetch();
			}
		}
	}
	else{
		if(isset($_SESSION['idToSee'])){
			unset($_SESSION['idToSee']);
		}
	}

	function displaySerie($enregistrement, $b, $rights = 0x0){ //,$count){ //TODO : ajouter $droits, etc
		$limText=110;
		$nomSerie = $enregistrement['nomSerie'];
		$id= $enregistrement['idSerie'];
		//$code = $enregistrement['code'];
		$commentaire = $enregistrement['commentaire'];


		//echo "<li id=\"li_".$count."\">";
		echo "<li>";
			echo "<div class=\"serie_s\">";
				echo "<span class=\"serie_text\">";
					echo "<em>".$nomSerie."</em><br><br>".$commentaire;
				echo"</span>";
				echo "</span>";
				echo"<span class=\"serie_see\">";
					echo"<a id=\"serie_see".$id."\" href=\"\" onclick=\"visualizeSerie(".$id.");return false;\"><img src=\"static/images/loupe.gif\" alt=\"voir cette série\"/></a>";
				echo"</span>";

				//if(isset($_SESSION['typeAccount'])){
					//if($_SESSION['typeAccount']=='chercheur'){
				if($rights & SERIE_RIGHTS_SUPPR){
					echo "<span class=\"serie_delete\">";
					echo "<a id=\"serie_delete".$id."\" href=\"\" onclick=\"confirmSuppr(".$id.");return false;\"><img src=\"static/images/delete.png\" alt=\"supprimer cette série\"/></a>";
					echo "</span>";
				}
				if($rights & SERIE_RIGHTS_PROMOTE){
					echo "<span class=\"serie_promote\">";
					echo "<a id=\"serie_promote".$id."\" href=\"s_pro".$id.".php\"><img src=\"static/images/star.png\" alt=\"promouvoir cette série\"/></a>";
					echo "</span>";
				}

			echo"</div>";
		echo"</li>";

		if(isset($_SESSION['idToSee'])){
			if($id == $_SESSION['idToSee']){
				$req = $b->query('SELECT pbm from pbm_serie WHERE serie = '.$_SESSION['idToSee']);

				while ($pbm = $req->fetch()){
					$exercice = $b->prepare("SELECT * FROM pbm WHERE idPbm = ?");
					$exercice->execute(array($pbm['pbm']));
					displayProblem($exercice->fetch());
					$exercice->closeCursor();
				}
			}
		}
	}


?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" charset="utf-8">
		<title>Séries de Problèmes</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css">
		<script type="text/javascript">
			function confirmSuppr(idToSuppr){
				if(confirm("Êtes vous sûr de vouloir supprimer cette série ? Les exercices eux-mêmes ne seront pas supprimés. Si la série est utilisée par des professeurs ou bien a été assigné à des élèves, elle ne pourra pas être supprimée.")){
					var idToSupprForm = document.getElementById("idToSupprForm");
					idToSupprForm.value = idToSuppr;
					document.forms["supprSerieForm"].submit();
				}
			}

			function visualizeSerie(idToSee){
				var idToSeeForm = document.getElementById("idToSeeForm");
				idToSeeForm.value = idToSee;
				document.forms["action_form"].submit();
			}
		</script>
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<form action="gerer_series.php" method="post" class="appnitro" id="action_form">

			<?php 
			if(isset($feedbackSuppr)){
				echo '<p>'.$feedbackSuppr.'</p>'; 
				}
			?>

			<h2>Gérer les séries</h2>
			<p>Sur cette page, vous pouvez explorer les séries d'exercices existantes, et si besoin, supprimer celles que vous avez créées.</p>
			<?php
				// TODO : il me faut un if(isset($_SESSION)) qui englobe tout !
				require_once("conn_pdo.php");
				$limText=110;
				
				// Séries crées par l'id en session

				if($_SESSION['accountType'] == 'chercheur'){
					$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? AND visibilite IN ('searchersOnly', 'all', 'private') ORDER BY ordrePres");
				}
				elseif($_SESSION['accountType'] == 'enseignant'){
					$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? AND visibilite IN ('all', 'private') ORDER BY ordrePres");
				}


				$vosSeries->execute(array($_SESSION['id']));
				$vosSeriesFlag = False; //flag, vaut vrai quand l'account connecté a créé des séries
				if($vosSeries->rowCount()!=0){
					echo"<h3>Vos séries d'exercices</h3>";
					$vosSeriesFlag = True;

					//$t=0;
					while ($enregistrement = $vosSeries->fetch())
					{
						displaySerie($enregistrement, $bdd, SERIE_RIGHTS_SUPPR);
					} 
				} 
				$vosSeries->closeCursor();


				
				//récupération de toutes les séries (il faudra passer en "toutes les séries qui ne m'appartiennent pas")
				
				if($vosSeriesFlag){
					echo"<h3>Autres séries d'exercices</h3>";
					//$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
					if($_SESSION['accountType'] == 'chercheur'){
						$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? AND visibilite IN ('searchersOnly', 'all') ORDER BY ordrePres");
					}
					elseif($_SESSION['accountType'] == 'enseignant'){
						$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? AND visibilite = 'all' ORDER BY ordrePres");
					}
					$autresSeries->execute(array($_SESSION['id']));
				}
				else{
					//$autresSeries = $bdd->query('SELECT * FROM serie ORDER BY ordrePres'); //try - catch ?
					if($_SESSION['accountType'] == 'chercheur'){
						$autresSeries = $bdd->query("SELECT * FROM serie WHERE visibilite IN ('searchersOnly', 'all') ORDER BY ordrePres");
					}
					elseif($_SESSION['accountType'] == 'enseignant'){
						$autresSeries = $bdd->query("SELECT * FROM serie WHERE visibilite = 'all' ORDER BY ordrePres");
					}
				}
				if ($autresSeries->rowCount()!=0) 
				{ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $autresSeries->fetch())
					{
						displaySerie($enregistrement, $bdd, 0);
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucune autre série.";
				}
				$autresSeries->closeCursor();
				?>

			<input type="hidden" id="idToSeeForm" name="idToSee" value="">
			</form>

			<form action="supprSerie.php" method="post" class="appnitro" id="supprSerieForm">
				<input type="hidden" id="idToSupprForm" name="idToSuppr" value="">
			</form>
			
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>