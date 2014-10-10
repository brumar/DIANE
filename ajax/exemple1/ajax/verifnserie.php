<?php
if(strlen($_POST['nserie']) != 9 AND $_POST['fournis'] == 'TRUC')
 {
  echo '<img src="images/actionko.gif" alt="Incorrect" border="0" width="20"><font color="#FF0000">
Incorrect : 9 chiffres necessaires</font>';
  echo '<input type="hidden" name="errnserie" value="erreur">';
 }
else if(strlen($_POST['nserie']) != 12 AND $_POST['fournis'] == 'MACHIN')
 {
  echo '<img src="images/actionko.gif" alt="Incorrect" border="0" width="20"><font color="#FF0000">
Incorrect : 12 chiffres necessaires</font>';
  echo '<input type="hidden" name="errnserie" value="erreur">';
 }
else
 {
  echo '<img src="images/actionok.gif" alt="Correct" border="0" width="20">Nombre de  chiffres correct';
 }
?>