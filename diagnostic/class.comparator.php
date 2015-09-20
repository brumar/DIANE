<?php
require_once('class.evalmath.php');

class	Comparator
{
	public	$symbols;
	public	$evaluator;
	public	$s1;
	public	$s2;
	public $logger;
	public $regexParenthesis="/(\((?:[^\(]*?)\))/";

	public function		Comparator($symbols,$s1,$s2,$logger) //TODO: Would better without s1 and s2 as argument for constructor
	//s1 is condidered to be the human coding this is important because we suppose that
	//it can has less parenthesis than in the computer coding (e.g T1+p1+d can be found in human coding)
	{
		$this->logger=$logger;
		$this->symbols=$symbols;
		$this->evaluator=new EvalMath;
		$t1=explode(" ", $s1);
		$this->s1=end($t1); // we only take the second part if there are two parts e.g T1-P1 T1+P1, only T1+P1 is taken
		$t2=explode(" ", $s2);
		$this->s2=end($t2);
		$this->replaceAsStrMin();
		$this->getRidOfspaces();
	}
	
	public function getRidOfspaces(){
		$this->s1=preg_replace('/\s+/', '',$this->s1);
		$this->s2=preg_replace('/\s+/', '',$this->s2);
	}
	
	public function compareExpressions(){
		if($this->s1==$this->s2){
			return True;
		}
		if(empty($this->s1)||empty($this->s2)){ // if both are void, the previous condition $s1==$s2 is valid
			return False;
		}
		
		
		return ($this->CheckInsideParenthesis() && $this->haveSameNumberOfSymbols() && $this->compareExpressionValue());
	}
	
	public function CheckInsideParenthesis(){
		$nestedValues_s1=$this->extractParenthesisValues($this->s1);
		$nestedValues_s2=$this->extractParenthesisValues($this->s2);
		foreach(array_keys($nestedValues_s1) as $k){
			foreach($nestedValues_s1[$k] as $val){
				$countS2=$k;
				$found=False;
				while(array_key_exists($countS2,$nestedValues_s2)){
					if(in_array($val,$nestedValues_s2[$countS2])){
						$found=True;
						break;
					}
					$countS2+=1;
				}
				if($found==False){
					return False;
				}
			}
		}
		return True;
	}
	
	public function extractParenthesisValues($expression){
		//
		$val=[];
		$expression_temp=$expression;
		$nestedCounter=0;
		while(preg_match_all($this->regexParenthesis,$expression_temp, $matches)!=0){
			$nestedCounter+=1;
			$val[$nestedCounter]=[];
			$pars=$matches[0];
			foreach($pars as $par){
				$this->evaluator->evaluate('f(t1,p1,d)='.$par);
				$res = $this->evaluator->evaluate('f(16,4,1)');
				$expression_temp=str_replace($par,$res,$expression_temp);
				$val[$nestedCounter][]=$res;
			}
		}
		return $val;
	}
	
	public function compareExpressionValue(){
		try {
			$this->evaluator->evaluate('f(t1,p1,d)='.$this->s1);
			$this->evaluator->evaluate('g(t1,p1,d)='.$this->s2);
			$res1 = $this->evaluator->evaluate('f(16,4,1)');
			$res2 = $this->evaluator->evaluate('g(16,4,1)');
		} catch (Exception $e) {
			echo('mathEval failed to compare '.$this->s1.' with '.$this->s2);
			return False;
		}
		return ($res1==$res2);
	}
	
	public function haveSameNumberOfSymbols(){ 
		foreach($this->symbols as $symbol){
			$s1=substr_count($this->s1,$symbol);
			$s2=substr_count($this->s1,$symbol);
			if($s1!=$s2){
				return False;
			}
		}
		return True;
	
	}
	public function replaceAsStrMin(){
		foreach($this->symbols as $symbol){
			$this->s1=str_replace($symbol,strtolower($symbol),$this->s1);
			$this->s2=str_replace($symbol,strtolower($symbol),$this->s2);
		}
	}
}
?>