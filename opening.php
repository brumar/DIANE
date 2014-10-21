<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
</head>
<body>
<?php
	//note : prend en entrée $id, ressort $infos et $infoshtml	
	require_once("conn.php");
	//mysql_query("SET NAMES UTF8");
	$infos=array();
	$result = mysql_query("SELECT * FROM pbm_globalcontent WHERE id=$id");
	while (($result) &&($row = mysql_fetch_array($result)))
	{
		$infos["constraints"]=$row['constraints'];
		$infos["public"]=$row['public_notes'];
		$infos["compteurs"]=$row['compteurs'];
		$infos["html"]=$row['Text_html'];
		$infos["texteBrut"]=$row['Text_brut'];
		$infos["properties"]=explode('|||',$row['properties']);
		$infos["private"]=$row['private_notes'];
	
	}
	//diane_these.pbm_elements (id, id_pbm, type, expression, compteur, brut)
	$clones=array();
	$result = mysql_query("SELECT * FROM pbm_elements WHERE id_pbm=$id");
	$c=0;
	while(($result) &&($row = mysql_fetch_array($result)))
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
	
	
	//$sql = "INSERT INTO diane_these.pbm_questions (id, id_pbm, Number, type, expression, compteur, brut) VALUES (NULL, $index,'$i' ,'$type', '$expression', '$compteur', '$brut');";
	$questions=array();
	$result = mysql_query("SELECT * FROM pbm_questions WHERE id_pbm=$id");
	$idQuestions=array();
	$c=0;
	while(($result) &&($row = mysql_fetch_array($result)))
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
	//$c correpond maintenant aux nombres de questions dans le problème, ce qui est utile pour la suite
	
	//$sql = "INSERT INTO diane_these.pbm_expectedanswers (id, idQuestion, Number, variable, keywords, comments, properties) VALUES (NULL, $idQuestion,$number ,'$variable', '$keywords', '$comments', '$properties');";
	$Qinfo=array();
	foreach($idQuestions as $i=>$idquestion) {
		//echo($idquestion);
		$result = mysql_query("SELECT * FROM pbm_expectedanswers WHERE idQuestion=$idquestion");
		$t=0;
		while(($result) && ($row = mysql_fetch_array($result)))
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
	
	$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));

	?>
	</body>
	</html>