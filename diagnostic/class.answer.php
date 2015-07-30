<?php

require_once('class.simplFormul.php');
require_once('enums/enum.regexPatterns.php');
require_once('enums/enum.decision_policy.php');//name : DecPol
require_once('enums/enum.simulation_arguments.php');
require_once('class.mentalFormul.php');
require_once('class.evalmath.php');
require_once('class.anomalyManager.php');
require_once('logger/Logger.php');
Logger::configure('diagnostic/configLogger.xml');// Tell log4php to use our configuration file.


class	Answer
{
	public $policy;//indicates who numbers are infered where they come from
	//3 fields added to support policy mecanisms
	
	//these 3 fields are updated each time a formula is added, their only use is in SimpleForm class to disambiguate formulas
	//TODO: fields must be bundled in the class described in my phd thesis 
	public $lastElementAfterEqualSign;
	public $currentLastFormObj;
	public $lastElementComputed;
	public $anomalyManager;
	//public $computedNumbers; not necessary as its the diff of numbers in pbm and $availableNumbers
	
	private	$strbrut;//text brut 
	private	$str; // text after some replacements --réponse réparée
	private	$nbs;//associative array "23"=>"N1" 
	private $numbersInProblem;//"23", etc...
	private $availableMentalNumbers;// numbers that can be computed by a mental operation
	public $availableNumbers;// union of computed numbers and numbers in the problem
	private $langage; // use to replace langage elements
	private $logger;//log the messages
	private $eval;// php math evaluator
	
	private	$full_exp; //not sure to be usefull
	private $simpl_formulas;//formulas as string
	private $formulaCount;// count the number of detected formulas --Nombre de formules
	private $simpl_fors; // bind computed numbers to their formula
	public	$simpl_fors_obj; //formulas as object
	private	$lastFormula; //the formula as object that compute the answer
	private $verbose; //string indicating if verbal report or not (to debug)
	private $finalAnswer="";//final answer given by the subject
	public $finalFormula="";//final formula representing the whole solving process
	private $reverseIndexLastFormula; //reversed index of the formula giving the result --indexFormuleFinale
	private $id;// well, not a unique id but an id given as constructor parameter usefull for logging purpose, at least
	public $ininterpretable=False; // boolean indicated if the answer is ininterpretaable --interprétable?
	private $voidAnswer=False;//TODO: gérer cet attribut
	public $anomalies=[];// very likely to be useless (superseded by the anomaly manager class).
	public $NumberOfNumbers;// the number of numbers in the formula, if it's usefull I don't remember it
		
	static $tabReplacements;
	


	public function	Answer($str, $nbs_problem,$verbose=False,$langage="french",$id="noID",
			$policy=[DecPol::lastComputed,DecPol::afterEqual,DecPol::computed,DecPol::problem])
	//priorityList=["LastComputed","afterEqual","computed,"problem"]
	{
		$this->anomalyManager=new AnomaliesManager();
		$this->eval= new EvalMath;
		$this->logger = Logger::getLogger("main");
		$this->availableMentalNumbers=[];
		$this->verbose=$verbose;
		$this->strbrut = $str;
		$this->nbs=$nbs_problem;
		$this->numbersInProblem=array_keys($this->nbs);
		$this->availableNumbers=$this->numbersInProblem;
		$this->simpl_fors = [];
		$this->simpl_fors_obj=[];
		$this->id=$id;
		$this->policy=$policy;
		
		$this->langage=$langage; //TODO an enum would be better


	}
	/**
	 * 
	 */
	 public function process() {
		$this->loginit ($this->id);//$id is for log only (in order to ease browsing)
		//simulation_arguments
		$this->prepareString();
		$this->firstGlobalAnalysis();
		$this->sequentialAnalysis($this->nbs); 
		$this->lastGlobalAnalysis();

	}

	public function loginit($id) {
		$this->logger->info("******NOUVELLE ANALYSE*******");
		$this->logger->info("******ID=$id*******");
		$date=date("D M H:i");
		$this->logger->info("analyse de : $this->strbrut, language: $this->langage, $date");
		$this->logger->info("nombres :  ");
		$this->logger->info($this->numbersInProblem);
	}	
	
	public function prepareString(){
		/*
		 * Call all the procedures pertaining to the repairment of the answer string
		 * 
		 */
		if(Sargs::manipulateStringBefore==Sargs_value::keep){
			$this->replaceElementsInAnswer();
			$this->repairSpecialFormulas();
		}
		else{
			$this->str=$this->strbrut;
		}
	}	
	
