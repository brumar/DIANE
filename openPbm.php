<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	
	if (isset($_GET["id"])){ // TODO : Réflexion.. niveau sécurité, je sais pas si c'est une très riche idée ça, de mettre un id dans l'URL
			$id=$_GET["id"];
	}
	else{
		header("location: copier_template.php");
		exit();
	}
	
	//note : prend en entrée $id, ressort $infos et $infoshtml	
	
	//mysql_query("SET NAMES UTF8");
	$infos=array();
	//$result = mysql_query("SELECT * FROM pbm_globalcontent WHERE id=$id");
	$req = $bdd->prepare("SELECT * FROM pbm_template WHERE id=?");
	$result = $req->execute(array($id));

	while (($result) &&($row = $req->fetch()))
	{
		$infos["constraints"]=$row['constraints'];
		$infos["public"]=$row['public_notes'];
		$infos["compteurs"]=$row['compteurs'];
		$infos["html"]=$row['Text_html'];
		$infos["texteBrut"]=$row['Text_brut'];
		$infos["properties"]=explode('|||',$row['properties']);
		$infos["private"]=$row['private_notes'];
	
	}
	$req->closeCursor();
	//diane_these.pbm_elements (id, id_pbm, type, expression, compteur, brut)
	$clones=array();
	//$result = mysql_query("SELECT * FROM pbm_elements WHERE id_pbm=$id");

	$req = $bdd->prepare("SELECT * FROM pbm_elements WHERE idTemplate=?");
	$result = $req->execute(array($id));

	$c=0;
	while(($result) &&($row = $req->fetch()))
	{
		//echo("T");
		$clone=array();
		$clone[0][0]=$row['brut'];
		$clone[1][0]=$row['type'];
		$clone[2][0]=$row['compteur'];
		$clone[3][0]=$row['expression'];		
		$clones[$c]=$clone;
		
		$c++;
	}
	$infos['clones']=$clones;
	$req->closeCursor();
	
	//$sql = "INSERT INTO diane_these.pbm_questions (id, id_pbm, Number, type, expression, compteur, brut) VALUES (NULL, $index,'$i' ,'$type', '$expression', '$compteur', '$brut');";
	//$result = mysql_query("SELECT * FROM pbm_questions WHERE id_pbm=$id");
	$questions=array();
	$req = $bdd->prepare("SELECT * FROM pbm_questions WHERE idTemplate=?");
	$result = $req->execute(array($id));

	$idQuestions=array();
	$c=0;
	while(($result) &&($row = $req->fetch()))
	{
		//echo("T");
		$question=array();
		$question[0][0]=$row['brut'];
		$question[1][0]=$row['type'];
		$question[2][0]=$row['compteur'];
		$question[3][0]=$row['expression'];
		$idQuestions[]=$row['id'];
		$questions[$c]=$question;
		$c++;
	}
	$infos['questions']=$questions;
	$req->closeCursor();

	//$c correpond maintenant aux nombres de questions dans le problème, ce qui est utile pour la suite
	
	//$sql = "INSERT INTO diane_these.pbm_expectedanswers (id, idQuestion, Number, variable, keywords, comments, properties) VALUES (NULL, $idQuestion,$number ,'$variable', '$keywords', '$comments', '$properties');";
	$Qinfo=array();
	foreach($idQuestions as $i=>$idquestion) {
		//echo($idquestion);
		//$result = mysql_query("SELECT * FROM pbm_expectedanswers WHERE idQuestion=$idquestion");

		$req = $bdd->prepare("SELECT * FROM pbm_expectedanswers WHERE idQuestion=?");
		$result = $req->execute(array($idquestion));

		$t=0;
		while(($result) && ($row = $req->fetch()))
		{
			//echo("IN");
			$Qinfo['description'][$i][$t]['variable']=$row['variable'];
			$Qinfo['description'][$i][$t]['keywords']=$row['keywords'];
			$Qinfo['description'][$i][$t]['comments']=$row['comments'];
			$Qinfo['properties'][$i][$t]=explode('|||',$row['properties']);
			$t++ ;
		}
	}
	$infos['Qinfos']=$Qinfo;
	$req->closeCursor();
	
	$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	
	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<form name="form2pbmcreation" method="post" action="creation_template.php">
			<input id="element_8" type="hidden" name="infos" type="text" maxlength="255" value=""/> 
		</form>

		<?php
		if (isset($_GET["id"])){
			
			$id=$_GET["id"];
			//if(isset($infos['questions'][0][3][0])){echo("ok");}
			
			echo("<script type=\"text/javascript\">
			document.form2pbmcreation.infos.value=\"$infosHtmlProtected\";
			document.form2pbmcreation.submit();	
				</script>");
			//print_r($infos);
			
		}
		?>
	</body>	
</html>