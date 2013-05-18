<?php

	namespace Game\Model;

	class Game {
	
		public $id;
		public $player1;
		public $player2;
		public $mail1;
		public $mail2;	
		public $choice1;
		public $choice2;
		public $winner;
		public $hash;
		
		public function exchangeArray($data) {
		
			$this->id = (isset($data['id'])) ? $data['id'] : null;
			$this->player1 = (isset($data['player1'])) ? $data['player1'] : null;
			$this->player2 = (isset($data['player2'])) ? $data['player2'] : null;
			$this->mail1 = (isset($data['mail1'])) ? $data['mail1'] : null;
			$this->mail2 = (isset($data['mail2'])) ? $data['mail2'] : null;
			$this->choice1 = (isset($data['choice1'])) ? $data['choice1'] : null;
			$this->choice2 = (isset($data['choice2'])) ? $data['choice2'] : null;
			$this->winner = (isset($data['winner'])) ? $data['winner'] : null;
			$this->hash = (isset($data['hash'])) ? $data['hash'] : hash('sha256', $this->player1.$this->player2.time());
			
		}		
		
		public function getResult() {
			
			$logic = new GameLogic();
			$result = $logic->getResult($this->choice1, $this->choice2);

			if($result == 0)
				$this->winner = "TIE";
			else 
				$this->winner = ($result == 1) ? $this->player1 : $this->player2;
				
			return $this->winner;
		
		}
		
	}

?>