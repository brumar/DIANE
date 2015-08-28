<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");


	// Gestion des variables GET... serait beaucoup mieux de passer par des variable $_SESSION...
	$id=0;
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
	$operation="default";
	if(isset($_GET['operation'])){
		$operation=$_GET['operation'];//vaut 'clone' ou 'défaut'
	}

	require_once("opening.php"); //note : prend en entrée $id, ressort $infos et $infoshtml	

	$numeric_constraints = get_value_BDD('constraints', 'pbm_template', 'id=?', array($id), $bdd);
	$public_notes = get_value_BDD('public_notes', 'pbm_template', 'id=?', array($id), $bdd);
	$proprietes_template = get_value_BDD('properties', 'pbm_template', 'id=?', array($id), $bdd);


	// On teste si on a cliqué sur "Valider les changements manuels"
		// Si c'est le cas on ne traite pas "operation"
	$redirect = false;
	$modif_manuel = false;
	foreach ($_SESSION['infos']['clones'] as $clone_element){
		$elem = "clone_".$clone_element[1][0].$clone_element[2][0];
		if(isset($_POST[$elem])){
			$redirect = true;
			if(!(isset($_SESSION['modif_manuel']))){
				$_SESSION['modif_manuel'] = array();
			}
			$_SESSION['modif_manuel'][$elem] = $_POST[$elem];
		}
	}
	if($redirect){
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit();
	}

	if(isset($_SESSION['modif_manuel'])){
		$modif_manuel = true;
		$modif_manuel_elements = $_SESSION['modif_manuel'];

		unset($_SESSION['modif_manuel']);
	}


	// Il faut créer la variable "$replacements"
	$replacements=array();
	foreach ($_SESSION['infos']['questions'] as $questions){
		$b=$questions[0][0];
		$r=$questions[3][0];
		$search="[[$b]]";
		$replacements["$search"]=$r;
	}

	$numbers = array();
	foreach ($_SESSION['infos']['clones'] as $clone_element){
		
		$type=$clone_element[1][0];
		if($type=="Nombre") { //On se contente de récupérer tous les nombres dans un premier temps
			$numbers[]=$clone_element;
		}
		else{
			$expression=$clone_element[3][0];
			$compteur=$clone_element[2][0];
			$brut=$clone_element[0][0];
			$search="<<$brut>>";


			if($modif_manuel){
				$t = $modif_manuel_elements["clone_".$type.(string)$compteur];
				$replacements["$search"]=$t; // TODO : vérifier sécurité ici... clairement dangereux de laisser écrire n'importe
			}
			else{
				if($operation=="clone"){

					if($type== "homme" || $type=="femme"){
						
						$result = $bdd->query("SELECT * FROM clone_".$type." ORDER BY RAND() LIMIT 1");
						$t=$result->fetch();
						$replacements["$search"]=$t[$type];
					}

					else{ //Type personnalisé
						$req = $bdd->prepare("SELECT * FROM lists WHERE type = ? AND name = ?");
						$result = $req->execute(array("insertions", $type));

						$l = $req->fetch();
						$list = explode("||", $l['values']);
						$pick=rand(0,count($list)-1);
						$replacements["$search"]=$list[$pick];
					}
				}

				elseif ($operation=="default"){
					$replacements["$search"]=$expression;
				}
			}

				
		}

		// Gestion des nombres
		if($modif_manuel){
			foreach ($numbers as $clone_number){
				$brut=$clone_number[0][0];
				$type=$clone_number[1][0];
				$compteur=$clone_number[2][0];

				$nombre = (int)$modif_manuel_elements["clone_".$type.(string)$compteur];
				$replacements["<<$brut>>"]= $nombre;
			}
		}
		else{
		
			if($operation=="clone"){

				$nbs = array();
				foreach ($numbers as $clone_number){
					$nbs[]= "Nombre".$clone_number[2][0];
				}

				$gen_numb = generateNumbersWithConstraints($numeric_constraints, $nbs); // $gen_numb doit contenir $gen_numb[i in $numss]
				if($gen_numb==null){
					$feedbackFail = "L'algorithme n'est pas parvenu à générer des nombres qui respectent les contraintes numériques du problème... vous pouvez réessayer à nouveau.";
				}
				else{
					foreach ($numbers as $clone_number){
						$brut=$clone_number[0][0];
						$replacements["<<$brut>>"]=$gen_numb["Nombre".$clone_number[2][0]];	
					}
				}
			}
			elseif ($operation=="default"){
				foreach ($numbers as $clone_number){
					$default_value=$clone_number[3][0];
					$brut=$clone_number[0][0];
					$replacements["<<$brut>>"]=$default_value;
				}
			}
		}

		$text=$_SESSION['infos']["texteBrut"];		
		foreach($replacements as $key=>$value){
			$text=str_replace($key,$value, $text);
		}
	}

	$htmlreplacements=base64_encode(serialize($replacements));




