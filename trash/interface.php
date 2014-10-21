<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> 
<html>
<head>
<title>Title here!</title>
<script LANGUAGE="JavaScript">
function storeCaret (textEl)
{
if (textEl.createTextRange)
textEl.caretPos = document.selection.createRange().duplicate();
}
function insertAtCaret (textEl, text)
{
if (textEl.createTextRange && textEl.caretPos)
{
var caretPos = textEl.caretPos;
caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
}
else
textEl.value  = text;
}
</script>
</head>
<body>

<table border="1" bgcolor="" width="">
<tr>
<td width="">
<?php
require_once("conn.php");

$Requete_SQL2 = "SELECT * FROM comparaison where numero=9";
$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());

$nombreExemple = 1;
//while ($enregistrement = mysql_fetch_array($result))
//while ($enregistrement = mysql_fetch_object($result))
while ($enregistrement = mysql_fetch_assoc($result))
{
      $text1 =  $enregistrement["enonce1"];
      $text2 =  $enregistrement["question2"];
      $text3 =  $enregistrement["enonce2"];
      $text4 =  $enregistrement["question2"];
}


  for($piece = strtok($text1, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");

  for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");

  for($piece = strtok($text3, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");
  
  for($piece = strtok($text4, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");
  mysql_close();
?>
</td>
</tr>
<tr>
<td width="">
<form name="info">
  <input type="text" name="T1" size="20" rows="1" cols="20"></p>
</td>
<td width="">
<INPUT TYPE="button" VALUE="Ajouter" ONCLICK="insertAtCaret(this.form.zonetexte,this.form.T1.value+' ');">
</td>
<td width="">
<textarea rows="5" name="zonetexte" cols="20"
onmouseover="this.focus();"
ONSELECT="storeCaret(this);"
ONCLICK="storeCaret(this);"
ONKEYUP="storeCaret(this);"
ONCHANGE="storeCaret(this);"
>
</textarea>
</td>

</form>
</tr>
</table>
 
</body>
</html>
