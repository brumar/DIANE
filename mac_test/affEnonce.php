<?php require ("conn.php"); ?>
<html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 ">
  <title>Création des séries d'exercices</title>
  <style type="text/css">
<!--
 
 .tableau
  {
	border-collapse: collapse; 
	border-style: solid; 
	border-width: 1px;
	background-color ;
  }

 body {
	margin: 0;
	padding: 0;
	text-align: center;
	font: 0.75em/1.4em Arial, Helvetica, sans-serif;
}
#container {
	position: relative;
	width: 1000px;
	margin: 3em auto;
	text-align: left;
	border: 4px solid #AF9D4C;
	background-color: #AF9D4C;
}
#container * {
	margin: 0;
	padding: 0;
}
#container ul#menu {
	position: relative;
	width: 100%;
	font-weight: bold;
}
#container ul#menu li {
	float: left;
	display: inline;
}
#container ul#menu li a {
	text-align: center;
	display: block;
	width: 155px;
	height: 25px;
	line-height: 25px;
	text-decoration: none;
}
#container ul#menu li a:hover {
	background-color: #EFDC86;
}
#container h1,
#container h2 {
	margin: 0.5em 0 0.5em 0;
	font-size: 1.4em;
}
#container .content {
	padding: 1em 2em;
	margin: -2px 0 0 0;
	_margin: -16px 0 0 0;
	background-color: #E7FFCF;
}
#container hr {
	clear: both;
	visibility: hidden;
}
#container a.current {
	background-color: #E7FFCF;
	color: #000;
}
#container a.ghost  {
	background-color: #AF9D4C;
	color: #000;
}
#container .on {
	display: block;
}
#container .off {
	display: none;
}
#container .exo{
padding:5;
}
#container .type{
padding:5;
font-size:12px;
}
#container .entete{
	padding:5px;
	font-size-adjust:inherit;
	font-size:13px;
	background-color:#CCFF99;
	font-weight: bold;
	font-variant: normal;
}
 -->
  </style>
<script type="text/javascript">

function multiClass(eltId) {
	arrLinkId = new Array('_0','_1','_2','_3','_4','_5');
	intNbLinkElt = new Number(arrLinkId.length);
	arrClassLink = new Array('current','ghost');
	strContent = new String();
	var i;
	for (i=0; i<intNbLinkElt; i++) {
		strContent = "menu"+arrLinkId[i];
		if ( arrLinkId[i] == eltId ) {
			document.getElementById(arrLinkId[i]).className = arrClassLink[0];
			document.getElementById(strContent).className = 'on content';
		} else {
			document.getElementById(arrLinkId[i]).className = arrClassLink[1];
			document.getElementById(strContent).className = 'off content';
		}
	}	
}

</script>


	<script type="text/javascript">
	// Supprimer une ligne dans toute les autres listes de destination
	
	function SupprimerListe(idOrigine)
	{	
		var objOrigine = document.getElementById(idOrigine);
		//alert(document.formulaire.choix_e1.options[document.formulaire.choix_e1.selectedIndex]);
		var i;
		for(i=1;i<=12;i++)
			{
				if(idOrigine=="choix_e"+i)
				{
					idDestination="choix_e"+(i+1); i++;
				}	
				else
				{
					idDestination="choix_e"+i;
				}
				//alert(idDestination);
				var objDestination = document.getElementById(idDestination);
				VerifValeurDansListe(idDestination, objOrigine.options[objOrigine.options.selectedIndex].value);
					 
			}
	}
	
	// V�rifie la pr�sence de Valeur dans IdListe
	function VerifValeurDansListe(IdListe, Valeur) {
		var objListe = document.getElementById(IdListe);
		for (var k=objListe.length-1;k>=0;k--) 
			if (objListe.options[k].value == Valeur) 
				{
					//if (blnAlerte) alert('D�j� pr�sent.'); 
					objListe.options[k]=null; 
				}
	}
	</script>
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<div id="container">
	<ul id="menu">
		<li class="menu0">
			<a href="#" id="_0" class="current" onClick="multiClass(this.id)" alt="menu0">Compl&eacute;ment</a></li>
		<li class="menu1">
			<a href="#" id="_1" class="ghost" onClick="multiClass(this.id)" alt="menu1">Comparaison </a></li>
		<li class="menu2">
			<a href="#" id="_2" class="ghost" onClick="multiClass(this.id)" alt="menu2">Distributivit&eacute;</a> </li>
		<li class="menu3">
			<a href="#" id="_3" class="ghost" onClick="multiClass(this.id)" alt="menu3">une  &eacute;tape</a></li>
	    <li class="menu4">
			<a href="#" id="_4" class="ghost" onClick="multiClass(this.id)" alt="menu4">problèmes génériques</a> </li>
				    <li class="menu5">
			<a href="#" id="_5" class="ghost" onClick="multiClass(this.id)" alt="menu5">Validez ici</a> </li>
	</ul>
	<hr />
