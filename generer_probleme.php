<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");
	$id=0;
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
	$operation="default";
	if(isset($_GET['operation'])){
		$operation=$_GET['operation'];//vaut 'clone' ou 'défaut'
	}

	require_once("opening.php"); //note : prend en entrée $id, ressort $infos et $infoshtml	

	$replacements=array();
	foreach ($_SESSION['infos']['questions'] as $questions){
		$b=$questions[0][0];
		$r=$questions[3][0];
		$search="[[$b]]";
		$replacements["$search"]=$r;
		//print_r($replacements);
	}


	//$compteur_nombre = (int)$compteur_tab['Nombre'] - 1;
	
	$numeric_constraints = get_value_BDD('constraints', 'pbm_template', 'id=?', array($id), $bdd);
	$public_notes = get_value_BDD('public_notes', 'pbm_template', 'id=?', array($id), $bdd);
	$proprietes_template = get_value_BDD('properties', 'pbm_template', 'id=?', array($id), $bdd);

	$numbers = array();

	foreach ($_SESSION['infos']['clones'] as $clone_element){
		
		$type=$clone_element[1][0];
		// echo $type;
		// echo "<br>";

		if($type=="Nombre") { //On se contente de récupérer tous les nombres dans un premier temps
			$numbers[]=$clone_element;
		}
		else{
			$expression=$clone_element[3][0];
			$compteur=$clone_element[2][0];
			$brut=$clone_element[0][0];
			$search="<<$brut>>";

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

			else{
				$replacements["$search"]=$expression;
			}
		}
	}



	// Gestion des nombres
	if($operation=="clone"){
		//TODO : On génère désormais les nombres en respectant les contraintes numériques
		$nbs = [];
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

		// foreach ($numbers as $clone_number){

		// 	$numss[]= "Nombre".$clone_number[2][0];

		// 	$brut=$clone_number[0][0];
		// 	$pick=rand(3,20);
		// 	$replacements["<<$brut>>"]=$pick;	
		// }

		
	}
	else{
		foreach ($numbers as $clone_number){
			$default_value=$clone_number[3][0];
			$brut=$clone_number[0][0];
			$replacements["<<$brut>>"]=$default_value;
		}
	}
	
	

	$text=$_SESSION['infos']["texteBrut"];
	/*str_replace('<<','', $text);
	str_replace('>>','', $text);
	str_replace('[[','', $text);
	str_replace(']]','', $text);*/
	//echo($text);
	foreach($replacements as $key=>$value){
		//echo($key." for ". $value ."<br>");
		$text=str_replace($key,$value, $text);
	}
	$htmlreplacements=base64_encode(serialize($replacements));
	//$text=htmlentities($text, ENT_QUOTES, 'UTF-8');

	//var_dump(htmlentities(print_r($replacements, true)));
	// var_dump(unserialize(base64_decode($htmlreplacements)));

	// <input type="hidden" name="id" value="<?php echo($id);" />
	// 	<input type="hidden" name="replacements" value="<?php echo($htmlreplacements);" />
	// 	<input type="hidden" name="enonce" value="<?php echo(htmlspecialchars($text));>" />






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
					<form id="form_470585" class="appnitro" name="mainform" method="post" action="SpecificProblemSaving.php">
						<div class="form_description">
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
			
					<h3>Visualisation de l'énoncé tel qu'il sera vu par l'élève</h3>
					<div id="viz" style="width:360px;padding:10px;margin:10px;border:1px solid black">
						<?php //if (isset($text)){echo(utf8_encode($text));}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}
						if (isset($text)){echo(($text));}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}
						?>
					</div>
					<input type="submit" value="valider" id="perso2"/>
					<input type="hidden" name="id" value="<?php echo($id);?>" />
					<input type="hidden" name="replacements" value="<?php echo($htmlreplacements);?>" />
					<input type="hidden" name="enonce" value="<?php echo(htmlspecialchars($text));?>" />
					</div>
					</form>
					</div>
	</body>
</html>