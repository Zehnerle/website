<?php

	namespace Game\Model;

	class GameLogic {
	
		protected $enum = array(
			'ROCK',
			'PAPER',
			'SCISSORS',
			'SPOCK',
			'LIZARD',			
		);
		
		public function getResult($choice1, $choice2) {	

			$key1 = array_search($choice1, $this->enum);
			$key2 =  array_search($choice2, $this->enum);
			
			$result = (5 + $key1 - $key2) % 5;
			
			if($result == 0)
				return 0;	// tie
			
			else if(($result % 2) == 1) 
				return 1;
				
			else return 2;
		
		}
		
		public function getEnum() {
			return $this->enum;			
		}
	
	}
	
	
	
?>