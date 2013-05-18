<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Player2Filter;
	use Game\Form\Player2Form; 
	use Game\Model\Mail;
	use Zend\Session\Container;	
	use Zend\Mail\Message;

	class Player2Controller extends AbstractActionController {

		protected $gameTable;
		protected $session;				
		
		public function player2Action() {	

			$user = $this->getSession();
			$hash = $this->hashCheck();
			
			$game = $this->getGameTable()->getGameByHash($hash);
		
			$form = new Player2Form();
			
			$request = $this->getRequest();
			if ($request->isPost()) {
				$filter = new Player2Filter();
				$form->setInputFilter($filter->getInputFilter());
				$form->setData($request->getPost());
				
				if ($form->isValid()) {
					$data = $form->getData();
					if($data['mail2'] == $game->mail2) {
						$game->choice2 = $data['choice2'];
						$this->session->offsetSet('name', $game->player2);
						$this->session->offsetSet('mail', $game->mail2);
						$this->session->offsetSet('game', $game);
						
						if(!strcmp($form->getData()['mailcheckbox'], 'mail'))
							$this->sendMail($game);
						
						return $this->redirect()
						->toRoute('game/play', array('hash' => $hash));
					}
					else
						$form->get('mail2')->setMessages(array('Wrong mail address!'));
				}
			}
			
			return array(
				'hash' => $hash,
				'user' => $user,
				'player2' => $game->player2,
				'form' => $form
			);
		
		}
		
		
		public function sendMail($game) {					
				
			$link = "http://" . $_SERVER['HTTP_HOST'] . "/Zend/game/" . $game->hash . "/result";
			
			$message = new Message();
			$message->setBody("Hi '$game->player1'!\n\n'$game->player2' accepted the challenge. See the result of the game on this link: " .
			$link . "\n\nHave a nice day!");
			$message->addFrom("$game->mail2");	
			$message->addTo("$game->mail1");
			$message->setSubject('Rock-Paper-Scissors-Lizard-Spock');
			
			$mail = new Mail();
			$mail->sendMail($message);
			
		}

		
		public function getGameTable() {
		
			if (!$this->gameTable) {
				$sm = $this->getServiceLocator();
				$this->gameTable = $sm->get('Game\Model\GameTable');
			}
			return $this->gameTable;			
		}
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}		
		
		
		public function hashCheck() {
			
			$hash = $this->params()->fromRoute('hash', 0);			
			if (!$hash) {
				return $this->redirect()->toRoute('game');
			}
				
			return $hash;
		}
		
	}

?>