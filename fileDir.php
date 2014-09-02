<?php
 /*  $handle=opendir('.\diag');
  echo "Pointeur de dossier : $handle\n";
  echo "Fichiers :\n";
  while ($file = readdir($handle)) {
    echo "$file\n";
	
  }
  closedir($handle); */
?> 
<?php
$handle=opendir('./diag');
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        //echo "$file\n";
		echo "<a href = \"download.php?nomfichier=".$file."\">".$file."</a>";
		echo "<br>";
    }
}
closedir($handle);
?> 