<form name="formulaire" action="traitSerie.php" method="post">
	<div id="menu_0" class="on content">
     
        <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
           
		   <tr align="center" class="entete"> 
            <td><div class="entete">Selection des &eacute;nonc&eacute;s</div></td>
            <td><div class="entete">Question Intermediaire </div></td>
            <td><div class="entete">Ordre de s&eacute;l&eacute;ction</div></td>
            <td><div class="entete">Enoncés Compl&eacute;ment</div></td>
            <td><div class="entete">Type</div></td>
            <td><div class="entete">Description</div></td>
          </tr>

          <?php
  $i=1;$j=1;$m=1; $k=1; $t=1;
  $sql = "select * from complement order by numero desc";
  $result = mysql_query($sql) or die ("Requete incorrecte");
  
  if ($result) { // Si il y'a des r�sultats// while ($rs = mysql_fetch_array($query)) {
	  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $var = $enregistrement["variable"];
		  $question = $enregistrement["question"];
		  $type_exo = $var."e".$question;
		  $exo = stripslashes($exo);
		  $description = $enregistrement["descripteur"];
?>
          <tr> 
            <td align="center"><input name="<?php echo ("select_e".$i);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
          <td align="center"><input name="<?php echo ("questi_e".$i); ?>" type="checkbox"></td>
	      <td align="center"><input name="<?php echo ("choix_e".$i); ?>" type="text" size="2" maxlength="2"></td>
          <td><div class="exo"><?php echo($exo); ?></div></td>
	      <td align="center"><div class="type"><?php echo($type_exo); ?></div></td>
	      <td align="center"><?php echo($description); ?></td>
          </tr>
          <?php
        
	$i++;} // Fin instruction while

     } else { // Pas de r�sultat trouv�

    echo "Pas de résultat";

      }

  mysql_free_result($result); // Lib�re la m�moire
?>
          </table>
	</div>
	<div id="menu_1" class="off content">
    <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
      
      <tr align="center" valign="middle" class="entete"> 
        <td><div class="entete">Selection des &eacute;nonc&eacute;s</div></td>
        <td> <div class="entete">Question Intermediaire</div></td>
        <td> <div class="entete">Ordre de s&eacute;l&eacute;ction</div></td>
        <td> <div class="entete">Enonc&eacute;s Comparaison</div></td>
	    <td><div class="entete">Type</div></td>
   	    <td><div class="entete">Description</div></td>

      </tr>
      <?php
  $sql = "SELECT * FROM comparaison order by numero desc";
  $result = mysql_query($sql) or die ("Requete incorrecte");
  if ($result) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $var = $enregistrement["variable"];
		  $question = $enregistrement["question"];
		  $type_exo = $var."a".$question;
		  $exo = stripslashes($exo);
		  $description = $enregistrement["descripteur"];
?>
      <tr> 
        <td align="center"><input name="<?php echo ("select_a".$j);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
        <td align="center"><input name="<?php echo ("questi_a".$j); ?>" type="checkbox"></td>
        <td align="center"><input name="<?php echo ("choix_a".$j); ?>" type="text" size="2" maxlength="2"></td>
        <td><div class="exo"><?php echo($exo); ?></div></td>
	    <td align="center"><div class="type"><?php echo($type_exo); ?></div></td>
		<td align="center"><div class="description"><?php echo($description); ?></div></td>

      </tr>
      <?php
		$j++;} // Fin instruction while
			  } else { // Pas de r�sultat trouv�
			echo "Pas de résultat";
			  }
		  mysql_free_result($result); // Lib�re la m�moire
		?>
    </table>
  </div>
	<div id="menu_2" class="off content">
	  <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
	    <tr align="center" class="entete"> 
	      <td><div class="entete">Selection des &eacute;nonc&eacute;s</div></td>
        <td> <div class="entete">Ordre de s&eacute;l&eacute;ction</div></td>
        <td><div class="entete"> Enoncés Distributivit&eacute; </div></td>
	    <td><div class="entete">Type</div></td>
	    <td><div class="entete">Description</div></td>

      </tr>
	    <?php
  $sql3 = "SELECT * FROM distributivite order by numero desc";
  $result3 = mysql_query($sql3) or die ("Requete incorrecte Dist");
  if ($result3) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result3))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text2 =  $enregistrement["question"];
		  $exo = $text1."<br>".$text2;
		  $varFacteur = $enregistrement["varFacteur"];
		  $varFactorise = $enregistrement["varFactorise"];
		  $facteur = $enregistrement["facteur"];
		  //$question = $enregistrement["question"];
		  if ($facteur =='debut') 
		  $type_exo = "D".$varFacteur.$varFactorise."0";
		  else if ($facteur =='fin') 
		  $type_exo = "D".$varFacteur.$varFactorise."1";
		  $exo = stripslashes($exo);
		  $description = $enregistrement["descripteur"];
 
?>
	    <tr>
	      <td align="center"><input name="<?php echo ("select_d".$m);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
        <td align="center"><input name="<?php echo ("choix_d".$m); ?>" type="text" size="2" maxlength="2"></td>
        <td><div class="exo"><?php echo($exo); ?></div></td>
        <td align="center"><div class="type"><?php echo($type_exo); ?></div></td>
        <td align="center"><div class="description"><?php echo($description); ?></div></td>

      </tr>
	    <?php
        
