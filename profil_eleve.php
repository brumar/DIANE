<?php
	require_once("verifSessionEleve.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	// On vérifie d'abord si l'élève a des "devoirs", si son maître ou sa maîtresse lui a assigné
	if(exists_in_BDD("serie_eleve", "idEleve = ?", array($_SESSION['numEleve']), $bdd)){
		$exercices_a_faire = true;
		$exercices_non_fini = count_BDD('SELECT COUNT(*) FROM serie_eleve WHERE idEleve=? AND statut IN ("untouched","opened")', array($_SESSION['numEleve']) , $bdd);
	}
	else{
		$exercices_a_faire = false;
		$exercices_non_fini = 0;
	}

?>
<!DOCTYPE html>


<html>
	<head>
		<title>DIANE - élève</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" href="static/css/view.css" />
		<script language="javascript"> 
			function redirectJS(idSerie){
				var c = document.getElementById('choix_serie');
				c.value = idSerie;
				var myform = document.getElementById('form_choix_serie');
				myform.submit();
			}
		</script>
	</head>
	<body>
		<div>
			<?php 
				echo "Bonjour ".$_SESSION['prenom']."!<br/>";// ".$_SESSION['nom']. "!<br/>";
				?>

			<div>
				<?php
				if($exercices_a_faire){
					if($exercices_non_fini == 0){
						echo "Tu as déjà finis tous les exercices que tu devais faire.<br/>";
					}
					else{
						echo "Choisis une série d'exercices :<br/>";	
					}
					 

					$req = $bdd->prepare('SELECT idSerie, statut FROM serie_eleve WHERE idEleve = ?');
					if($req->execute(array($_SESSION['numEleve']))){

						
						
						while ($r = $req->fetch()){
							$nomSerie = get_value_BDD("nomSerie", "serie", "idSerie = ?", array($r['idSerie']), $bdd);
							if(($r['statut'] =='untouched') || ($r['statut'] =='opened')){
								echo "<input type=\"button\" class=\"serie_choice serie_to_do\" value=\"".$nomSerie."\""." onclick=\"redirectJS(".$r['idSerie'].")\"/><br/>";
							}
							else{
								echo "<input type=\"button\" class=\"serie_choice serie_done\" value=\"".$nomSerie."\""." onclick=\"redirectJS(".$r['idSerie'].")\"/><span class=\"done_indication\">Tu as déjà fini cette série d'exercices</span><br/>";	
							}
						}
					}

					$req->closeCursor();
				}
				else{
					echo "Tu n'as aucun exercices à faire.<br/>";	
				}
				// else{
				// 	if($rep = $bdd->query('SELECT nomSerie, idSerie FROM serie ORDER BY ordrePres')){
				// 		while ($r = $rep->fetch()){
				// 			echo "<input type=\"button\" class=\"serie_choice\" value=\"".$r['nomSerie']."\""." onclick=\"redirectJS(".$r['idSerie'].")\"/><br/>";
				// 		}
				// 	}
				// }
			?>
			<form action="interface.php" method="post" id="form_choix_serie">
				<input type="hidden" id="choix_serie" name="serie" value="-1">
			</form>
			</div>
		</div>
	</body>
</html>