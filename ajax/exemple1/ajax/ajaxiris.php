<table>
<?php
 {
  echo '<tr>';
   echo '<td>Code iris lavage</td>';
   echo '<td>';
    echo '<select name='codiris' size="1">';
    echo '<option value="1">1</option>';
    echo '<option value="2">2</option>';
    echo '</select>';
   echo '</td>';
  echo '</tr>';
 }
if($_POST['type'] == 'froid')
 {
  echo '<tr>';
   echo '<td>Code iris froid</td>';
   echo '<td>';
    echo '<select name='codiris' size="1">';
    echo '<option value="3">3</option>';
    echo '<option value="4">4</option>';
    echo '</select>';
   echo '</td>';
  echo '</tr>';
 }
if($_POST['type'] == 'cuisson')
 {
  echo '<tr>';
   echo '<td>Code iris cuisson</td>';
   echo '<td>';
    echo '<select name='codiris' size="1">';
    echo '<option value="5">5</option>';
    echo '<option value="6">6</option>';
    echo '</select>';
   echo '</td>';
  echo '</tr>';
 }
?>
</table>