	public function firstGlobalAnalysis(){
		/*
		 * Call all the procedures pertaining to first global analysis
		*
		*/
		$this->updateAvailableMentalNumbers();
		$this->findFinalAnswer();
		$this->find_simpl_for();
	}

	public function	sequentialAnalysis($nbs_problem,$verbose=True)
	{
		/*
		 * Update Number list that can be reached by mental computation
		* */
	
	
		foreach ($this->simpl_formulas as $s=>$simpl_form)
		{
			$formlulaIsInterpretable=True;
			$knownNumbers=$this->getNumbersKnownInFormula($simpl_form);
			$nUnkowns=count($knownNumbers);
			$this->logger->info("analyse of this formula : $simpl_form");
			$this->logger->info("number of unkwowns numbers in the formula (1 is the simplest case) ");
			$this->logger->info($nUnkowns);
			if($nUnkowns>1){ // e.g when you see a+b=c and you don't know where a (and c) comes from.
				if(Sargs::inferMentalCalculation==Sargs_value::keep){	// you need to check for mental computation, if you want to.
					$this->logger->info("we try to detect mental calculations");
					$mentalCalculations=$this->detectMentalCalculations($simpl_form);//
					$mentalCalculations=$this->reduceMentalCalculations($mentalCalculations,$knownNumbers);
					//sometimes many computations can explain the same number, this is why we select only the most probable
					$nRealUnknowns=$nUnkowns-count($mentalCalculations);// how many unknowns remaining ?
					$this->logger->info("After the mental computation investigation, we count the number of remaining unkwowns (1 is the simplest case) ");
					$this->logger->info($nRealUnknowns);
					switch ($nRealUnknowns)
					{
						case 1 : // this is the most fortunate case
							foreach ($mentalCalculations as $mentalCalculation){
								$this->addFormula($mentalCalculation);
							}
							break;
								
						case 0 :
							//when you see a+b=c and you don't know where a (and c) comes from...and both are explainable by mental computations
							//here you will keep c as the result of the formula, but there are other cases more problematic, cf dropLeastProbableMentalCalculations
							if(Sargs::dropLeastMentalCalculation!=Sargs_value::suspend){
								$this->logger->info("We try to drop a mental formula");
								$next_form = (isset($this->simpl_formulas[$s+1])) ? $this->simpl_formulas[$s+1] : ""; # TODO: mettre dans le workspace
								$mentalCalculations=$this->dropLeastProbableMentalCalculations($mentalCalculations,$simpl_form,$next_form);
								foreach ($mentalCalculations as $mentalCalculation){
									$this->addFormula($mentalCalculation);
								}
							}
							else{
								$formlulaIsInterpretable=False;
							}
							break;
	
						default:
							//here we are screwd
							$formlulaIsInterpretable=False;
							$this->anomalyManager->addAnomaly("a formula has been considered ininterpretable");
							$this->logger->info("interpretation process of the current formula has failed at this point");
							break;
							//too many or not enough mental calculations to understand this operations
					}
				}else{
					$formlulaIsInterpretable=False;
				}
			}
			if($formlulaIsInterpretable==True)
			{
				$formula=new SimplFormul($simpl_form, $nbs_problem, $this->simpl_fors,$this->logger,$this->policy,$this->lastElementComputed,$this->lastElementAfterEqualSign,$this->currentLastFormObj);
				if(Sargs::backtrackPolicy==Sargs_value::suspend && count($formula->possibleAnomalies)>0){
					$formlulaIsInterpretable=False;
					// sometimes there are harsh decisions do
				}
				else{
					$i=$this->addFormula($formula);
					$this->updateAvailableNumbers();
					$this->updateAvailableMentalNumbers();
				}
			}
		}
	}

	public function	lastGlobalAnalysis()
	/*
	 * Call all the procedures pertaining to last global analysis
	*
	*/	
	{
		$this->getAnomalies();
		$this->findInterprateFinalAnswer();
		$this->printSummary();
	}
		
	public function updateAvailableNumbers(){
		/*
		 * Update Number list that have been reached by computation or are defined in the problem
		* */
		$this->availableNumbers=array_merge($this->availableNumbers,array_keys($this->simpl_fors));//TODO
	}

