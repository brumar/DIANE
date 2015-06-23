<?php
	require_once("verifSessionProf.php");

	//note : prend en entrée $id, ressort $infos et $infoshtml	
	require_once("conn_pdo.php");
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