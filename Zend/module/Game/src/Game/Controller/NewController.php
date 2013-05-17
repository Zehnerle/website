<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Game;
	use Game\Model\GameFilter;
	use Game\Form\GameForm;  
	use Zend\Session\Container;	
	use Zend\Mail\Message;
	use Zend\Mail\Transport\Smtp as SmtpTransport;
	use Zend\Mail\Transport\SmtpOptions;

	class NewController extends AbstractActionController {

		protected $gameTable;
		protected $tableGateway;
		protected $session;				
		
		
		public function newAction() {
		
			$form = new GameForm();
			$game = new Game();		
		
			$user = $this->getSession();

			if($this->session->offsetExists('name')) {
				$game->player1 = $this->session->offsetGet('name');
				$game->mail1 = $this->session->offsetGet('mail');
				$array = array(
					'player1' => $game->player1,
					'mail1' => $game->mail1,
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
		
			$filter = new GameFilter();
			$form->setInputFilter($filter->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$game->exchangeArray($form->getData());
				
				$this->getGameTable()->saveGame($game);
				
				$this->session->offsetSet('name', $game->player1);
				$this->session->offsetSet('mail', $game->mail1);
				$game->id = $this->tableGateway->lastInsertValue;

				$this->sendMail($game);
				
				return $this->redirect()->toRoute('game');
			}
		}
		
		public function sendMail($game) {					
				
			$link = "http://localhost/Zend/game/" . $game->id . "/player2";
			$m = $game->mail1;
			$mail = new Message();
			$mail->setBody("Hi '$game->player2'!\n\nYou were challenged by player '$game->player1' in 'Rock-Paper-Scissors-Lizard-Spock'. If you accept the challenge, follow this link: " .
			$link . "\n\nHave a nice day!");
			$mail->addFrom("$game->mail1");	
			$mail->addTo("$game->mail2");
			$mail->setSubject('You were challenged in Rock-Paper-Scissors-Lizard-Spock!');
			
			$transport = new SmtpTransport();
			$options   = new SmtpOptions(array(
				'host' => 'smtp.uibk.ac.at',
				'name' => 'smtp.uibk.ac.at',
				'connection_class'  => 'login',
				'connection_config' => array(
					'port' => 587,
					'ssl' => 'tls',
					'username' => '',	//username einfuegen
					'password' => '',	//passwort einfuegen
				),
			));

			$transport->setOptions($options);
			$transport->send($mail);    
			
			
		}

		
		public function getGameTable() {
		
			if (!$this->gameTable) {
				$sm = $this->getServiceLocator();
				$this->gameTable = $sm->get('Game\Model\GameTable');
				$this->tableGateway = $this->gameTable->getGateway();				
			}
			return $this->gameTable;			
		}
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}		
		
	}

?>