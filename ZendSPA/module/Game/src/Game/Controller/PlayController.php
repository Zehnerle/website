<?php
	
	namespace Game\Controller;

	use Game\Model\GameLogic;
	use Game\Model\Mail;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;
	use Zend\Mail\Message;
	use Game\Model\MongoGameTable;
	use Zend\Json\Json;

	class PlayController extends AbstractActionController {
	
		protected $gameLogic;
		protected $session;		
		
		public function playAjaxAction() {
		
			$user = $this->getSession();	
			
			$game = $this->session->offsetGet('game');	
			
			$tmp1 = $game->choice1;
			$tmp2 = $game->choice2;
			
			$game->choice2--;	 // form and DB indices start at 1
			$enum = $this->getGameLogic()->getEnum();
			$game->choice2 = $enum[$game->choice2];
			$game->choice1--;
			$game->choice1 = $enum[$game->choice1];
			
			$game->getResult();	
			
			$game->choice1 = $tmp1;
			$game->choice2 = $tmp2;
			
			$mongo = MongoGameTable::getDB();
			$mongo->updateGame($game);	
			
			if($this->session->offsetExists('sendmail'))
				if(!strcmp($this->session->offsetGet('sendmail'), 'yes'))					
					$this->sendMail($game);

			$this->session->offsetSet('game', $game);	

			$output = $this->output($game);
					
			$result = array(	
				'output' => $output,
				'user' => $user,
				'game' => $game,
				'enum' => $enum,
			);		
			
			return $this->getResponse()->setContent(Json::encode($result));
		}

		
		public function sendMail($game) {					
				
			$link = "http://" . $_SERVER['HTTP_HOST'] . "/ZendSPA/game#result=" . $game->hash;
			
			$msg = "";
			if(!empty($game->msg2)) 
				$msg = "\n\nNachricht von Spieler2:\n'$game->msg2'\n";
			
			if($game->winner == 'TIE') 
				$result = "Unentschieden!";
			else if(!strcmp($game->player2, $game->player1) || 
					!strcmp($game->player1, $game->winner)) 
				$result = "Du hast gewonnen!";
			else $result = "Du hast verloren!";
			
			$message = new Message();
			$message->setBody("Hallo '$game->player1'!\n\n'$game->player2' hat die Herausforderung angenommen: $result $msg \nDas Resultat des Spiels siehst Du hier: " .
			$link . "\n\nBis bald!");
			$message->addFrom("csae7189@uibk.ac.at");	
			$message->addTo("$game->mail1");
			$message->setSubject('Rock-Paper-Scissors-Lizard-Spock');
			$message->setEncoding("UTF-8");
			
			$mail = new Mail();
			$mail->sendMail($message);
			
		}
		
		public function output($game) {
		
			if($game->winner == 'TIE') 
				$result = "Unentschieden!";
			else if((!strcmp($game->player1, $game->player2)) || 
						strcmp($game->player1, $game->winner))
				$result = "Du hast gewonnen!";
			else
				$result = "Du hast verloren!";

			return $result;
		}
		
		
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