	public function updateAvailableMentalNumbers(){
		/*  
		 * Update Number list that can be reached by mental computation
		 * */
		$availableMentalNumbers=[];
		$this->logger->info("updating mentally available numbers");
		$this->logger->info("this is done on the basis of direct availables numbers");
		$this->logger->info($this->availableNumbers);
		$doublons=perm($this->availableNumbers,2);
		$alreadySeen=$this->availableNumbers; // Numbers already computed or defined in the problem cannot be produced by mental calculation 
		foreach($doublons as $doublon){
			sort($doublon);
			if($doublon[0]!=$doublon[1]){ // 42-42 and 42+42 are avoided
				//TODO: This must be a function instead of a repetition for bloc moins
				$n_moins=strval(intval($doublon[1])-intval($doublon[0])); //$doublon[1] always bigger because of sort
				$n_plus=strval(intval($doublon[1])+intval($doublon[0]));
				$blocPlus=["formula"=>$doublon[1].' + '.$doublon[0],"str"=>$doublon[1].' + '.$doublon[0].' = '.$n_plus];
				$blocMoins=["formula"=>$doublon[1].' - '.$doublon[0],"str"=>$doublon[1].' - '.$doublon[0].' = '.$n_moins];
				$alreadyAdded=False;
				if(in_array($n_plus,array_keys($availableMentalNumbers))){
					foreach($availableMentalNumbers[$n_plus] as $bloc){
						if(serialize($bloc)==serialize($blocPlus)){
							$alreadyAdded=True;
							break;
						}
						
					}
				}
					if($alreadyAdded==False){
						$availableMentalNumbers[$n_plus][]=$blocPlus;			
					}				
				$alreadyAdded=False;
				if(in_array($n_moins,array_keys($availableMentalNumbers))){
					foreach($availableMentalNumbers[$n_moins] as $bloc){
						if(serialize($bloc)==serialize($blocMoins)){
							$alreadyAdded=True;
							break;
						}	
					}
				}
					if($alreadyAdded==False){
						$availableMentalNumbers[$n_moins][]=$blocMoins;			
					}	
			}
		}
		$this->logger->info("availableMentalNumbers :");
		$this->logger->info(array_keys($availableMentalNumbers));
		/*$this->logger->trace("availableMentalNumbers : détails");// to uncomment whenever there is a way to read log file with filter trace
		$this->logger->trace($availableMentalNumbers);*/
		$this->availableMentalNumbers=$availableMentalNumbers;	
	}

	function	find_simpl_for()
	/*
	 * Find all the formula under the form a [sign] b=c like a+b=c
	 * instanciate simpl_formulas which keed these formula under string representation
	 */
	{
		preg_match_all(RegexPatterns::completeOperation,
			$this->str, $ar_temp, PREG_SET_ORDER);
		$this->simpl_formulas=[];
		
		foreach($ar_temp as $a){
			$this->simpl_formulas[]=$a[0]; // avoid the fact that with preg_match_all, all elements are at [0]
		}
		$this->logger->info("formulas detected : ");
		$this->logger->info($this->simpl_formulas);
		$this->formulaCount=count($this->simpl_formulas);
	}
	
	public function reduceMentalCalculations($mentalCalculations,$knownNumbers){
		/*
		 * Fix the problem when multiple mental calculations can explain the presence of a sole number
		 * Fix a list of list of mental calculations related to a formula
		 * 
		 * Suggestion : This reduction operation is not benine, more than raising an anomaly, should it be used in subsequent scoring operation
		 * that can happens in the "dropTheLeast" operation.
		 */


		$flatListOfMentalComp=[];
		
		foreach($mentalCalculations as $listOfMentalCalculation){
			if(Sargs::reduceMentalCalculations!=Sargs_value::random){
				$remainingMentalComputation=$this->reduceParticularMentalComp($listOfMentalCalculation,$knownNumbers);
				if(!empty($remainingMentalComputation)){
					$flatListOfMentalComp[]=$remainingMentalComputation;
				}
			}
			else{
					$flatListOfMentalComp[]=$listOfMentalCalculation[mt_rand(0, count($listOfMentalCalculation) - 1)];
				}
			}
	return $flatListOfMentalComp;	
	}
	
