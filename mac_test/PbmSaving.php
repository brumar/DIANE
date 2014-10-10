<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>
<body>
<br><br>


<?php
require_once("conn.php");

mysql_select_db($BD_base, $BD_link) or die("S&eacute;lection de la base impossible : ". mysql_error());
if ((isset($_POST['infos']))&&(!(empty($_POST['infos'])))){
	
	$infos=$_POST['infos'];
	$infos=unserialize(base64_decode($infos));
	//********MISE A JOUT DE PBM_GLOBALCONTENT******DEBUT
	$c = (!isset($infos["constraints"])) ? '' : mysql_real_escape_string($infos["constraints"]);
	$prop = (!isset($infos["properties"])) ? '' : mysql_real_escape_string(implode('|||',$infos["properties"]));
	$comp = (!isset($infos["compteurs"])) ? '' : mysql_real_escape_string(serialize($infos["compteurs"]));
	$html = (!isset($infos["html"])) ? '' : mysql_real_escape_string($infos["html"]);
	$brut = (!isset($infos["texteBrut"])) ? '' : mysql_real_escape_string($infos["texteBrut"]);
	$private = (!isset($infos["private"])) ? '' : mysql_real_escape_string($infos["private"]);
	$public = (!isset($infos["public"])) ? '' : mysql_real_escape_string($infos["public"]);
	
	//echo($brut);
	
	$sql = "INSERT INTO pbm_globalcontent (id, constraints,public_notes, compteurs, Text_html, Text_brut, properties, private_notes) VALUES (NULL, '$c', '$public', '$comp', '$html', '$brut', '$prop', '$private');";
	$result = mysql_query($sql);
	
	//********MISE A JOUT DE PBM_GLOBALCONTENT******FIN
	$index = mysql_insert_id();
	
	//renommage du dossier audio si existant avec l'identifiant du problème
	
	if(isset($infos['temp']['AUDIO'])){$location="audio/pbm_instancied/exo$index";rename($infos['temp']['AUDIO'],$location);}
	//fin
	
	
	//********MISE A JOUT DE PBM_ELEMENTS******DEBUT

	foreach ($infos['clones'] as $clone_element){		
		$type=mysql_real_escape_string($clone_element[1][0]);
		$expression=mysql_real_escape_string($clone_element[3][0]);
		$compteur=mysql_real_escape_string($clone_element[2][0]);
		$brut=mysql_real_escape_string($clone_element[0][0]);	
		$sql = "INSERT INTO pbm_elements (id, id_pbm, type, expression, compteur, brut) VALUES (NULL, $index, '$type', '$expression', '$compteur', '$brut');";
		$result = mysql_query($sql);
	}
	
	//********MISE A JOUT DE PBM_ELEMENTS******FIN
	
	
	//********MISE A JOUT DE PBM_questions******DEBUT
	
	foreach ($infos['questions'] as $i => $question_element){
		$type=mysql_real_escape_string($question_element[1][0]);
		$expression=mysql_real_escape_string($question_element[3][0]);
		$compteur=mysql_real_escape_string($question_element[2][0]);
		$brut=mysql_real_escape_string($question_element[0][0]);
		
		$sql = "INSERT INTO pbm_questions (id, id_pbm, Number, type, expression, compteur, brut) VALUES (NULL, $index,'$i' ,'$type', '$expression', '$compteur', '$brut');";
		$result = mysql_query($sql);
	//FIN TABLEAU QUESTIONS
		$idQuestion = mysql_insert_id();//recup de l'idQuestion
		
		if(isset($infos['Qinfos']['description'])){
			foreach($infos['Qinfos']['description'][$i] as $a=>$answer){
				$number=$a;
				//echo($a);
				$variable=mysql_real_escape_string($answer["variable"]);
				$keywords=mysql_real_escape_string($answer["keywords"]);
				$comments=mysql_real_escape_string($answer["comments"]);
				$properties="";
				//print_r($infos['Qinfos']["properties"]);
				if(isset($infos['Qinfos']["properties"][$i][$a])){$properties=mysql_real_escape_string(implode('|||',$infos['Qinfos']["properties"][$i][$a]));}
				
				$sql = "INSERT INTO pbm_expectedanswers (id, idQuestion, Number, variable, keywords, comments, properties) VALUES (NULL, $idQuestion,$number ,'$variable', '$keywords', '$comments', '$properties');";
				//echo($sql);
				$result = mysql_query($sql);
			}	
		}
	}
	
	//********MISE A JOUT DE PBM_Questions*****fin
	
	
	mysql_close($BD_link);
}
?>

<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
		<form id="form_470585" class="appnitro"  method="post" action="">
		<p>Votre type de problème a bien été enregistré.</p>
		<a href="PickPbm.php?id=<?php echo($index);?>">En faire une version utilisable dès maintenant</a><br><br>
		<a href="admin.php">Retour</a>
		</form>
	</div>
	
</body>
</html>