<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");
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
			<h2>Création d'une nouvelle série de problèmes</h2>
			<form action="ordonner_serie.php" method="post" class="appnitro" onsubmit ="return verifSerie();">
				<ul>
					<li id="li_999" >
						<label class="description" for="element_999">Nom de la nouvelle série </label>
						<div>
							<input id="element_999" name="name" class="element text large" type="text" maxlength="255" value="<?php if (isset($name)){echo($keywords);}?>"/> 
						</div>
						<p class="guidelines" id="guide_999"><small>Indiquez le nom de la série pour que vous puissiez la retrouver plus tard </small></p> 
					</li>

					<li id="li_998" >
						<label class="description" for="element_998">Commentaire associée à la série </label>
						<div>
							<textarea id="element_998" name="comments" class="element textarea small"></textarea>
						</div><p class="guidelines" id="guide_998"><small>Vous pouvez décrire ici les caractéristiques de cette série d'exercices.</small></p> 
					</li>

				</ul>		
				
			
			<h2>Sélection des exercices</h2>
			<p>Sélectionnez tous les exercices que vous souhaitez inclure dans votre nouvelle série.</p>

			<div>
				Montrer les exercices qui ont la propriété :
				<select name="sort_property" id="sort_property" onchange="propertySort()">
					<option value="none">...</option>
					<?php
						// $exoProperties = $bdd->query('SELECT id, name FROM properties WHERE tri_prof = 1 ORDER BY id');
					$exoProperties = $bdd->query('SELECT id, name FROM properties WHERE tri_prof = 1 ORDER BY id');
						foreach($exoProperties->fetchall() as $property){
							echo "<option value =\"".$property['name']."\">".$property['name']."</option>";
						}

					?>
				</select>
			</div>
			<?php
				
				
				// Exercices crées par l'id en session

				$vosExercices = $bdd->prepare("SELECT * FROM pbm WHERE idCreator = ? ORDER BY idPbm");
				$vosExercices->execute(array($_SESSION['id']));
				$vosExos = False; //flag, vaut vrai quand l'account connecté a créé des séries
				if($vosExercices->rowCount()!=0){
					echo"<h3>Vos exercices</h3>";
					$vosExos = True;

					while ($enregistrement = $vosExercices->fetch())
					{
						displayProblem($enregistrement, FLAG_PBMS_CHECKBOX);
					} 
				} 
				$vosExercices->closeCursor();
				
				if($vosExos){
					echo"<h3>Autres exercices</h3>";
					$autresExos = $bdd->prepare("SELECT * FROM pbm WHERE idCreator <> ? ORDER BY idPbm");
					$autresExos->execute(array($_SESSION['id']));
				}
				else{
					$autresExos = $bdd->query('SELECT * FROM pbm ORDER BY idPbm'); //try - catch ?
				}
				if ($autresExos->rowCount()!=0) 
				{ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $autresExos->fetch())
					{
						displayProblem($enregistrement, FLAG_PBMS_CHECKBOX);
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucun autre exercice.";
				}
				$autresExos->closeCursor();

			?>
			
			<input type="hidden" name="nomSerie" value="" id="f_nomSerie">
			<input type="hidden" name="commentaireSerie" value="" id="f_comSerie">
			<input type="submit" value="Valider la sélection">
			</form>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
		<script type="text/javascript">
			function checkboxes()
			{
				var inputElems = document.getElementsByClassName("check_pbms");
				//var inputElems = document.getElementsByName("check_pb");
				var count = 0;

				for (var i=0; i<inputElems.length; i++) {       
					if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
					count++;
					}
				}
				return(count);
			}

			function cleanString(str) {
			    return String(str).replace(/</g, '&lt').replace(/>/g, '&gt').replace(/"/g, '&quot').replace(/'/g, '&#039');
			}

			function verifSerie(){
				var nomSerieInput = document.getElementById("element_999");
				var nomSerieHidd = document.getElementById("f_nomSerie");
				var commentaireSerieInput = document.getElementById("element_998");
				var commentaireSerieHidd = document.getElementById("f_comSerie");;

				if(nomSerieInput.value == ""){
					alert("Merci de donner un nom pour la nouvelle série.");
					return(false);
				}
				else{
					commentaireSerieHidd.value = cleanString(commentaireSerieInput.value);
					nomSerieHidd.value = cleanString(nomSerieInput.value);
				}

				var nb_check = checkboxes();

				if (nb_check == 0){
					alert("Il faut sélectionner au moins un problème.");
					return(false);
				}
				else if (nb_check == 1){
					return(confirm("Vous n'avez sélectionné qu'un seul problème, êtes vous sûr de vouloir créer une série ne contenant qu'un problème ?"));
				}
				else{
					return(true);
				}
			}

			function propertySort(){
				// Recharge la page pour déclencher le tri par la propriété sélectionné  
				var select_property = document.getElementById("sort_property");
				select_property.value

			}

		</script>
	</body>
</html>


