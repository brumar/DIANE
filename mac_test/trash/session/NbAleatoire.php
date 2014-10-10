<? 
  //Initialisation du générateur
  srand(time());
  // Tirage de 5 nombres compris entre 1 et 100
  for ($index=0;$index<5;$index++)
  {
    $nb=rand(1,100);
    echo "$nb<br>";
  }
?>

