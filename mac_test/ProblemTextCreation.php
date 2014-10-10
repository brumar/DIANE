
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>énoncé</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="userscript.js"></script>
<script type="text/javascript" src="scripts_enonce.js">
</script>

<?php 

function js_str($s) //functions to turn php array into js array
{
	return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}

function js_array($array)
{
	$temp = array_map('js_str', $array);
	return '[' . implode(',', $temp) . ']';
}
function cloner($informations_clones,$copieEnonce){
	$defaultValue=true;
	$liste_clones_parcourus=array();
	foreach ($informations_clones as $i => $infoClone){//on effectue un double parcours pour identifier les répétitions
		$listeRepetition=array();
		$listeRepetition[]=$infoClone;
		$type=$infoClone[1][0];
		//echo($i." pour ".$type."<br>");
		if(!in_array($type,$liste_clones_parcourus)){//on verifie que le clône n'est pas déjà traité
			$liste_clones_parcourus[] = $type;
			//on construit un tableau qui va contenir les répétitions
			for ($j = $i+1; $j <= count($informations_clones)-1; $j++) {//on effectue un double parcours pour identifier les doubles
				$infoClone2=$informations_clones[$j];
				$typeClone2=$infoClone2[1][0];
				if($typeClone2==$type){
					if($infoClone[2][0]==$infoClone2[2][0]){
						//echo("same number");
						$listeRepetition[]=$infoClone2;
					}
					else{
						$clone=findClone($type);

						//echo("replaceByClone[".$copieEnonce.",".$clone.",".$infoClone[0][0]."]<br>");
						$copieEnonce=replaceByClone($copieEnonce,$clone,$infoClone2);//si le clone n'a pas le même numéro on effectue le remplacement tout de suite
						
					}
				}
			}
			$clone=findClone($type);//on utilise le même clone pour les clones avec le même numero, cette liste contient au moins infoClone
			foreach ($listeRepetition as $i => $infoClone){
				//echo("replaceByClone[".$copieEnonce.",".$clone.",".$infoClone[0][0]."]<br>");
				$copieEnonce=replaceByClone($copieEnonce,$clone,$infoClone);
				
			}		
		}
	}
	//$r=htmlspecialchars($copieEnonce);
	//echo($r);
	return($copieEnonce);
}
function findClone($type){
	if($type=="Nombre"){
		return rand(0,20);
	}
	else{
		return "exemplaire".$type;
	}
}

function getInformations($content,$erreur){
	//echo($content);
	$pattern= '#(^[a-zA-Z]*)\(([0-9]*)\)=(.*)#';//les parenthèses capturantes récupèrent l'essentiel de informations de l'élément
	$c=preg_match_all($pattern,$content, $Inf);
	if($c==0){
		echo("erreur : '".$content."' n'est pas reconnu");//permet de vérifier que l'interieur du clone est syntaxiquement correct
		$erreur=$content."' n'est pas reconnu";
		return null;
	}
	//echo($Inf[3][0]);
	return($Inf);
}


function replaceByClone($copieEnonce,$clone,$infoClone){
	//echo($clone." par ");

	$rep="<<".$infoClone[0][0].">>";
	//$r=htmlspecialchars($rep);
	//echo($r."<br>");
	
	
	//$r=htmlspecialchars($copieEnonce);
	$r=htmlspecialchars($copieEnonce);
	$htmlpart='<font color="grey">'.$infoClone[3][0].'</font><font color="blue"> ('.$infoClone[1][0].$infoClone[2][0].')</font>';//<span style="color:green;">';('.$infoClone[3][0]
	$copieEnonce=str_replace($rep,$htmlpart,$copieEnonce);
	//echo($r);
	return($copieEnonce);
	//echo($copieEnonce);
}