$m++;} // Fin instruction while

      } else { // Pas de r�sultat trouv�

    echo "Pas de résultat";

      }

  mysql_free_result($result3); // Lib�re la m�moire

?>
      </table>
  </div>
	<div id="menu_3" class="off content">
      <div class="menu_4" id="une_etape">
        <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
            <tr align="center" class="entete">
            <td colspan="2" valign="middle"><div class="entete">Selection des &eacute;nonc&eacute;s</div></td>
            <td> <div class="entete">Ordre de s&eacute;l&eacute;ction</div></td>
            <td><div class="entete"> Enonc&eacute;s en une seule &eacute;tape </div></td>
            <td><div class="entete">Type</div></td>
            <td><div class="entete">Description</div></td>
        </tr>
          <?php
  $sql4 = "SELECT * FROM etape order by numero desc";
  $result4 = mysql_query($sql4) or die ("Requete incorrecte etape");
  if ($result4) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result4))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text2 =  $enregistrement["question"];
		 
		  $exo = $text1."<br>".$text2;
		  $typePb = $enregistrement["typePb"];
		  $inconnu = $enregistrement["inconnu"];
		  $variable = $enregistrement["variable"];
		  $type_exo = $typePb." ".$inconnu." (".$variable.")" ;
		  $exo = stripslashes($exo);
          $description = $enregistrement["descripteur"];

 
?>
          <tr align="center">
            <td height="18%" colspan="2" align="center" valign="middle">
            <input name="<?php echo ("select_etape".$k);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
          <td align="center"><input name="<?php echo ("choix_etape".$k); ?>" type="text" size="2" maxlength="2"></td>
          <td align="left"><div class="exo"><?php echo($exo); ?></div></td>
          <td align="center"><div class="type"><?php echo($type_exo); ?></div></td>
 		  <td align="center"><div class="description"><?php echo($description); ?></div></td>

        </tr>
          <?php 
	$k++;} // Fin instruction while

      } else { // Pas de r�sultat trouv�

    echo "Pas de résultat";

      }
  mysql_free_result($result4); // Lib�re la m�moire
   // Ferme la connexion
?>
       
          </table>
      </div>
    </div>
 
 <div id="menu_4" class="off content">
      <div class="menu_4" id="generic">
        <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
            <tr align="center" class="entete">
            <td colspan="2" valign="middle"><div class="entete">Selection des &eacute;nonc&eacute;s</div></td>
            <td> <div class="entete">Ordre de s&eacute;l&eacute;ction</div></td>
            <td><div class="entete"> Enoncé du problème </div></td>
            <!-- <td><div class="entete">Type</div></td>
            <td><div class="entete">Description</div></td> -->
        </tr>
          <?php
  $sql5 = "SELECT * FROM pbm_instancied";
  $result5 = mysql_query($sql5) or die ("Requete incorrecte pbm génériques");
  if ($result5) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result5))
		{
		  $text =  $enregistrement["text"];

 
?>
          <tr align="center">
            <td height="18%" colspan="2" align="center" valign="middle">
            <input name="<?php echo ("select_pbm".$t);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
          <td align="center"><input name="<?php echo ("choix_pbm".$t); ?>" type="text" size="2" maxlength="2"></td>
          <td align="left"><div class="exo"><?php echo($text); ?></div></td>
          <!--  <td align="center"><div class="type"><?php //echo($type_exo); ?></div></td>
 		  <td align="center"><div class="description"><?php //echo($description); ?></div></td> -->

        </tr>
          <?php 
	$t++;} // Fin instruction while

      } else { // Pas de r�sultat trouv�

    echo "Pas de résultat";

      }
  mysql_free_result($result5); // Lib�re la m�moire
  mysql_close(); // Ferme la connexion
?>
	   <input type="hidden" name="i" value="<?php echo ($i-1); ?>" >
          <input type="hidden" name="j" value="<?php echo ($j-1); ?>" >
          <input type="hidden" name="m" value="<?php echo ($m-1); ?>" >
          <input type="hidden" name="k" value="<?php echo ($k-1); ?>" >
          <input type="hidden" name="t" value="<?php echo ($t-1); ?>" >
          </table>
      </div>
    </div>
 
	<div id="menu_5" class="off content">
<table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
        <tr>
          <td align="right"><div class="exo">Donnez un nom &agrave; la s&eacute;rie</div></td>
        <td><div class="exo"><input name="nomSerie" type="text"></div></td>
      </tr>
        <tr>
          <td align="right"><div class="exo">Commentaire</div></td>
        <td><div class="exo"><textarea name="commentaire" cols="50" rows="2"></textarea></div></td>
      </tr>
        </table>    
        <p align="center">
          <input name="enregistrer" type="submit" value="Enregistrer">
      </p>
     
  </div>
    </form>
</div>
</body>
</html>