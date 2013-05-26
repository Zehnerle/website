<?php
	
	namespace Game\Controller;

	use Game\Model\GameLogic;
	use Game\Model\Mail;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;
	use Zend\Mail\Message;
	use Game\Model\MongoGameTable;

	class PlayController extends AbstractActionController {
	
		protected $gameLogic;
		protected $gameTable;
		protected $session;				
		
		public function playAction() {
		
			$user = $this->getSession();	
			
			$game = $this->session->offsetGet('game');	
			
			$game->choice2--;	 // form and DB indices start at 1
			$enum = $this->getGameLogic()->getEnum();
			$game->choice2 = $enum[$game->choice2];
			$game->choice1--;
			$game->choice1 = $enum[$game->choice1];
			
			$game->getResult();
			$mongo = MongoGameTable::getDB();
			$mongo->insertGame($game);	
			//$this->getGameTable()->saveGame($game);	
			
			if($this->session->offsetExists('sendmail'))
				if(!strcmp($this->session->offsetGet('sendmail'), 'yes'))					
					$this->sendMail($game);

			$this->session->offsetSet('game', $game);		
					
			return array(		
				'user' => $user,
				'game' => $game
			);		
		}

		
		public function sendMail($game) {					
				
			$link = "http://" . $_SERVER['HTTP_HOST'] . "/Zend/game/" . $game->hash . "/result";
			
			$msg = "";
			if(!empty($game->msg2)) 
				$msg = "\n\nMessage from Player2:\n'$game->msg2'\n";
			
			if($game->winner == 'TIE') 
				$result = "TIE!! No winner...";
			else if(!strcmp($game->player2, $game->player1) || 
					!strcmp($game->player1, $game->winner)) 
				$result = "You won!";
			else $result = "You lost!";
			
			$message = new Message();
			$message->setBody("Hi '$game->player1'!\n\n'$game->player2' accepted the challenge: $result $msg \nSee the result of the game on this link: " .
			$link . "\n\nHave a nice day!");
			$message->addFrom("csae7189@uibk.ac.at");	
			$message->addTo("$game->mail1");
			$message->setSubject('Rock-Paper-Scissors-Lizard-Spock');
			$message->setEncoding("UTF-8");
			
			$mail = new Mail();
			$mail->sendMail($message);
			
		}
		
		
		/*public function getGameTable() {
		
			if (!$this->gameTable) {
				$sm = $this->getServiceLocator();
				$this->gameTable = $sm->get('Game\Model\GameTable');
			}
			return $this->gameTable;			
		}*/
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}	
		
		
		public function getGameLogic() {
		
			if (!$this->gameLogic) {
				$this->gameLogic = new GameLogic();
			}
			return $this->gameLogic;			
		}
		
	}

?>