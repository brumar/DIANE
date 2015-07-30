<?php

require_once('enums/enum.type_d_operation.php');
require_once('enums/enum.type_de_resolution.php');
require_once('simple_analysis_sql.php');

// Outputs in navigator an analysis of
// a simple arithmetic problem answer.
// WORKS ONLY FOR ADDITIONS / substractionS!
// NO NEGATIVE NUMBERS ALLOWED!
function	f($reponse, $nbs_ennonce)
{
	echo "Nombres de l'ennonce :$nbs_ennonce<br />";
	echo "<br />";
	echo "Reponse fournie : \"$reponse\"<br />";
	$formules_simples = f1($reponse);
	echo "<br />";
	$id_answer = insert_answer($reponse);
	echo "Formule(s) simple(s) detectee(s) : <br />";
	print_r($formules_simples);
	echo "<br />";
	echo "<br />";
	foreach ($formules_simples as $formule_simple)
	{
		echo "Formule : $formule_simple[0]<br />";
		// Operation type
		$type_d_operation = f2_1($formule_simple[0]);
		echo "Type d'operation : ";
		print_tdo($type_d_operation);
		echo "<br />";
		// Resolution type
		preg_match_all("/\d+/", $formule_simple[0], $nbs_reponse);
		$type_de_resolution = f2_3($nbs_ennonce, $nbs_reponse[0], $type_d_operation);
		echo "Type de resolution : ";
		print_tdr($type_de_resolution);
		echo "<br />";
		// Calculation error
		$calcul_error = f2_2($nbs_reponse[0], $type_d_operation, $type_de_resolution);
		if ($calcul_error != 0 )
			echo "Contient une erreur de calcul de $calcul_error.<br />";
		echo "<br />";
		insert_formula($id_answer, $formule_simple[0], $type_d_operation, $type_de_resolution, $calcul_error);
	}
}

// Outputs:
// - formules simples
function	f1($reponse)
{
	preg_match_all("/\d+\s*[+*-\/]\s*\d+\s*=\s*\d+/",
		$reponse, $formules_simples, PREG_SET_ORDER);
	return $formules_simples;
}

// Outputs;
// - type d'operation as in enum Type_d_Operation
function	f2_1($formule_simple)
{
	if (strstr($formule_simple, "+") !== FALSE)
		return Type_d_Operation::addition;
	if (strstr($formule_simple, "-") !== FALSE)
		return Type_d_Operation::substraction;
	return -1;
}

// Outputs:
// - calcul_error = TRUE/FALSE
function	f2_2($nbs_reponse, $type_d_operation, $type_de_resolution)
{ 
	switch($type_d_operation)
	{
		case Type_d_Operation::addition :
			if (($result = (int)$nbs_reponse[0] + (int)$nbs_reponse[1])
				=== (int)$nbs_reponse[2])
				return FALSE;
			else
				return abs((int)$nbs_reponse[2] - $result);
			break;
		case Type_d_Operation::substraction :
			if ($type_de_resolution === Type_de_Resolution::substraction_inverse)
			{
				if (($result = (int)$nbs_reponse[1] - (int)$nbs_reponse[0])
					=== (int)$nbs_reponse[2])
					return FALSE;
				else
					return abs((int)$nbs_reponse[2] - $result);
			}
			if (($result = (int)$nbs_reponse[0] - (int)$nbs_reponse[1])
				=== (int)$nbs_reponse[2])
				return FALSE;
			else
				return abs((int)$nbs_reponse[2] - $result);
	}
}

// Outputs:
// - resolution type as in enum Type_d_Resolution
// Trick :
// $nbs_ennonce a la forme " x, y, z,"
// pour faciliter la reconnaissance des nombres
// et ne pas confondre 4 et 45 par exemple.
function	f2_3(&$nbs_ennonce, $nbs_reponse, $type_d_operation)
{
	$is_nb0 = strstr($nbs_ennonce, " ".$nbs_reponse[0].",");
	$is_nb1 = strstr($nbs_ennonce, " ".$nbs_reponse[1].",");
	// Test de la substraction inverse
	if ($type_d_operation === Type_d_Operation::substraction
		&& $nbs_reponse[0] < $nbs_reponse[1])
	{
		if ($is_nb0 === FALSE)
			$nbs_ennonce .= " ".$nbs_reponse[0].",";
		if ($is_nb1 === FALSE)
			$nbs_ennonce .= " ".$nbs_reponse[1].",";
		return Type_de_Resolution::substraction_inverse;
	}
	// Reste
	if ($is_nb0 !== FALSE)
	{
		if ($is_nb1 !== FALSE)
		{
			// On ajoute le resultat aux nombres connus :
			$nbs_ennonce .= " ".$nbs_reponse[2].",";
			return Type_de_Resolution::simple_operation;
		}
		else
		{
			$nbs_ennonce .= " ".$nbs_reponse[1].",";
			return Type_de_Resolution::operation_a_trou;
		}
	}
	else
	{
		if ($is_nb1 !== FALSE)
		{
			$nbs_ennonce .= " ".$nbs_reponse[0].",";
			return Type_de_Resolution::operation_a_trou;
		}
		else
		{
			$nbs_ennonce .= " ".$nbs_reponse[0].",";
			$nbs_ennonce .= " ".$nbs_reponse[1].",";
			return Type_de_Resolution::uninterpretable;
		}
	}
}

?>
