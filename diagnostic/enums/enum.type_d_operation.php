<?php

// Enum: type d'operations
abstract class Type_d_Operation
{
	const	addition = 0;
	const	substraction = 1;

	private function	_construct(){}
}

function	print_tdo($type_d_operation,$silent=False)
{
	$message="";
	switch($type_d_operation)
	{	
		case Type_d_Operation::addition :
			$message= "addition";
			break;
		case Type_d_Operation::substraction :
			$message= "substraction";
			break;
		default :
			$message= "(type d'operation non reconnu)";
	}
	if($silent==True){
		return $message;
	}
	else {
		echo $message;
	}
}

?>
