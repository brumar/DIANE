<?php
class AnomaliesManager
{
	public $anomalies;
	
	public function AnomaliesManager(){
		$this->anomalies = [];
	}

	public function addAnomaly($type){
		//TODO : vérifier les différents types d'anomalies. => Enum
		$this->anomalies[] = $type;
	}


	public function evalAnomalies(){
		return count($this->anomalies);
	}


	public function describe(){
		return print_r($this->anomalies, true);
		/// Mieuw : nombre d'anomalies de chaque types
	}


}

?>
