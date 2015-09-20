<?php

// This is a class for experimental purpose only
// The researcher is supposed to manipulate these variables at this place only
// Keep Sargs_value::keep by default

abstract class Sargs
{
	//operations
	
	//full = 88.15%
	const  inferMentalCalculation=Sargs_value::keep; //suspend=>79.33 %
	const  manipulateStringBefore=Sargs_value::keep; //suspend=>82.75 %
	
	//hard decisions
	const  reduceMentalCalculations=Sargs_value::keep; //suspend=> 77.09%, random=87.9% !!
	// il faut la conserver mais notre politique n'est pas meilleure que le hasard
	const  dropLeastMentalCalculation=Sargs_value::keep; // suspend=>  81.78%
	const  backtrackPolicy=Sargs_value::keep;  // random=>86.2% , suspend=87.64%
	// meielleure que le hasard mais polique

}	

abstract class Sargs_value
{

	const  suspend=0;
	const  keep=1;
	const  random=2;

}

?>