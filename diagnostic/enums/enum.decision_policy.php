<?php

// Enum: type d'operations
abstract class DecPol
{
	// when a number appear in a formula, what do we think it comes from ?
	// This class let the program to refer to these different places to check the provenance of a number
	// For example a priority order will be used under the form of an order list of these constants
	
	const  lastComputed=0;
	const  afterEqual=1;
	const  computed=2;
	const  problem=3;

	//TODO: Maybe we could use item like unusedNumberInProblem or unusedcalculatedNumber to favor solution path where number
	//because are more likely to be used that their counterparts.
	// but it's kind of tricky, do we really want the automatic coding to take into account this kind of subtleties ?
}	

?>