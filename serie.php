<?php 
		require_once("conn.php");
		session_start();
		$id_session=session_id();
?>
<html>
<head>
<title>Série</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../ajax/exemple_1.js"></script>
<script language="JavaScript">
	 function fermer() {
	 	opener=self;
	 	self.close();
	 }
 </script>
<style type="text/css">
<!--
input {
width:280px; 
height:30px; 
text-decoration:none; 
color:white;
text-align:center; 
font-weight:bold; 
background-color:#000080;
padding:5px;
text-align:center;
cursor: hand;
}
-->
</style>

</head>
<body>
<p>&nbsp;</p>
<h3 align="center">Choisis ta s&eacute;rie d'exercices</h3>
<table width="80%" border="0" align="center">

	  <?php
	/* 	if (!isset($_SESSION["numExo"]))
		   $_SESSION["numExo"]=1; */
		
		$sql1 = "SELECT numSerie,nomSerie,nbExo,choix FROM serie where choix >= 1 order by choix";
		$result1 = mysql_query($sql1) or die ("Requ�te incorrecte");
		$numExo=1;
		while ($r1 = mysql_fetch_assoc($result1))
		{
			$numero=$r1["numSerie"];
			$nomSerie=$r1["nomSerie"];
			$nbExo=$r1["nbExo"];
			$totalExo = $r1["nbExo"];

	 ?>
			
				<td height="30" align="center">
				<?php
				//phpinfo();//temp
				//print("<a href=\"exo.php?numSerie=".$numero."\">Serie ".$i."</a><br>");
				// print("<a href=\"interfaceIE.php?numSerie=".$numero."\">".$nomSerie."</a><br>");
				 //print("<a href=\"javascript:redirection();\">".$nomSerie."</a><br>");
				 $interface = "interfaceIE.php?numSerie=".$numero."&nbExo=".$nbExo."&totalExo=".$totalExo."&numExo=".$numExo;
				 //print("<a href=\"javascript:;\" onClick=\"window.open('$interface','Interface','fullscreen');\">".$nomSerie."</a>");
				 if (strlen($nomSerie)<30)
				 {
				 	$espace=0;$espaceAvant="";$espaceApres="";
				 	$espace = 30 - strlen($nomSerie);//echo($espace);
					$espaceAvant = str_repeat(" ",ceil($espace/2));
					$espaceApres = str_repeat(" ",floor($espace/2));
			     print("<input name=\"".$nomSerie."\"  value=\"".$espaceAvant.ucfirst($nomSerie).$espaceApres."\" type=\"button\" 
				 			style=\"white-space:inherit\" onClick=\"gestionClic(".$_SESSION["numEleve"].",'".$id_session."',".$numero.");\">"); 	
				 echo "</br>";
				/* print("<input name=\"".$nomSerie."\"  value=\"".$espaceAvant.ucfirst($nomSerie).$espaceApres."\" type=\"button\" 
				 			style=\"white-space:inherit\" onClick=\"window.open('$interface','Interface','fullscreen, toolbar=no,location=no,directories=no,menuBar=no,scrollbars=no,resizable=no,status=no'); \">");*/
				 }
				 else
				 print("<input name=\"".$nomSerie."\"  value=\"".$nomSerie."\" type=\"button\" onClick=\"onClick=\"gestionClic(".$_SESSION["numEleve"].",'".$id_session."',".$numero.");\">"); 
				?>
              </td>
			</tr>
			<?php
			//$i++; 
		}
			?>
</table>
			
<p><div align="center"><a href="javascript:fermer()">Quitter</a></div>
</p>

</html>