	public function reduceParticularMentalComp($listOfMentalCalculation,$knownNumbers){
		/*
		 * Fix the problem when multiple mental calculations can explain the presence of a sole number
		 * Fix a list of mental calculations explaining a number
		 */
		$scores=[];
		if(count($listOfMentalCalculation)>1){
			if(Sargs::reduceMentalCalculations==Sargs_value::keep){
				$message="various mental computation are possible to explain a number";
											
				$this->anomalyManager->addAnomaly($message);
				$this->logger->info($message);
				$this->logger->info("we try to find the most obvious one");
				foreach($listOfMentalCalculation as $ind=>$mentalCalc){
					$scores[$ind]=$mentalCalc->computeReliabilityScore($knownNumbers);
				}
				$max=-1000;
				$selected=0;
				$equalityWarning=False;
				foreach ($scores as $ind2=>$score){
					if($score==$max){
						$equalityWarning=True;
					}
					if($score>$max){
						$equalityWarning=False;
						$max=$score;
						$selected=$ind2;
					}
				}
				if($equalityWarning){
					$this->logger->info("scores for each formula are equal, we abandon the process");
					$flatListOfMentalComp=[];
					$this->anomalyManager->addAnomaly("scoring comparison in reduceParticularMentalComp has failed");
				}
				else{
					$selectedMental=$listOfMentalCalculation[$selected];
					return $selectedMental;
				}
			}
			else{
				return [];
			}
		}
		else{
			return $listOfMentalCalculation[0];
		}
	}
	
	public function printSummary(){
		//print formulas in HTML
		if($this->verbose==True){
			foreach($this->simpl_fors_obj as $form)
			{
				$form->_print();
			}
		}
	}
		
	public function findInterprateFinalAnswer(){
		/*
		 * Take advantage of the formulas parsing to interprate
		 * the final answer given by the student.
		 * 
		 * If no final answer is given, one consider that the last formula writen by the student
		 * computes its final answer
		 */
		$this->NumberOfNumbers=preg_match_all(RegexPatterns::number,$this->str,$unused);
		// todo detect RMI here
		if($this->finalAnswer!=""){
			$found=False;
			foreach (array_reverse($this->simpl_fors_obj) as $index=>$formOb){
				if ($formOb->result==$this->finalAnswer){
					$this->logger->info("final formula is $formOb->str ");
					$this->logger->info("then the summary formula is : $formOb->formul ");
					$this->finalFormula=$formOb;
					$this->reverseIndexLastFormula=$index;
					return;
				}
			}
			if(in_array($this->finalAnswer,array_keys($this->availableMentalNumbers))){
				$mentals=$this->detectMentalCalculations(strval($this->finalAnswer),"disambFinalAnswer");//trick to reuse function
				$mental=$this->reduceMentalCalculations($mentals,[]);
				if(!empty($mental)){
					$mentalFinal=$mental[0];//by construction we know that a single mentalCalculation is there
					$this->simpl_fors_obj[]=$mentalFinal;
					$this->simpl_fors[$mentalFinal->result] = $mentalFinal->formul;
					$this->logger->info("possible mental formula found to explain final result:  $mentalFinal->formul");
				}
				else{
					$this->logger->info("We could not take a mental formula explaining results, probably because we could not select the best among various possibilities");
					$this->ininterpretable=True;
					return;
				}
			}
			else{
				$this->logger->info("NO FORMULA EXPLAINS THE NUMBER GIVEN AS AN ANSWER");
				$this->ininterpretable=True;
				return;
			}
		
		}
		//if no answer explitely given ones take the last formula as referent
		if(count($this->simpl_fors_obj)==0){ // if there is no "last formula => end
				
			$this->ininterpretable=True;//TODO : global status of the answer as an enum, it would allow more  precise information such as "no formula detected"
			$this->logger->info("No formula Found");
			return ;
		}
		else {
			$lform=end($this->simpl_fors_obj);
			$this->logger->info("final formula (by default) is $lform->str ");
			$this->logger->info("then the summary formula is : $lform->formul ");
			$this->finalFormula=$lform;
			$this->reverseIndexLastFormula=1;
		}
		
		//TODO :
	}
	
