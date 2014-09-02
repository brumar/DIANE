<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix d'un problème</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
</head>
<body id="main_body" >

<?php
$id=0;
if(isset($_GET['id'])){
	$id=$_GET['id'];
}
$operation="default";
if(isset($_GET['operation'])){
	$operation=$_GET['operation'];//vaut 'clone' ou 'défaut'
}

include("opening.php");

//$infosHtmlProtected
//$infos

$replacements=array();
foreach ($infos['questions'] as $questions){
	$b=$questions[0][0];
	$r=$questions[3][0];
	$search="[[$b]]";
	$replacements["$search"]=$r;
	//print_r($replacements);
}
foreach ($infos['clones'] as $clone_element){
	
	$expression=$clone_element[3][0];
	$compteur=$clone_element[2][0];
	$brut=$clone_element[0][0];
	$type=$clone_element[1][0];
	$search="<<$brut>>";
	
	if($type!="Nombre"){
		
		if($operation=="clone"){
			$result = mysql_query("SELECT * FROM clone_$type");
			$total=mysql_num_rows($result);
			$pick=rand(0,$total);
			$result = mysql_query("SELECT * FROM clone_$type WHERE id=$pick");
			$t=mysql_fetch_array($result);
			
			$replacements["$search"]=$t[$type];}
		else{
			$replacements["$search"]=$expression;
		}
		
	}
	else {
		if($operation=="clone"){
			$pick=rand(3,20);
			$replacements["<<$brut>>"]=$pick;
			}
		else{
			$replacements["<<$brut>>"]=$expression;
			}
	}
}
$text=$infos["texteBrut"];
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
mysql_close($BD_link);
?>

<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
				<form id="form_470585" class="appnitro" name="mainform" method="post" action="SpecificProblemSaving.php">
					<div class="form_description">
					<h2>Creation d'un problème</h2>
					<h3>Template</h3>
			<div style="width:400px;padding:10px;margin:10px;border:1px solid black">
				<?php if (isset($infos['html'])){echo($infos['html']);}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
			</div>
				<div style="width:170px;display:inline-block;margin:0 15px 5px 15px">
					<input type="button" value="utiliser les valeurs par défaut" id="Nombre" onClick="parent.location='PickPbm.php?id=<?php echo($id);?>&operation=default'"/>
				</div>
				<div style="width:170px;display:inline-block;vertical-align:top;margin:0 15px  5px 15px">
					<input type="button" value="générer un clone de ce problème" id="perso2"  onClick="parent.location='PickPbm.php?id=<?php echo($id);?>&operation=clone'"//>
					<br>
				</div>
		
				<h3>Visualisation de l'énoncé tel qu'il sera vu par l'élève</h3>
				<div id="viz" style="width:360px;padding:10px;margin:10px;border:1px solid black">
					<?php if (isset($text)){echo(utf8_encode($text));}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
				</div>
				<input type="submit" value="valider" id="perso2"/>
				<input type="hidden" name="id" value="<?php echo($id);?>" />
				<input type="hidden" name="replacements" value="<?php echo($htmlreplacements);?>" />
				<input type="hidden" name="text" value="<?php echo(htmlspecialchars($text));?>" />
				</div>
				</form>
				</div>
</body>
</html>