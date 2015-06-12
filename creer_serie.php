<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

	function displayProblem($enregistrement){
		$limText=300;
		$enonce = $enregistrement['enonce'];
		$id= $enregistrement['idPbm'];

		if (strlen($enonce) > $limText) 
		{
			$enonce=substr($enonce, 0, $limText).'[...]';
		}

		echo "<li>";
			echo "<div class=\"problem_s\">";
				echo "<span class=\"problem_select\">";
					echo "<input type=\"checkbox\" class=\"check_pbms\" name=\"check_pb[]\" value=\"".$id."\"></input>";
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
			 function checkboxes()
			{
				var inputElems = document.getElementsByClassName("check_pbms");
				var count = 0;

				for (var i=0; i<inputElems.length; i++) {       
					if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
					count++;
					}
				}
				return(count);
			}
			function verifSerie(){
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
		</script>
	</head>

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Création d'une nouvelle série de problèmes</h2>
			<form action="ordonner_serie.php" method="post" class="appnitro" onsubmit ="return verifSerie()">
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
							<textarea id="textarea" name="comments" class="element textarea small"  ></textarea>
						</div><p class="guidelines" id="guide_998"><small>Vous pouvez décrire ici les caractéristiques de cette série d'exercices.</small></p> 
					</li>

				</ul>		
				
			
			<h2>Sélection des exercices</h2>
			<p>Sélectionnez tous les exercices que vous souhaitez inclure dans votre nouvelle série.</p>

			<?php
				require_once("conn_pdo.php");
				
				// Exercices crées par l'id en session

				$vosExercices = $bdd->prepare("SELECT * FROM pbm WHERE idCreator = ? ORDER BY idPbm");
				$vosExercices->execute(array($_SESSION['id']));
				$vosExos = False; //flag, vaut vrai quand l'account connecté a créé des séries
				if($vosExercices->rowCount()!=0){
					echo"<h3>Vos séries d'exercices</h3>";
					$vosExos = True;

					while ($enregistrement = $vosExercices->fetch())
					{
						displayProblem($enregistrement);
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
						displayProblem($enregistrement);
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucun autre exercice.";
				}
				$autresExos->closeCursor();

			?>
			
			<input type="submit" value="Valider la sélection">
			</form>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


