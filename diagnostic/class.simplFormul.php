<?php

require_once('enums/enum.type_d_operation.php');
require_once('enums/enum.type_de_resolution.php');
require_once('enums/enum.decision_policy.php');//name : DecPol
require_once('enums/enum.simulation_arguments.php');// these global variables are made for research only

class	SimplFormul
{
	public  $lastForm;
	public  $policy;
	public  $rmi;
	public	$str;//--Brut
	public	$nbs;
	public	$op_typ;//--Type
	public	$resol_typ;//--Forme
	public	$miscalc;//--Erreurs de calcul

	public $result;//--Résultat
	public $formul;//--Symbolique
	public $logger;
	public $operands=[];
	
	public $simplFors;
	public $nbProblem;

	public $lastElementAfterEqualSign;
	public $lastElementComputed;
	public $numberReliabilityScore=[];
	public $possibleAnomalies=[];

	public function		SimplFormul($str, $nbs_problem, $simpl_fors,$logger,$pol,$lastElementComputed="",$lastElementAfterEqualSign="",$lastForm)
	{
		$this->lastForm=$lastForm;
		$this->rmi=False;
		$this->policy=$pol;
		$this->lastElementComputed=$lastElementComputed;
		$this->lastElementAfterEqualSign=$lastElementAfterEqualSign;
		$this->nbProblem=$nbs_problem;
		$this->simplFors=$simpl_fors; // TODO: Encapsulation principle
		$this->logger=$logger;
		$this->str = $str;
		$this->logger->info("more precise investigation of the formula $str");
		$this->findNumbers();
		$this->find_op_typ();
		$this->repairSign();
		$this->find_resol_typ($nbs_problem, $simpl_fors);
		$this->find_miscalc();
		$this->logSummary();
	}
	
	public function findNumbers(){
		preg_match_all(RegexPatterns::number, $this->str, $nbs);
		$this->nbs = $nbs[0];
		$this->logger->info("numbers found : ");
		$this->logger->info($this->nbs);
	}
	
	public function logSummary(){
		{
			$top=print_tdo($this->op_typ,True);
			$tres=print_tdr($this->resol_typ,True);
			$this->logger->info("Formule : $this->str");
			$this->logger->info("Type d'operation : $top ");
			$this->logger->info("Type de resolution : $tres ");
			if ($this->miscalc > 0)
				$this->logger->info("Contient une erreur de calcul de $this->miscalc.");
			$this->logger->info("Expression : $this->formul");
			}
	}

	public function		_print()
	{
		echo "Formule : $this->str<br />";
		echo "Type d'operation : ";
		print_tdo($this->op_typ);
		echo "<br />";
		echo "Type de resolution : ";
		print_tdr($this->resol_typ);
		echo "<br />";
		if ($this->miscalc > 0)
			echo "Contient une erreur de calcul de $this->miscalc.<br />";
		echo "Expression : $this->formul<br />";
		echo "<br />";
	}

	private function	find_op_typ()
	/*
	 * Find the type of operation : basically just addition or soustraction
	 * 
	 */
	{
		if (strstr($this->str, "+") !== FALSE)
		{
			$this->op_typ = Type_d_Operation::addition;
			$this->formul = " + ";
		}
		else if (strstr($this->str, "-") !== FALSE)
		{
			$this->op_typ = Type_d_Operation::substraction;
			$this->formul = " - ";
		}
		$this->logger->info("signe de l'opération : ");
		$this->logger->info($this->formul);
	}

	private function	repairSign() 
	/*
	 *Repair formulas like 6-4=10 or 6+4=2 
	*
	*/
	{
		if (($this->formul == " + ")&&(abs($this->nbs[0]-$this->nbs[1])==$this->nbs[2]))
		{
			$this->formul = " - ";
			$this->op_typ = Type_d_Operation::substraction;
			$this->logger->info("we reverted the sign of the operation");
		}
			if (($this->formul == " - ")&&($this->nbs[0]+$this->nbs[1])==$this->nbs[2])
		{
			$this->formul = " + ";
			$this->op_typ = Type_d_Operation::addition;
			$this->logger->info("we reverted the sign of the operation");
		}
	}

