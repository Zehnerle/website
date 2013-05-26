<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Game;
	//use Game\Model\GameFilter;
	use Game\Model\Mail;	
	use Game\Model\MongoGameTable;
	use Game\Form\GameForm;  
	use Zend\Session\Container;	
	use Zend\Mail\Message;
	

	class NewController extends AbstractActionController {

		//protected $gameTable;
		//protected $tableGateway;
		protected $session;				
		
		
		public function newAction() {
		
			$form = new GameForm();
			$game = new Game();	
		
			$user = $this->getSession();				

			if($this->session->offsetExists('name')) {
				$game->player1 = $this->session->offsetGet('name');
				$game->mail1 = $this->session->offsetGet('mail');
				
				$hash = $this->params()->fromRoute('hash', 0);	//Revanche
				if ($hash && $this->session->offsetExists('game'))
					$oldgame = $this->session->offsetGet('game');
				
				$game->player2 = (isset($oldgame)) ? $oldgame->player1 : "";
				$game->mail2 = (isset($oldgame))? $oldgame->mail1 : "";
				
				$array = array(
					'player1' => $game->player1,
					'mail1' => $game->mail1,
					'player2' => $game->player2,
					'mail2' => $game->mail2,
				);
				$form->setData($array);
			}

			$request = $this->getRequest();
			if ($request->isPost())
				$this->handleForm($form, $game, $request);
			
			return array (
				'user' => $user,
				'form' => $form
			);
		}		
		
		
		public function handleForm($form, $game, $request) {
		
			/*//not needed anymore because of JS
			$filter = new GameFilter();
			$form->setInputFilter($filter->getInputFilter());*/
			
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$data = $form->getData();
				$game->exchangeArray($data);
				$gameInfo = $game->getArrayFormat();
								
				$mongo = MongoGameTable::getDB();
				$mongo->insertGame($gameInfo);
				//$this->getGameTable()->saveGame($game); //MONGO
		
				$this->session->offsetSet('name', $game->player1);
				$this->session->offsetSet('mail', $game->mail1);
				
				if(!strcmp($data['mailcheckbox'], 'mail'))
                    $this->sendMail($game);
				
				return $this->redirect()->toRoute('game');
			}
		}
		
		public function sendMail($game) {					
				
			$link = "http://" . $_SERVER['HTTP_HOST'] . "/Zend/game/" . $game->hash . "/player2";
			
			$msg = "";
			if(!empty($game->msg1)) 
				$msg = "\n\nMessage from Player1:\n'$game->msg1'\n";
			
			$message = new Message();
			$message->setBody("Hi '$game->player2'!\n\nYou were challenged by player '$game->player1' in 'Rock-Paper-Scissors-Lizard-Spock'. $msg \nIf you accept the challenge, follow this link: " .
			$link . "\n\nHave a nice day!");
			$message->addFrom("csae7189@uibk.ac.at");	
			$message->addTo("$game->mail2");
			$message->setSubject('You were challenged in Rock-Paper-Scissors-Lizard-Spock!');
			
			$mail = new Mail();
			$mail->sendMail($message);
			
		}

		
		/*public function getGameTable() {
		
			if (!$this->gameTable) {
				$sm = $this->getServiceLocator();
				$this->gameTable = $sm->get('Game\Model\GameTable');
				$this->tableGateway = $this->gameTable->getGateway();				
			}
			return $this->gameTable;			
		}*/
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}		
		
	}

?>
