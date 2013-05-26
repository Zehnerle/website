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
		public $msg1;
		public $msg2;
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
			$this->msg1 = (isset($data['msg1'])) ? $data['msg1'] : null;
			$this->msg2 = (isset($data['msg2'])) ? $data['msg2'] : null;
			$this->winner = (isset($data['winner'])) ? $data['winner'] : null;
			$this->hash = (isset($data['hash'])) ? $data['hash'] : hash('sha256', $this->player1.$this->player2.time());
			
		}	

		public function getArrayFormat() {
			
			return array (			
				"title" => $this->id, 
				"player1" => $this->player1,
				"player2" => $this->player2,
				"mail1" => $this->mail1,
				"mail2" => $this->mail2, 
				"choice1" => $this->choice1,
				"choice2" => $this->choice2,
				"msg1" => $this->msg1,
				"msg2" => $this->msg2, 
				"winner" => $this->winner,
				"hash" => $this->hash,				
			);
			
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