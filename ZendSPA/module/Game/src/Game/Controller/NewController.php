<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Game;
	use Game\Model\Mail;	
	use Game\Model\MongoGameTable;
	use Game\Form\GameForm;  
	use Zend\Session\Container;	
	use Zend\Mail\Message;
	use Zend\Json\Json;

	class NewController extends AbstractActionController {

		protected $session;					
		
		public function newAction() {
				
			$game = new Game();	
			
			$array = array();
			
			$user = $this->getSession();		

			if($this->session->offsetExists('name')) {
				$game->player1 = $this->session->offsetGet('name');
				$game->mail1 = $this->session->offsetGet('mail');
				
				$array = array(
					'player1' => $game->player1,
					'mail1' => $game->mail1,
				);				
			}		
			
			return $this->getResponse()->setContent(Json::encode($array));
			
		}	

		public function newAjaxAction() {
		
			$form = new GameForm();			
			$game = new Game();	
			
			$user = $this->getSession();
			
			$request = $this->getRequest();			
			if ($request->isPost())
				$this->handleForm($form, $game, $request);
				
			return $this->getResponse()->setContent(Json::encode(array("success" => true)));
		}			
		
		
		public function handleForm($form, $game, $request) {
			
			$form->setData($request->getPost());
			
			$form->isValid();	// zend hack

			$data = $form->getData();
			$game->exchangeArray($data);
			$gameInfo = $game->getArrayFormat();
			
			$mongo = MongoGameTable::getDB();
			$mongo->insertGame($gameInfo);
	
			$this->session->offsetSet('name', $game->player1);
			$this->session->offsetSet('mail', $game->mail1);
			
			if(!strcmp($data['mailcheckbox'], 'mail'))
				$this->sendMail($game);

			
		}
		
		public function sendMail($game) {					
				
			$link = "http://" . $_SERVER['HTTP_HOST'] . "/ZendSPA/game#player2=" . $game->hash;
			
			$msg = "";
			if(!empty($game->msg1)) 
				$msg = "\n\nNachricht von Spieler1:\n'$game->msg1'\n";
			
			$message = new Message();
			$message->setBody("Hallo '$game->player2'!\n\nDu bist von '$game->player1' in 'Rock-Paper-Scissors-Lizard-Spock' herausgefordert worden. $msg \nFalls Du die Herausforderung annimmst, folge diesem Link: " .
			$link . "\n\nBis bald!");
			$message->addFrom("csae7189@uibk.ac.at");	
			$message->addTo("$game->mail2");
			$message->setSubject('Du bist herausgefordert worden in Rock-Paper-Scissors-Lizard-Spock!');
			
			$mail = new Mail();
			$mail->sendMail($message);
			
		}		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}		
		
	}

?>