function soulignerQuestions($informations_questions,$copieEnonce){
	//print_r($informations_questions);
	//$rep="[[".$informations_questions[0][0]."]]";
	$element1="[[".str_replace($informations_questions[3][0],'',$informations_questions[0][0]);
	//echo($element1);//à remplacer par <br><u><i>
	$replacement_1="<br><u><i>";
	$element2="]]";//à remplacer par </i></u>
	$replacement_2="</i></u>";
	//$r=htmlspecialchars($copieEnonce);
	//$htmlpart='<br><u><i>'.$informations_questions[3][0].'</i></u>';//font><font color="blue"> ('.$infoClone[1][0].$infoClone[2][0].')</font>';//<span style="color:green;">';('.$infoClone[3][0]
	$copieEnonce=str_replace($element1,$replacement_1,$copieEnonce);
	$copieEnonce=str_replace($element2,$replacement_2,$copieEnonce);
	//echo($r);
	return($copieEnonce);	
}
                         
function SyntaxicVerification($tStart,$tEnd,$start,$end,$tIntrus,$intrus){
	$erreur=false;
	if((count($tStart))!=(count($tEnd))){
		$mess="erreur : pas autant de caractere ' ".$start." ' que de caractère ' ".$end." '";
		$erreur=true;
		$mess=htmlspecialchars($mess);
		echo($mess."<br>");
		return false;
		//print($mess);
		}
		else{
			foreach ($tStart as $c => $positionStart){
				$positionEnd=$tEnd[$c];//permet de connaitre la position du prochain caractère fermant correspondant
				foreach ($tIntrus as $i => $positionIntru){
					if(($positionIntru>$positionStart)&&($positionIntru<$positionEnd)){
						$postru=strval($positionIntru);
						$mess="Erreur : ' ".$intrus." ' entre ' ".$start." ' et ' ".$end." ' à la position ".$postru;
						$erreur=true;
						$mess=htmlspecialchars($mess);
						echo($mess."<br>");
					}
				}

			}
		}
	return $erreur;
}

function search_expression($separateur,$expression){
	$SepPositions=array();
	$k=0;
	$tab= str_split($expression);
	foreach ($tab as $key => $c){
		if($c==$separateur){
			if((!empty($tab[$key+1]))&&($tab[$key+1]==$separateur)){
				//$message=$separateur.'  @  '.$key;
				//echo($message);
				//echo('<br>');
				$SepPositions[$k]=$key;
				$k++;
			}
		}
	}
	return $SepPositions;
}



?>
</head>
<body id="main_body" >
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>


<?php 



$infos=array();
$infosHtmlProtected='';
$textBrut='';
$text='';
$listesInit=array("Quest","Nombre","Variable","homme","femme" );//liste par défaut
$liste=$listesInit;


$initcompteur='var compteur = { "Quest" : 1, "Nombre" : 1, "homme" : 1,"femme" : 1};';
$startcompteur='var startcompteur = { "Quest" : 1, "Nombre" : 1, "homme" : 1,"femme" : 1};';

$compteursExtra=array();

if(isset($_POST['TabExtras'])){
	$mess2=$_POST['TabExtras'];
	if($mess2!=""){
		$compteursExtra=explode('||',$mess2);
	}
	//print_r($compteursExtra);
}

if(isset($_POST['infos'])){

	$infos=$_POST['infos'];
	$infos=unserialize(base64_decode($infos));
	$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));
	$textBrut='';
	if(isset($infos['texteBrut'])){
		$textBrut=$infos['texteBrut'];}
	if(isset($_POST['enonce'])){//priorité à enoncé
		$textBrut=$_POST['enonce'];}
	//echo($infosHtmlProtected);
	if(isset($infos['html'])){
		$text=$infos['html'];}

	if(isset($infos['compteurs'])){
//print_r($infos['compteurs']);
		$compteurs=$infos['compteurs'];
		$listes=array();
		$initcompteur='var compteur = { ';
		$virgule='';
		$needVirgule=false;//variable permettant de mettre des virgules là ou c'est necessaire
		
		foreach($compteurs as $k=>$compteur ){

			if($needVirgule){$virgule=', ';}
			$listes[]=$k;
			$initcompteur.=$virgule.'"'.$k.'" : ';
			$initcompteur.=$compteur;
			$needVirgule=true;
		}
		//$compteursExtra
		
		$needVirgule=false;//variable permettant de mettre des virgules là ou c'est necessaire
		
		foreach($compteursExtra as $e=>$CompteurExtra ){

			if($needVirgule){$virgule=', ';}

			$listes[]=$CompteurExtra;
			$initcompteur.=$virgule.'"'.$CompteurExtra.'" : ';
			$initcompteur.="1";
			$needVirgule=true;
		}
		
		$initcompteur.='};';
		//echo($initcompteur);
	}
	if((empty($compteursExtra))&&(isset($infos['compteurs']))){//permet de remettre les boutons si on vient de ProblemTextCreation
	$compteursExtra=array_diff($listes,$listesInit);
	//print_r($compteursExtra);
	//echo("<br>compteurs");print_r($listes);
	//echo("<br>listInit");print_r($listesInit);
	//echo("<br>difference");print_r($compteursExtra);
}
	//print_r($listes);