	private function	historyOf($nb) 
	{
	/*
	 * Get symbolic representation based on problem numbers (e.g T1-P1) of a number, given its numeric form (e.g 10)
	 * This is not a straightforward operation as sometimes numbers might have multiple possible sources
	 * There are some nasty operations involved, using what we call a policy which ranks the reliability
	 * of the different possible sources. 
	 * 
	 * An anomaly is raised up when different sources give different track for a number
	 * This policy, despite being marginally better than suspension of interpretation and random selection
	 * is not fully convincing and could be improved with a better model of the student, or how the human understand the student 
	 * 
	 * A side product of this function is to instanciate a numberReliabilityScore for each number of this formula.
	 * This is to be used in higher level functions deciding which formula to select based on the reliability
	 * of the different sources of numbers which composed this formula
	*/
		$solutions=[];
		foreach($this->policy as $option){
			$solution=$this->callHistoryOf($nb,$option);
			if($solution!=""){
				$solutions[$option]=$solution;
			}
		}
		$this->checkForDoubts($solutions);
		//now handle the case where multiple solutions are possible => raise warning
		if(Sargs::backtrackPolicy!=Sargs_value::random){
			//the random value of this global variable is  to test how good is our selected policy
			// this is made for research only
			$finalVal=array_values($solutions)[0];
		}
		else{
			$finalVal=array_values($solutions)[mt_rand(0, count($solutions) - 1)];
		}
		$optionSelected=array_search($finalVal,$solutions);
		$policyRank=count($this->policy)-array_search($optionSelected, $this->policy);
		$this->numberReliabilityScore[$nb]=$policyRank;
		//
		return $finalVal;
		//$lastForm
	}
	
	private function checkForDoubts($solutions){
		/*
		 * Check if different sources give different track for a number
		 * And raise an anomaly each time it happens.
		 */
		$keys=array_keys($solutions);
		$message="warning ! Possible contradiction between two available tracks : ";
		if(in_array(DecPol::afterEqual,$keys )&&(in_array(DecPol::computed, $keys))){
			if($solutions[DecPol::afterEqual]!=$solutions[DecPol::computed]){
				$this->possibleAnomalies[]=$message."After equal and computed"; //TODO: Turn this into enum whenever possible
			}		
		}
		if(in_array(DecPol::afterEqual, $keys)&&(in_array(DecPol::problem, $keys))){
			if($solutions[DecPol::afterEqual]!=$solutions[DecPol::problem]){
				$this->possibleAnomalies[]=$message."after equal and problem numbers";	
			}
		}
		if(in_array(DecPol::computed, $keys)&&(in_array(DecPol::problem, $keys))){
			if($solutions[DecPol::computed]!=$solutions[DecPol::problem]){
				$this->possibleAnomalies[]=$message."number computed and problem numbers";
			}
		}
	}
	
	public function computeReliabilityScore($knownNumbers){
		/*
		 * Function to compute the reliability of the whole formula
		 * 
		 */
		$score=0;
		//$score-=count(array_intersect($knownNumbers,$this->operands))*20;
		// commented out, finally this is hard to justify such a rule for the general case
			
		//we really dont want that an operand is amongst the other numbers
		$score-=count($this->possibleAnomalies)*20; 
		// This way, when selecting a formula scores are used only if the number of anomalies are the same 
		foreach($this->numberReliabilityScore as $numScore){
			$score+=$numScore; 
		}
		return $score;
		
	}
	