?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Choix d'un problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body" >
	<?php require_once("headerEnseignant.php"); ?>

	<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		
			<h1><a>Untitled Form</a></h1>
					<form id="form_470585" class="appnitro" method="post" action="<?php echo $_SERVER['REQUEST_URI']?>"> <!--  method="post" action="generer_probleme.php">  IL FAUT AJOUTER ?id= &?operation=-->
						<h2>Creation d'un problème</h2>
						
						<h3>Template</h3>
						<p>
							<?php if (isset($public_notes)){
								echo "<p>".$public_notes."</p>";
							} ?>
						</p>
						<div style="width:400px;padding:10px;margin:10px;border:1px solid black">
							<?php if (isset($_SESSION['infos']['html'])){echo($_SESSION['infos']['html']);}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
						</div>

							<?php if($numeric_constraints != ""){
								echo "<h3>Contraintes numériques</h3>";
								echo "<div>";
								foreach(explode(";", $numeric_constraints) as $c){
									echo htmlspecialchars($c)."<br>";
								}
								echo "</div>";
								} ?>

							<?php if($proprietes_template != ""){
								echo "<h3>Propriétés du template</h3>";
								echo "<div>";
								foreach(explode("|||", $proprietes_template) as $p){
									echo htmlspecialchars($p)."<br>";
								}
								echo "</div>";
								} ?>
						
						<div style="width:170px;display:inline-block;margin:0 15px 5px 15px">
							<input type="button" value="utiliser les valeurs par défaut" id="Nombre" onClick="parent.location='generer_probleme.php?id=<?php echo($id);?>&operation=default'"/>
						</div>
						<div style="width:170px;display:inline-block;vertical-align:top;margin:0 15px  5px 15px">
							<input type="button" value="générer un clone de ce problème" id="perso2"  onClick="parent.location='generer_probleme.php?id=<?php echo($id);?>&operation=clone'"//>
							<br>
						</div>


					<?php
						if(isset($feedbackFail)){
							echo "<div class=error>".$feedbackFail."</div>";
						}
					?>

					<?php

					if($_SESSION['accountType'] == 'chercheur'){


						echo '<h3>Editer manuellement les valeurs modifiables</h3>';
						
						echo '<p>Soyez extrêmement vigilant lorsque vous modifiez ces valeurs manuellement. Si les valeurs que vous rentrez ne satisfont pas les contraintes numériques ou si vous remplacez un mot par plusieurs mots, cela peut causer des problèmes.</p>';

						echo "<table>";
						echo "<tr>";
							echo "<th>";
							echo "Element";
							echo "</th>";
							echo "<th>";
							echo "Valeur";
							echo "</th>";
						echo "</tr>";

						$countClones = 0;

						$clonesIn = array();
						foreach ($_SESSION['infos']['clones'] as $clone_element){
							
							$type=$clone_element[1][0];
							$compteur = $clone_element[2][0];

							$element = (string)$type.(string)$compteur;
							
							if(!(in_array($element, $clonesIn))){
								$clonesIn[] = $element;
								$search = "<<".$clone_element[0][0].">>";
								$newVal = $replacements["$search"];
								echo "<tr>";
								echo "<td>".$element."</td>";
								echo '<td><input type="text" name="clone_'.$element.'" value="'.$newVal.'"></td>';
								echo "</tr>";
							}
							
						}
						echo "</table>";
						echo '<input type="submit" value="Valider les changements manuels"/>';

					}
					?>
					<h3>Visualisation de l'énoncé tel qu'il sera vu par l'élève</h3>
					<div id="viz" style="width:360px;padding:10px;margin:10px;border:1px solid black">
						<?php //if (isset($text)){echo(utf8_encode($text));}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}
						if (isset($text)){echo(($text));}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}
						?>
					</div>

					</form>

				<form id="form2" class="appnitro" name="mainform" method="post" action="SpecificProblemSaving.php">
					<input type="submit" value="Créer le template" id="perso2"/>
					<input type="hidden" name="id" value="<?php echo($id);?>" />
					<input type="hidden" name="replacements" value="<?php echo($htmlreplacements);?>" />
					<input type="hidden" name="enonce" value="<?php echo(htmlspecialchars($text));?>" />
				
				</form>
			</div>
	</body>
</html>