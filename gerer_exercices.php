<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	$feedback = "";
	if(isset($_SESSION['feedback_supprExercise'])){
		$feedback = $_SESSION['feedback_supprExercise'];
		unset($_SESSION['feedback_supprExercise']);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Problem Creation Interface</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
		<script type="text/javascript">
			function confirmSupprPbm(idToSuppr){

				//TODO : vérifier si le problème est utiliser quelque part ?
				//TODO : IL FAUT  mettre ID dans idToSupprForm. MAIS ATTENTION D'ABORD FAUDRAIT iMPLETER LA variable "hidden/active" pour les problemes
				if(confirm("Êtes vous sûr de vouloir supprimer ce problème ?")){
					var action_form = document.getElementById("action_form");
					var form_idToSuppr = document.getElementById("idToSupprForm");
					form_idToSuppr.value = idToSuppr;
					action_form.submit();
				}
			}
		</script>
		
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">				
		<div id="form_container">
		<h1><a>Untitled Form</a></h1>
		<form action="supprExercise.php" method="post" class="appnitro" id="action_form">
			
			<h2>Gérer les exercices</h2>
			<!-- <p>Sur cette page, vous pouvez explorer les différents types d'exercices.</p>-->
			
			<?php
			echo $feedback;
			if($_SESSION['accountType'] == 'chercheur'){
				$rights = FLAG_PBMS_SUPPR; 
			}
			else{
				$rights = 0;
			}

			$vosExercices = $bdd->prepare("SELECT * FROM pbm WHERE idCreator = ? ORDER BY idPbm");
			$vosExercices->execute(array($_SESSION['id']));
			$vosExercicesFlag = False; //flag, vaut vrai quand l'account connecté a créé des problèmes
			if($vosExercices->rowCount()!=0){
				echo"<h3>Vos exercices</h3>";
				$vosExercicesFlag = True;

				while ($enregistrement = $vosExercices->fetch())
				{
					displayProblem($enregistrement, $rights);
				} 
			} 
			$vosExercices->closeCursor();			
			//récupération des autres exercices
			
			if($vosExercicesFlag){
				echo"<h3>Autres exercices</h3>";
				$autresExercices = $bdd->prepare("SELECT * FROM pbm WHERE idCreator <> ? ORDER BY idPbm");
				$autresExercices->execute(array($_SESSION['id']));
			}
			else{
				$autresExercices = $bdd->query('SELECT * FROM pbm ORDER BY idPbm');
			}
			if ($autresExercices->rowCount()!=0) 
			{ // Si il y'a des résultats
				while ($enregistrement = $autresExercices->fetch())
				{
					displayProblem($enregistrement, $rights);
				} // Fin instruction while

			} else { // Pas de résultat trouvé
				echo "Il n'y a aucun autre problème.";
			}
			$autresExercices->closeCursor();
			?>

			<input type="hidden" id="idToSupprForm" name="idToSuppr" value="">
			
		</form>	
			
		</div>

		<img id="bottom" src="static/images/bottom.png" alt="">
		</body>
</html>