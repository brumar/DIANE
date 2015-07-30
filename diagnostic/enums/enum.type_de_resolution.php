<?php

// Enum: type de resolution
abstract class Type_de_Resolution
{
	const	addition_simple = 0;
	const	addition_a_trou = 1;
	const	substraction_simple = 2;
	const	substraction_a_trou = 3;
	const	operation_mentale = 4;
	const	operation_a_trou = 5;
	const	simple_operation = 6;
	const	substraction_inverse = 7;
	const	uninterpretable = 8;

	private function	_construct(){}
}

function	print_tdr($type_de_resolution,$silent=False)
{
	$message="";
	switch($type_de_resolution)
	{
		case Type_de_Resolution::addition_simple :
			$message= "addition simple";
			break;
		case Type_de_Resolution::addition_a_trou :
			$message= "addition a trou";
			break;
		case Type_de_Resolution::substraction_simple :
			$message= "soustraction simple";
			break;
		case Type_de_Resolution::operation_mentale :
			$message= "calcul mental";
			break;
		case Type_de_Resolution::substraction_a_trou :
			$message= "soustraction a trou";
			break;
		case Type_de_Resolution::simple_operation :
			$message= "operation simple";
			break;
		case Type_de_Resolution::operation_a_trou :
			$message= "operation a trou";
			break;
		case Type_de_Resolution::substraction_inverse :
			$message= "soustraction inverse";
			break;
		case Type_de_Resolution::uninterpretable :
			$message= "ininterpretable";
			break;
		default :
			$message= "(type de resolution non reconnu)";
	}
	if($silent==False){
		echo($message);
	}
	else{
		return $message;
	}
}

?>