	private function callHistoryOf($nb,$option){
		/*
		 * Used to find the different sources of the number, and give it
		 * as a symbolic expression (like T1-d)
		*
		*/
		switch($option){
			case DecPol::afterEqual:
				if($nb==$this->lastElementAfterEqualSign){
					if(!in_array($nb,array_keys($this->simplFors))){
						return "(" . $this->lastForm->formul . ")";
					}
				}
				else{
					return "";
				}
				break;
			
			case DecPol::computed:
				if(in_array($nb,array_keys($this->simplFors))){
					return "(" . $this->simplFors[$nb] . ")";
				}
				else{
					return "";
				}
				break;
					
			case DecPol::lastComputed:
				if($nb==$this->lastElementComputed){
					return "(" . $this->simplFors[$nb] . ")";
				}
				else{
					return "";
				}
				break;
						
			case DecPol::problem:
				if (array_key_exists($nb, $this->nbProblem)){
					return $this->nbProblem[$nb];
				}
				else {
					return "";
				}
				break;
							
			default:
				return "";
		}
		/*if (array_key_exists($nb, $this->nbProblem))
			return $this->nbProblem[$nb];
		else
			return "(" . $this->simplFors[$nb] . ")";*/
	}
	// Outputs:
	// - resolution type as in enum Type_d_Resolution
	// Trick :
	// $nbs_problem a la forme " x, y, z,"
	// pour faciliter la reconnaissance des nombres
	// et ne pas confondre 4 et 45 par exemple.
	private function	find_resol_typ($nbs_problem, $simpl_fors)
	/*
	 * Used to find the carateristics of the formula
	 * There are many possibilities, check the enumeration class to have a whole picture
	*
	*/
	{
		$this->logger->info("try to find operation type");

		$is_nb0 = array_key_exists($this->nbs[0], $nbs_problem);
		if ($is_nb0 === FALSE)
			$is_nb0 = array_key_exists($this->nbs[0], $simpl_fors); 
			// if the number is not in the pbms, we look if it's in another formula
		$is_nb1 = array_key_exists($this->nbs[1], $nbs_problem);
		if ($is_nb1 === FALSE)
			$is_nb1 = array_key_exists($this->nbs[1], $simpl_fors);
		// Test de la substraction inverse

		// Reste
		if ($is_nb0 !== FALSE)
		{
			if ($is_nb1 !== FALSE)
			{
				if ($this->op_typ === Type_d_Operation::substraction && $this->nbs[0] < $this->nbs[1])
				{
					$this->resol_typ = Type_de_Resolution::substraction_inverse;
					$this->result = $this->nbs[2];
					$this->formul = $this->historyOf($this->nbs[1]) . $this->formul;
					$this->formul .= $this->historyOf($this->nbs[0]);
				}
				else{
					$this->resol_typ = Type_de_Resolution::simple_operation;
					$this->result = $this->nbs[2];
					$this->formul = $this->historyOf($this->nbs[0]) . $this->formul;
					$this->formul .= $this->historyOf($this->nbs[1]);
				}

			}
			else
			{
				$this->result = $this->nbs[1];
				// Test de la soustraction par l'addition a trou
				if ($this->op_typ === Type_d_Operation::addition)
				{
					$this->op_typ = Type_d_Operation::substraction;
					$this->resol_typ = Type_de_Resolution::addition_a_trou;
					$this->formul = $this->historyOf($this->nbs[2]) . ' - ';
					$this->formul .= $this->historyOf($this->nbs[0]);
				}
				else	// soustraction a trou standard
				{
				$this->resol_typ = Type_de_Resolution::operation_a_trou;
				$this->formul = $this->historyOf($this->nbs[0]) . $this->formul;
				$this->formul .= $this->historyOf($this->nbs[2]);
				}
			}
		}
		else
		{
			if ($is_nb1 !== FALSE)
			{
				$this->result = $this->nbs[0];
				// Test de l'addition par la soustraction a trou
				if ($this->op_typ === Type_d_Operation::substraction)
				{
					$this->op_typ = Type_d_Operation::addition;
					$this->resol_typ = Type_de_Resolution::substraction_a_trou;
					$this->formul = $this->historyOf($this->nbs[2]) . " + ";
					$this->formul .= $this->historyOf($this->nbs[1]);
				}
				// Test de la soustraction par l'addition a trou
				else if ($this->op_typ === Type_d_Operation::addition)
				{
					$this->op_typ = Type_d_Operation::substraction;
					$this->resol_typ = Type_de_Resolution::addition_a_trou;
					$this->formul = $this->historyOf($this->nbs[2]) . " - ";
					$this->formul .= $this->historyOf($this->nbs[1]);
				}
			}
			else
			{
				$this->resol_typ = Type_de_Resolution::uninterpretable;
				$this->result = $this->nbs[2];

			}
		}
		$this->operands=array_diff($this->nbs,[$this->result]);
	}

	// Outputs:
	// - calcul_error (int)
	private function	find_miscalc()
	/*
	 * Find possible misscalculations
	 */
	{ 
		switch($this->op_typ)
		{
			case Type_d_Operation::addition :
				if ($this->resol_typ === Type_de_Resolution::substraction_a_trou)
					$this->miscalc = abs((int)$this->nbs[2] - (int)$this->nbs[0] + (int)$this->nbs[1]);
				else
					$this->miscalc = abs((int)$this->nbs[2] - (int)$this->nbs[0] - (int)$this->nbs[1]);
				break;
			case Type_d_Operation::substraction :
				if ($this->resol_typ === Type_de_Resolution::addition_a_trou)
					$this->miscalc = abs((int)$this->nbs[2] - (int)$this->nbs[0] - (int)$this->nbs[1]);
				else if ($this->resol_typ === Type_de_Resolution::substraction_inverse)
					$this->miscalc = abs((int)$this->nbs[2] - (int)$this->nbs[1] + (int)$this->nbs[0]);
				else
					$this->miscalc = abs((int)$this->nbs[2] - (int)$this->nbs[0] + (int)$this->nbs[1]);
		}
	}


}

?>