/*	print_r($infos['compteurs']);
	print_r($listes);
	
	print_r($compteursExtra);*/
//}
}


//$listes=array("Quest","Nombre","Variable","homme","femme" );//"Quest,Nombre" : 1, "Variable" : 1, "homme" : 1,"femme" : 1};

$self=$_SERVER['PHP_SELF'];
if (isset($_POST['enonce'])){
	
	$enonce=($_POST['enonce']);
	
	$clones_start='<';
	$clones_end='>';
	$questions_start='[';
	$questions_end=']';
	
	$tab_clones_start=search_expression($clones_start,$enonce);//contiennent les tableaux de la position des séparateurs
	$tab_clones_end=search_expression($clones_end,$enonce);
	$tab_questions_start=search_expression($questions_start,$enonce);
	$tab_questions_end=search_expression($questions_end,$enonce);
	
	//on rechercher les erreurs syntaxiques, c'est à dire des caractère ouvrant '<<' suivis par des caractères "intrus" précédant le caractère 
	$erreur=false;
	$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_start,"[[");//on effectue des vérification de syntaxes
	$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_end,"]]");
	$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_start,"<<");
	$erreur=SyntaxicVerification($tab_questions_start,$tab_questions_end,"[[","]]",$tab_questions_start,"[[");
	

	
	$tabTemp=array();

	if(!$erreur){
		$copieEnonce=$enonce;
		$informations_clones=array();
		foreach ($tab_clones_start as $c=> $PstartClone){//on parcourt l'ensemble des clones
			$PendClone=$tab_clones_end[$c];
			$start=$PstartClone+2;
			$end=$PendClone;
			$length=$end-$start;
			$content=substr($copieEnonce,$start,$length);//on récupère le contenu de l'expression
			$tabTemp=getInformations($content,$erreur);//on récupère dans un tableau les informations liées aux clones, on récupère aussi les erreurs s'il y en a
			if($tabTemp!=null){
				$tabTemp["start"]=$PstartClone;
				$tabTemp["end"]=$PendClone;//on rajoute dans ce tableau les informations concernant la position du clone
				$informations_clones[$c]=$tabTemp;//on récupère l'ensemble de ces informations dans un tableau général
			}
			print_r($informations_clones);
		}
		$text=cloner($informations_clones,$copieEnonce);//ON utilise ce tableau général pour cloner l'ensemble
	}
	if(!$erreur){//même fonctionnement que predemment
		$copieEnonce=$enonce;
		$informations_questions=array();
		foreach ($tab_questions_start as $c=> $Pstartquestion){//
			$Pendquestion=$tab_questions_end[$c];
			$start=$Pstartquestion+2;
			$end=$Pendquestion;
			$length=$end-$start;
			$content=substr($copieEnonce,$start,$length);
			$tt=htmlspecialchars($content);
			//echo($tt);
			//echo('compteur :'.$c.'');
			$tabTemp=getInformations($content,$erreur);
			if($tabTemp!=null){
				$tabTemp["start"]=$Pstartquestion;
				$tabTemp["end"]=$Pendquestion;
				$informations_questions[$c]=$tabTemp;
			}
			$text=soulignerQuestions($tabTemp,$text);
		}
		//$text=soulignerQuestions($informations_questions,$text);
	}
	// RECUPERATION DES COMPTEURS -  DEBUT
	
	$cptrs=array();
	foreach($_POST as $key => $var){
		//echo($key);
		$temp=$key;
		$radical=substr($temp,0,9);
		if($radical=="compteur_"){
		$idcompteur=str_replace($radical,'',$key);
		$cptrs[$idcompteur]=$var;
		
}
	
	}
	
	// RECUPERATION DES COMPTEURS -  FIN
	
	//print_r($cptrs);
	
	
	$infos['compteurs']=$cptrs;
	$infos['html']=$text;
	$infos['questions']=$informations_questions;
	$infos['texteBrut']=$enonce;
	$infos['clones']=$informations_clones;
	$SerializedEnonceINFOS=base64_encode(serialize($infos));
	
	if(isset($_POST['envoi'])){
		$action=$_POST['action'];
		$infosHtmlProtected=htmlspecialchars($SerializedEnonceINFOS);
		//$SerializedEnonceINFO=htmlspecialchars($SerializedEnonceINFOS);
		//echo($SerializedEnonceINFOS);
		echo('<form name="VraiEnvoi" method="post" action="'.$action.'"><input type="hidden" name="infos" value="'.$infosHtmlProtected.'"/>
</form><script language="javascript">document.VraiEnvoi.submit();</script>');//<script language="javascript">document.VraiEnvoi.submit();</script>
	}
	
}




