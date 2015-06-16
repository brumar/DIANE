<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	require_once("conn_pdo.php");
	
	function generer_code(){
		return "ABCDE";
	}

	$tab_id = [];
	$nameAlreadyTaken = false;

	$thisNomS = "";
	$thisComS = "";

	if(isset($_POST['nomSerie'])){
		//Il faut vérifier que le nom de la série n'existe pas déjà
		$req = $bdd->prepare("SELECT * FROM serie WHERE nomSerie = ?");
		if($req->execute(array($_POST['nomSerie']))) {
			$res = $req->fetch();
			if($req->rowCount() > 0){ // Le nom existe déjà...
				$nameAlreadyTaken = true;
			}
		}

		$thisNomS = $_POST['nomSerie'];
		$thisComS = $_POST['commentaireSerie'];
	}

	if(isset($_POST['check_pb'])){
		
		foreach($_POST['check_pb'] as $checked_id)
		{
			array_push($tab_id, $checked_id);
		}

		//TODO: Cas particulier s'il n'y a qu'un seul ID : directement créer la série !
	}


	if(isset($_POST['ordersForm'])){ // On enregistre dans la base de données et on redirige
		
		$gen_code = generer_code();
		$maxReq = $bdd->query("SELECT MAX(ordrePres) FROM serie");
		$maxOrdrePres = $maxReq->fetchColumn(); 
		$ordrePres = $maxOrdrePres + 1;

		//Mise à jour de la table "serie"
		$req = $bdd->prepare("INSERT INTO serie VALUES(:idSerie, :nomSerie, :commentaire, :ordrePres, :code, :idCreator)");
		$req->execute(array(
			'idSerie' => '',
			'nomSerie' => $_POST['thisNomSerie'],
			'commentaire' => $_POST['thisCommentaireSerie'],
			'ordrePres' => $ordrePres,
			'code' => $gen_code,
			'idCreator' => $_SESSION['id']));

		$idNouvelleSerie = $bdd->lastInsertId();
		$req->closeCursor();


		//Mise à jour de la table "pbm_serie"

		//Les différentes valeurs sont séparées par des virgules
		$orders = explode(",", $_POST['ordersForm']);
		$idpbms = explode(",", $_POST['idsForm']);
		//TODO : ici vérifier que tout est correct

		for($i = 0; $i<count($orders); $i++){
			$req = $bdd->prepare("INSERT INTO pbm_serie VALUES(:pbm, :serie, :ordre)");
			$req->execute(array(
				'pbm' => $idpbms[$i],
				'serie' => $idNouvelleSerie,
				'ordre' => $orders[$i]));
			// TODO : rajouter un if{req ok}-else{on vire l'entrée de la bdd serie...}
			$req->closeCursor();
			//echo "<br/>New line. i=".$i.", idpbm=".$idpbms[$i].", idSerie=".$idNouvelleSerie.", ordre=".$orders[$i];
		}

		//TODO : message de réussite...
		header("Location: profil_enseignant.php");
	}


	function displayToOrderProblem($enregistrement, $n){
		$limText=300;
		$enonce = $enregistrement['enonce'];
		$id= $enregistrement['idPbm'];

		if (strlen($enonce) > $limText) 
		{
			$enonce=substr($enonce, 0, $limText).'[...]';
		}

	
		echo "<li>";
			echo "<div class=\"problem_o\">";
				echo "<span class=\"problem_select\">";
					//echo "<input type=\"textbox\" class=\"order_pbms\" name=\"order_pb[]\" id=\"".$id."\"></input>";
					echo "<select class=\"order_pbms\" name=\"order\"".$id.">";
						for($i=1; $i<($n+1); $i++){
							echo"<option value=\"".$i."\">".$i."</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<span class=\"problem_text\">";
					echo $enonce;
				echo"</span>";

			echo"</div>";
		echo"</li>";


	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" charset="utf-8">
		<title>Création d'une série</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css">
		<script language="Javascript">
			<?php
			if($nameAlreadyTaken){
				echo "window.onload=function(){";
				echo "alert(\"Ce nom de série existe déjà, merci de choisir un autre nom.\");";
				echo "document.location.href=\"creer_serie.php\";";
				echo "};";
			}
			?>
			function verifOrder(){
				var inputElems = document.getElementsByClassName("order_pbms");

				var allValues = [];
				for (var i=0; i<inputElems.length; i++) {
					allValues.push(false);
				}

				var chosenOrder = [];
				for (var i=0; i<inputElems.length; i++) {
					chosenOrder.push(inputElems[i].value);
					var b = parseInt(inputElems[i].options[inputElems[i].selectedIndex].value)-1;
					allValues[b] = true;
				}


				var allOrders = true;
				for (var i=0; i<allValues.length; i++) {
					if(!allValues[i]){
						allOrders=false;
					}
				}
				
				//alert(chosenOrder);
				if(allOrders){
					var ordersForm = document.getElementById("ordersForm");
					ordersForm.value = chosenOrder;
					return(true);	
				}
				else{
					alert("Plusieurs problèmes ne peuvent pas occuper la même place.")
					return(false);
				}
			}


		</script>
	</head>

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Choix de l'ordre</h2>
			<p>Choisissez maintenant l'ordre dans lequel les exercices seront présentés à l'élève. </p>
			<form action="ordonner_serie.php" method="post" class="appnitro" onsubmit="return verifOrder()">

				<?php
				require_once("conn_pdo.php");
				foreach($tab_id as $idpb){
					$req = $bdd->query("SELECT * FROM pbm WHERE idPbm = ".$idpb);
					$pbmToOrder = $req->fetch();
					displayToOrderProblem($pbmToOrder, count($tab_id));
					$req->closeCursor();
				}
				
				?>
				<input type="hidden" name="thisNomSerie" value<?php echo "=\"".$thisNomS."\""; ?> >
				<input type="hidden" name="thisCommentaireSerie" value<?php echo "=\"".$thisComS."\""; ?> >
				<input type="hidden" value="" name="ordersForm" id="ordersForm">
				<input type="hidden" value=<?php echo "\"".implode(",", $tab_id)."\"";?> name="idsForm" id="idsForm">
				<input type="submit" value="Créer la série">
			</form>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