	public function dropLeastProbableMentalCalculations($listOfMentalCalculations,$simpl_form,$next_form){
		/*
		 * If too many mental calculations explain the formula, then we need to drop one
		* the final answer given by the student.
		*/		
		
		if(Sargs::dropLeastMentalCalculation==Sargs_value::random){
			$indexToSuspend=mt_rand(0, count($listOfMentalCalculations) - 1);
			unset($listOfMentalCalculations[$indexToSuspend]);
			return $listOfMentalCalculations;
		}
		
		if($next_form=="") 
		// if the formula studied is the last formula, check if one number is given as an answer
			{
			foreach($listOfMentalCalculations as $i=>$mcal){
				if($mcal->result==$this->finalAnswer){
					$this->logger->info("We drop this mental computation because it's the final answer given by the student");
					$this->logger->info($listOfMentalCalculations[$i]->str);
					unset($listOfMentalCalculations[$i]);
					return $listOfMentalCalculations;
				}
			}
		}
		else{
		//if one formula come after, check if one number is given as an answer
			preg_match_all(RegexPatterns::number, $next_form, $nbs);
			$numbersInFormula=$nbs[0];		
			foreach($listOfMentalCalculations as $i=>$mcal){
				foreach($numbersInFormula as $nb){
					if($mcal->result==$nb){
						$this->logger->info("We drop this mental computation because the number is reused later by the student");
						$this->logger->info($listOfMentalCalculations[$i]->str);
						unset($listOfMentalCalculations[$i]);
						return $listOfMentalCalculations;
					}
				}
			}
		}	
		// last case : consider that the number after the equal is the one genuinely computed
		// This is kind of risky, but it's a rare case.
		preg_match_all(RegexPatterns::lastNumberInFormula, $simpl_form, $n);
		$temp=end($n);
		$lastNumber=end($temp);
		foreach($listOfMentalCalculations as $j=>$mcal){
			if($mcal->result==$lastNumber){
				$this->logger->info("We drop the mental computation for the number after the equal (no better option)");
				$this->logger->info($listOfMentalCalculations[$j]->str);
				$this->anomalyManager->addAnomaly("droped mental computation to disamb, thinking that the number after the equal was the result");
				unset($listOfMentalCalculations[$j]);
				return $listOfMentalCalculations;
			}			
		}
		$this->logger->error("no mental computation has been droped, this is unexpected");
	}
	
	public function findFinalAnswer(){
		if(preg_match(RegexPatterns::EndresultAfterFormulas,$this->str, $match)==1){
			$this->finalAnswer=$match[1];
			$this->logger->info("final answer  found :");
			$this->logger->info($this->finalAnswer);
		}
		else{
		$this->logger->info("final answer not found");
		}	
	}
	
	public function addFormula($formula){
		$this->simpl_fors_obj[]=$formula;
		$this->simpl_fors[$formula->result] = $formula->formul;	
		$this->lastElementComputed=$formula->result;
		$this->currentLastFormObj=$formula;
		if($formula->resol_typ!=Type_de_Resolution::operation_mentale){
			$this->lastElementAfterEqualSign=$formula->nbs[2];
		}
		else{
			$this->lastElementAfterEqualSign="";
		}
	}
		
	public function getAnomalies(){
		foreach($this->simpl_fors_obj as $form){
			foreach($form->possibleAnomalies as $anom){
				$this->anomalyManager->addAnomaly($anom);
			}
		}
		preg_match_all(RegexPatterns::number, $this->str, $nbs); //not the best place to add these anomalies
		$numbers=$nbs[0];
		foreach($numbers as $nb){
			if($nb!=$this->finalAnswer){
				 if(array_search($nb, $this->availableNumbers)===False){
				 	$this->anomalyManager->addAnomaly("unidentifiedNumber");
				 }
			}	
		}
	}
	
	public function detectMentalCalculations($formula,$context="disambFormula"){
		preg_match_all(RegexPatterns::number, $formula, $nbs);
		$numbersInFormula=$nbs[0];
		$mentalCalculations=[];
		foreach($numbersInFormula as $n){
			if(!in_array($n,$this->availableNumbers)||($context=="disambFinalAnswer")){//This context exception is to look for mental computation even if this is also a number given in the problem. If this is a result of an explicit operation then detectMentalCalculations is not called anyway.
				if(in_array($n,array_keys($this->availableMentalNumbers))){
					$mentalCalculations[$n]=[];
					foreach($this->availableMentalNumbers[$n] as $possibleMentalCalculation){
						$formstr=$possibleMentalCalculation["str"];
						$this->logger->info("possible mental formula found : $formstr");
						$nm=new MentalFormul($possibleMentalCalculation["str"], $this->nbs,$this->simpl_fors,$this->logger,$this->policy,$this->lastElementComputed,$this->lastElementAfterEqualSign,$this->currentLastFormObj);
						$u=array_diff($numbersInFormula, $nm->nbs);
							$mentalCalculations[$n][]=$nm; 
							$this->logger->info("mental calculation suggested : ");
							$this->logger->info($possibleMentalCalculation["str"]);
					}
				}
			}
		}
		return $mentalCalculations;
	}
	
	
	public function getNumbersKnownInFormula($f){
		preg_match_all(RegexPatterns::number, $f, $nbs);
		$numbersInFormula=$nbs[0];
		$ns=array_diff($numbersInFormula,$this->availableNumbers);
		return $ns;
	}