/*
while($boucle1){
$pattern_degre_2='/<<.*<<(.*)>>.*>>/';
preg_match_all($pattern_degre_2,$enonce, $matches);

}

while($boucle2){

}

$pattern_QI = '/\[(.*)\]/';//$pattern_QI = '/\[([^(\]\])]*)\]/';
preg_match_all($pattern_QI,$enonce, $QI);
print_r($QI[1]);//tableau contenant les expressions


$pattern_clone =  '/<<(.*)>>/';
preg_match_all($pattern_clone,$enonce, $clones);
print_r($clones);
}

$chaine = 'ABCD071';
echo $chaine[3];
*/
?>

	<form name="form1" id="form1" class="appnitro" method="post" action="<?php echo($self); ?>">
			<input name="action" type="hidden" value="ProblemCreation.php">
			<h2>Enregistrez votre &eacutenonc&eacute </h2>
						<h3>Zone d'écriture</h3>
			<ul>
				<li id="li_1" >

				<div><textarea id="textarea" name="enonce" class="element textarea medium"  ><?php if (isset($textBrut)){echo($textBrut);}?></textarea>
				</div><p class="guidelines" id="guide_1"><small>Cette zone de texte vous permet de rentrer votre énoncé. 
				Les commandes d'insertions sont reservées aux utilisateurs formés voulant utiliser les fonctionnalités avancées de DIANE. </small></p>
			
			
			</ul>
	
		<div class="commandWrap">
			<h3>commandes</h3>
				<div style="width:100px;display:inline-block;margin:0 0 5px 40px">
					<h4>Insertions</h4><input type="button" value="question" id="Quest"/>
					<input type="button" value="nombre" id="Nombre"/>
					<!--  <input type="button" value="variable" id="Variable"/>-->
					<input type="button" value="prénom masculin" id="homme"/>
					<input type="button" value="prénom féminin" id="femme"/><br><br>
				</div>
				<div style="width:100px;display:inline-block;vertical-align:top;margin:0 0 5px 40px">		
					<h4>Général</h4>
					<!--<input type="submit" value="PARSE ME"> -->
					<input type="button" value="réinitialiser" id="reinit"/>
					<input type="submit" value="visualisation" id="apperçu"/>
					<input type="hidden" name="infos" value="<?php if (isset($infosHtmlProtected)){echo($infosHtmlProtected);}?>"/>
					<br>
					<input type="button" value="valider" id="apperçu" onclick="GoToProblemCreation();"/>
				</div>
				<div style="width:100px;vertical-align:top;margin:0 0 5px 40px">		
					<h4>Insertions personalisées</h4>
					<input type="button" value="ajouter" id="perso2" onclick="GoToInsertion();"/>
					<?php foreach($compteursExtra as $compteur){
					echo("<input type=\"button\" value=\"$compteur\" id=\"$compteur\"/>");
					}?>
	
	</form>

	<form  id="form2" name="formulaireEnvoi" method="post" action="ProblemTextCreation.php"><!-- isset($EnonceINFOS) -->
	<input type="hidden" name="infos" >
	<input type="hidden" name="action" value="ProblemCreation.php">
	<input type="hidden" name="envoi" value="true" >
	<input type="hidden" name="enonce" > <!--     si l'utilisateur appuie sur envoyer, les données sont traitées avant d'envoyer les infos sur ProblemCreation.php -->

	</form>	</div>
				
					
					
				</div>
			</ul>
			


	

	
				<h3>Visualisation</h3>
				<div id="viz" style="width:360px;padding:10px;margin:10px;border:1px solid black">
					<?php if (isset($text)){echo($text);}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
				</div>

	</div>
	</body>
	
	<!--
	<input type="button" value="Envoyer" name="B1" onclick="verifForm(this.form)" />
    <input type="reset" value="Effacer tout" name="B2" />-->
	
	
    </div>
	<div align="left">
	<?php
	if(isset($infosHtmlProtected)){

	echo('<script>document.formulaireEnvoi.infos.value="'.$infosHtmlProtected.'";</script>');
}


