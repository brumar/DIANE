<html>
<head></head>
<body>
<?php

if((isset($_GET['delete']))){
	$ex=$_GET['num'];
	$dossier2 = "audio/complement/exo$ex/";//prendre les caracteristiques de l'enoncé 
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
    header('Refresh: 2; url=audio_complement.php'); 
    ob_flush();	  
    } 

//if((isset($_FILES['doc'])&&(isset($_POST['numexo']))))
if($_POST){
	$fichier = 	array();
	$fichier =$_FILES['doc'];
	$dossier = '.\\upload\\';
	$ex=$_POST['numexo'];	
	$dossier2 = "audio/complement/exo$ex/";//prendre les caracteristiques de l'enoncé 
	if (is_dir($dossier2)){ //suppression du dossier
			$dir = opendir($dossier2); 
			while($file = readdir($dir)) {
				if(($file!='.')&&($file!='..')){
				unlink($dossier2.$file);}
			}
			closedir($dir);
			rmdir($dossier2);
		}
	if (!mkdir($dossier2, 0777)) { //creation du dossier if (!mkdir($dossier2, 0777,true))
	die('Echec lors de la création des répertoires...'); //is dir ; unlink
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
    
	
echo '<script language="Javascript">
<!--
document.location.replace("audio_complement.php");
// -->
</script>';

	
	
	// apres 10 sec, redirection sur www.nouveau_site.com
   // header('Refresh: 2; url=audio_complement.php'); 
    //ob_flush();	  
    
}
else
{
     echo $erreur;
}

}

if(!((isset($cacher))&&($cacher))){
ini_set("post_max_size", "30M");
ini_set("upload_max_filesize", "30M");
ini_set("memory_limit", -1 );
?>
<p align="left">
<b><u>Note : </u></b>L'ordre alphabétique de vos mp3 determinera leur ordre d'apparition dans l'exercice.<br>
Par exemple : phrase1.mp3, phrase2.mp3, phrase3.mp3<br><br>
Si une phrase (ou plusieurs) correspond à une question intermediaire ajoutez "-QI" au nom du fichier,<br> cela permettra au programme de les desactiver si l'option question intermediaire est desactiver<br>
<u>Par exemple :</u> si part2.mp3 est une question intermediaire, renommez-là part2-QI.mp3 <br>
</p>
<form method="POST" action="audio_complement_upload.php" enctype="multipart/form-data">
     <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	 <input type="hidden" name="numexo" value="<?php $num=$_GET['num'];echo("$num");?>">
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
</form>
<?php }?>
</body>
</html>