<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix des pbms</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>

<body id="main_body" >
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
	<h2>Choisissez vos séries</h2>
	<form action="traitChoixSerie.php" method="post" class="appnitro">
	<ul>
<?php 
require_once("conn.php");
$sql1 = "SELECT numSerie,nomSerie,commentaire FROM serie";
$result1 = mysql_query($sql1) or die ("Requète incorrecte");
$i=0;
while ($r1 = mysql_fetch_assoc($result1))
	{
	$i++;
	$numero=$r1["numSerie"];
	$nom=$r1["nomSerie"];
	$commentaire=$r1["commentaire"];
	$lien =$nom;
	?>

	<li id="li_<?php echo($i);?>">
			<div class="commandWrap">
				<div style="width:10px;display:inline-block;margin:0 20px 0px 0px;vertical-align:middle">
					<small>choix</small><input type=checkbox name="<?php echo ("choix".$i);?>" value="<?php echo ("$numero"); ?>">
				</div>	<div style="width:10px;display:inline-block;vertical-align:middle">
				<small>position</small>
				<input name="<?php echo ("ordre_serie".$i); ?>" type="text" size="2" maxlength="2">
				 <input name="<?php echo ("lien".$i);?>" type="hidden" value='<?php echo ($lien);?>'>
				</div>
				<div style="width:230px;display:inline-block;margin:0 0 5px 40px;padding:10px;border:1px solid black"> 
					  <?php echo( ($nom)); ?>
				</div>
			</div>
				
	 </li>
    <?php
        } // Fin instruction while

      
?></ul>
<input type=submit value="valider">
</form>
</div>
  

<img id="bottom" src="static/images/bottom.png" alt="">
</body>
</html>