if(isset($_POST['message'])){
	$mess=$_POST['message'];
	echo("<script>alert(\"$mess\");</script>");
}



	// if (isset($text)){echo("apperçu du résultat<br>".$text);}
	?>
	</div>
	<script>

	
	
	var Quest = document.getElementById('Quest');
	
	<?php echo($initcompteur);?>//contient quelque chose comme : var compteur={ "Quest" : 1, "Nombre" : 1, "Variable" : 1, "homme" : 1,"femme" : 1}
	<?php echo($startcompteur);?>
	<?php echo 'var compteursExtras = ', js_array($compteursExtra), ';';?>
	
	for(var i in compteur){//gestion des clicks sur commandes
		element=document.getElementById(i);		

		//ajout des champs - DEBUT
		
		document.getElementById('form2').innerHTML += "<input type='hidden' name='compteur_"+i+"' id='IDcompteur_"+i+"'value='"+compteur[i]+"' />";
		
		//ajout des champs - FIN
		
		if(((compteursExtras.length!=0 && compteursExtras.indexOf(i.toString())!=-1))
				||(startcompteur.hasOwnProperty(i.toString()))){
			
			addEvent(element, 'click', function(e) {
				var target = (e.srcElement || e.target);
				var id=target.id;
				
	
			if(id=="Quest"){
				var separateur_start="[[";
				var separateur_end="]]";
				}
			else{
				var separateur_start="<<";
				var separateur_end=">>";
			}
			startTag=separateur_start+id+"("+compteur[id]+")=";
			endTag=separateur_end;
			
			
			insertTag(startTag, endTag, "textarea", "");
			compteur[id]+=1;
	
			var name_compteur="IDcompteur_"+id;
			document.formulaireEnvoi[name_compteur].value=compteur[id];
			});
		}
	}
	
	var reinit=document.getElementById("reinit");
	addEvent(reinit, 'click', function(e) {
	document.getElementById("textarea").value="";
	compteur = { "Quest" : 1, "Nombre" : 1, "Variable" : 1, "homme" : 1,"femme" : 1};
	document.getElementById("viz").innerHTML="";
	
	for(var t in compteur){
		element=document.getElementById(t);	
		
		var id=element.id;
		
		var name_compteur="IDcompteur_"+id;
		alert(name_compteur);
		document.formulaireEnvoi[name_compteur].value=1;}
			});
	
	
	</script>
	<!--
	//var textArea = document.getElementById('textarea');
	
	//addEvent(QI, 'click', function(e) {
	//document.write('<p>'+id+ '</p>');
	document.write('<p>dadada</p>');
   var target = (e.srcElement || e.target);
	
	//target.dewplay();
	var id=target.id;
	startTag="["+id+"]";
	endTag="["+id+"/]";
	tagType="";
	insertTag(startTag, endTag, "textarea", tagType);

   // }
	
	);
}
	
	</script>!-->
	
</body>

</html>
