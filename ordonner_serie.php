<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");
	
	function generer_code(){
		$LEN_CODE = 3; //$LEN_CODE = 5;
		$string = "";
		$chaine = "abcdefghijklmnpqrstuvwxy"; //$chaine = "abcdefghijklmnpqrstuvwxy0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i < $LEN_CODE; $i++) {
			$string .= $chaine[rand()%strlen($chaine)];
		}
		return strtoupper($string);
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
		if(count($tab_id)==1){
			$JS_redirect =true;
		}
		else{
			$JS_redirect = false;
		}
		
	}

	$serieCree = false;
	if(isset($_POST['ordersForm'])){ // On enregistre dans la base de données et on redirige
		$keep_going = true;
		$inc = 0;
		while($keep_going){
			$gen_code = generer_code();
			if(!(exists_in_BDD('serie', 'code = ?', array($gen_code), $bdd))) {
				$keep_going = false;
			}
			else{
				$inc++;
				if($inc>=1000){
					die("Problème lors de la génération du code de la série.");
				}
			}
		}

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
		$serieCree = true;
		//TODO : message de réussite...
		//header("Location: profil_enseignant.php");
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
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Choix de l'ordre</h2>

			<div id="ordonner_serie_panel1">
				<p>Choisissez maintenant l'ordre dans lequel les exercices seront présentés à l'élève. </p>
				<form action="ordonner_serie.php" method="post" class="appnitro" onsubmit="return verifOrder()" name="my_form">

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

			<div id="ordonner_serie_panel2">
				<form action="ordonner_serie.php" method="post" class="appnitro" onsubmit="return false">
					<p>Votre nouvelle série a bien été créée. Les élèves pourront y accéder en utilisant le code suivant : <em><?php if(isset($gen_code)){echo $gen_code;}?></em>. Vous pouvez retrouver ce code ainsi que les codes des autres séries sur la <a href="gerer_series.php">page de gestion des séries d'exercices</a>.</p>
					<p>Cliquez <a href="profil_enseignant.php">ici pour revenir sur votre profil</a>, ou bien <a href="creer_serie.php">ici créer une nouvelle série d'exercices</a>.</p>
				</form>
			</div>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
		<script type="text/javascript">
			var panel1 = document.getElementById("ordonner_serie_panel1");
			var panel2 = document.getElementById("ordonner_serie_panel2");
			//var formOrdonner = document.getElementById("formOrdonner");
			
			window.onload=function(){
			<?php
			if($serieCree){
				echo "panel1.style.display = 'none';";
				echo "panel2.style.display = 'block';";
			}
			else{
				echo "panel1.style.display = 'block';";
				echo "panel2.style.display = 'none';";
			}	

			if($nameAlreadyTaken){
				echo "";
				echo "alert(\"Ce nom de série existe déjà, merci de choisir un autre nom.\");";
				echo "document.location.href=\"creer_serie.php\";";
			}
			else {
				if(isset($JS_redirect)){
					if($JS_redirect){
						echo "document.my_form.submit();";
					}
				}
			}
			?>
			};
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
	</body>
</html>