	static function initReplacements(){	
		self::$tabReplacements['french']['1']=array(' un ','01');
		self::$tabReplacements['french']['2']=array('deux',' deu ','02');
		self::$tabReplacements['french']['3']=array(' trois ',' troi ','03');  
		self::$tabReplacements['french']['4']=array(' quatre ',' catr ',' quatr ','04');
		self::$tabReplacements['french']['5']=array(' cinq ',' sinq ',' sinc ','05');
		self::$tabReplacements['french']['6']=array(' six ',' sis ',' cis ',' cix ','06');
		self::$tabReplacements['french']['7']=array(' sept ',' cept ','07');
		self::$tabReplacements['french']['8']=array(' huit ',' uit ','08');
		self::$tabReplacements['french']['9']=array(' neuf ',' nef ','09');
		self::$tabReplacements['french']['10']=array(' dix ',' dis ');
		self::$tabReplacements['french']['CM_a_']=array('CM1');
		self::$tabReplacements['french']['CM_b_']=array('CM2');
		self::$tabReplacements['french']['CE_a_']=array('CE1');
		self::$tabReplacements['french']['CE_b_']=array('CE2');
		self::$tabReplacements['french']['ensemble']=array('les deux','les 2');
	}
	
	public function repairSpecialFormulas(){
		
		preg_match_all(RegexPatterns::separatedFormula,$this->str, $matches,PREG_SET_ORDER);
		foreach($matches as $match){
			$uncompleteFormula=$match[1];
			$separatedNumber=$match[2];
			$result=strval(abs($this->eval->evaluate($uncompleteFormula)));
			if($result==$separatedNumber){
				$replacement=$uncompleteFormula.'='.$result;//a+b+c=d => a+b=y y+c=d
				$this->logger->info("uncomplete formula answer  found :");
				$this->logger->info($uncompleteFormula);
				$this->str=str_replace($uncompleteFormula,$replacement,$this->str);
			}
		}
		
		while (preg_match(RegexPatterns::compositeOperation,$this->str, $match)==1){
			$compositeFormula=$match[1];
			$result=strval($this->eval->evaluate($compositeFormula));
			$replacement=$compositeFormula.'='.$result.' '.$result;//a+b+c=d => a+b=y y+c=d
			$this->logger->info("composite formula answer  found :");
			$this->logger->info($compositeFormula);
			$this->str=str_replace($compositeFormula,$replacement,$this->str);
		}
			
		while (preg_match(RegexPatterns::followedUpOperation,$this->str, $match)==1){
			$compositeFormula=$match[1];
			$result=strval($this->eval->evaluate($compositeFormula));
			$replacement=$match[1].' '.$match[2];//a+b=c+d => a+b=y y+c=d, match[1] is a+b=y; match[2] is y
			$this->logger->info("followedUp formula answer  found :");
			$this->logger->info($compositeFormula);
			$this->str=str_replace($compositeFormula,$replacement,$this->str);
		}
	}	
	
	public function replaceElementsInAnswer(){
		$repTable=self::$tabReplacements[$this->langage];
		foreach ($repTable as $index => $patterns)
		{
			$pattern_final='#';
			foreach ($patterns as $pattern)
			{
				$pattern_final=$pattern_final.$pattern.'|';
			}
			$pattern_final = substr($pattern_final,0,strlen($pattern_final)-1);  //permet d'enlever le dernier 'ou' en trop
			$pattern_final=$pattern_final.'#i';
			$tab[$index]=$pattern_final;
			}
			$temp=$this->strbrut;
			
			foreach ($tab as $index => $pattern)
			{
				$temp=preg_replace( $pattern,$index,$temp);		
			}
			$this->str=$temp;
			$this->logger->info("answer after replacements :  $this->str");
	}	
	
}

 function perm($arr, $n, $result = array())
{
	if($n <= 0) return false;
	$i = 0;

	$new_result = array();
	foreach($arr as $r) {
		if(count($result) > 0) {
			foreach($result as $res) {
				$new_element = array_merge($res, array($r));
				$new_result[] = $new_element;
			}
		} else {
			$new_result[] = array($r);
		}
	}

	if($n == 1) return $new_result;
	return perm($arr, $n - 1, $new_result);
}
Answer::initReplacements();
?>
