<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>upload</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
<script type="text/javascript" src="static/js/view.js"></script>

</head>
<body id="main_body" >

<?php
$SerializedHtmlprotectedInfo="";
if ((isset($_POST['infos']))&&(!(empty($_POST['infos'])))){
	//echo("aaaaaaaaa");
	$infos=$_POST['infos'];
	$infos=unserialize(base64_decode($infos));
	if (isset($infos['html'])){$text=$infos['html'];}
	$SerializedHtmlprotectedInfo=htmlspecialchars(base64_encode(serialize($infos)));
	if (isset($infos['constraints'])){$constraints=$infos['constraints'];}
	if (isset($infos['public'])){$public=$infos['public'];}
	if (isset($infos['private'])){$private=$infos['private'];}
}

if((isset($_GET['delete']))){
	$ex=$_GET['num'];
	$dossier2 = "audio/etape/exo$ex/";//prendre les caracteristiques de l'enoncé 
		if (is_dir($dossier2)){
		$dir = opendir($dossier2); 
			while($file = readdir($dir)) {
				if(($file!='.')&&($file!='..')){
				unlink($dossier2.$file);}
			}
		closedir($dir);
		rmdir($dossier2);
		}
	ob_start(); 
	$cacher=true;
?>
<u><b>DELETED</b></u><br>
<?php
    // apres 2 sec, redirection 
    header('Refresh: 5; url=creation_template.php'); 
    ob_flush();	  
    } 

//if((isset($_FILES['doc'])&&(isset($_POST['numexo']))))
if(isset($_POST['numexo'])){
	$fichier = 	array();
	$fichier =$_FILES['doc'];
	$dossier = '.\\upload\\';
	$ex=$_POST['numexo'];	
	$dossier2 = "audio/pbm_instancied/exo$ex/";//prendre les caracteristiques de l'enoncé 
	if (is_dir($dossier2)){ //suppression du dossier
			$dir = opendir($dossier2); 
			while($file = readdir($dir)) {
				if(($file!='.')&&($file!='..')){
				unlink($dossier2.$file);}
			}
			closedir($dir);
			rmdir($dossier2);
		}
	sleep(2);//pour attendre que le serveur capte qu'on lui a supprimé le dossier en question
	
	if (!mkdir($dossier2, 0777)) { //creation 'du dossier if (!mkdir($dossier2, 0777,true))
	die('Echec lors de la création des répertoires...'.$dossier2); //is dir ; unlink
	}
	$echec=false;
	$t=count($fichier['name']);
	echo("<br>");
	for($i=0; $i<$t; $i++) { //}
		$name=$fichier['name'][$i];
		$tmp_name=$fichier['tmp_name'][$i];
		
		$fichier2 = basename($name);
		$extensions = array('.mp3');
		$extension = strrchr($name, '.'); 
//Début des vérifications de sécurité...
		if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
		{$erreur = 'Vous devez uploader un fichier mp3';}
		if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
		{
			$fichier2 = strtr($fichier2, 
           'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          ' AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier2 = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier2);
				if(!(move_uploaded_file($tmp_name, $dossier2.$fichier2))) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
				{ $echec=true;}
		}
	 }
	 if(!($echec)){
    ob_start(); // avant toute chose
	$cacher=true;
?>

 <u><b>REUSSITE</b></u><br>


<?php
    $renvoi=true;
	
  
    
}
else
{
     echo $erreur;
}

//mise à jour d'infos

if (isset($_POST['infos'])){
	$audiolocation="audio/pbm_instancied/exo$ex/";
	$infos['temp']['AUDIO']=$audiolocation;
	$SerializedHtmlprotectedInfo=htmlspecialchars(base64_encode(serialize($infos)));

}

}

//if(!((isset($cacher))&&($cacher))){
ini_set("post_max_size", "30M");
ini_set("upload_max_filesize", "30M");
ini_set("memory_limit", -1 );
?>

	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
		<h2>Ajoutez des fichiers audio</h2>
		<form method="post" name="realform" action="creation_template.php">
		<input type="hidden" name="infos" value="<?php if(isset($SerializedHtmlprotectedInfo)){echo($SerializedHtmlprotectedInfo);}?>"/>
		</form>
		<form method="POST" class="appnitro" action="upload.php" enctype="multipart/form-data">
		<ul >
					<li id="li_1" >
     <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	 <input type="hidden" name="numexo" value="<?php $id=uniqid();echo($id);//temporaire?>">
	 <input type="hidden" name="infos" value="<?php if(isset($SerializedHtmlprotectedInfo)){echo($SerializedHtmlprotectedInfo);}?>"/>
	 <input type="file" name="doc[]" width="300"><br> 
	 <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
     <input type="file" name="doc[]" width="300"><br>
	 <input type="file" name="doc[]" width="300"><br>
     <input type="file" name="doc[]" width="300"><br>
     <input type="submit" name="envoyer" value="Envoyer les fichiers">
     <p class="guidelines" id="guide_1"><small><b><u>Note : </u></b><br>L'ordre alphabétique de vos mp3 determinera leur ordre d'apparition dans l'exercice.<br>
Par exemple : phrase1.mp3, phrase2.mp3, phrase3.mp3<br><br>
Si un passage correspond à une question, Ajoutez "-Qx" au nom du fichier, avec x le numéro de la question.
Cela permettra au programme de mieux comprendre le comportement de l'élève, ainsi que de supprimer cette question si désiré (dans le cas ou elle serait facultative)<br>
<u>Par exemple :</u> si part2.mp3 correspond à la première question de votre énoncé, renommez-là part2-QI.mp3 <br></small></p> 
</li></ul>
</form></div>
<?php 
if((isset($renvoi)&&($renvoi))){
sleep(3);
echo("<script type=\"text/javascript\">
		document.realform.submit();
		</script>");
}

?>
	</body>
	
</html>