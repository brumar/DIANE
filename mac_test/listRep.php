<?
function listRep ($repertoire, $typefichier){

    //Initialisation des variables
    //$result;         tableau de resultat
    $cptdossier=0; //cpt pour le tab des dossiers
    $cptfichier=0; //cpt pour le tab des fichiers
    //$tab_fichier;   tableau de fichiers
    //$tab_dossier;   tableau des dossiers
     //$estfichier;    booleen pour savoir si c'est un fichier
    //$estdossier;     booleen pour savoir si c'est un dossier

    // test si c'est un repertoire
    if (!(is_dir($repertoire))){
    print("Ce n'est pas un repertoire");
    exit ;
    }

    //ouverture du dossier
    $handle=opendir('.');

    //lecture du dossier
    while ($fichier = readdir($handle)){
    if ($fichier != "." && $fichier != ".."){
        //Determination du type
        $estfichier = is_file($repertoire.$fichier);
        $estdossier = is_dir($repertoire.$fichier);

        //recup des éléments dans les tableaux respectifs
        if ($estdossier==TRUE){
        $tab_dossier[$cptdossier] = $fichier;
        $cptdossier++;
        next;
        }
        if ($estfichier==TRUE){
        $tab_fichier[$cptfichier] = $fichier;
        $cptfichier++;
        next;
        }
    }
    }
    //mise en place des resultats
    // si dossier
    if ($typefichier=="dossier"){
    $result = $tab_dossier;
    }
    //si fichier
    if ($typefichier=="fichier"){
    $result = $tab_fichier;
    }
    //tous les types
    if (($typefichier=="all")||($typefichier=="")){
    for ($i=0; $i<$cptdossier+1; $i++){
        $result[$i] = $tab_dossier[$i];
    }
    for ($j=0; $j<$cptfichier+1; $j++){
        $i = $cptdossier+$j+2;
        $result[$i] = $tab_fichier[$j];
    }
    }else{
    //extension spécifiées
    $i=0;
    for ($j=0; $j<$cptfichier+1; $j++){
        $extension = explode(".", $tab_fichier[$j]);
        $valmax = count($extension)-1;
        if ($typefichier==$extension[$valmax]){
        $result[$i] = $tab_fichier[$j];
        $i++;
        }
    }
    }
    //fermeture du dossier
    closedir($handle);
    return ($result);
}
	$r='diag';
	$t='xls';
	listRep($r,$t);
?>

