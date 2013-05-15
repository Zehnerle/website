<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Game;
	use Game\Model\GameLogic;	
	use Game\Model\GameFilter;
	use Game\Model\Player2Filter;
	use Game\Form\GameForm;  
	use Game\Form\Player2Form; 
	use Zend\Session\Container;	
	use Zend\Session\SaveHandler;

	class GameController extends AbstractActionController {

		protected $gameTable;
		protected $gameLogic;
		protected $session;		
	
	
		public function indexAction() {
		
			$user = $this->getSession();
		
			return array(
				'user' => $user,
				'games' => $this->getGameTable()->fetchOpenGames(),
			);
		}
		
		
		public function newAction() {
		
			$user = $this->getSession();
		
			$form = new GameForm();
			$game = new Game();						

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
			if ($request->isPost()) {
			
				$filter = new GameFilter();
				$form->setInputFilter($filter->getInputFilter());
				$form->setData($request->getPost());

				if ($form->isValid()) {
					$game->exchangeArray($form->getData());
					
					$this->getGameTable()->saveGame($game);
					
					$this->session->offsetSet('name', $game->player1);
					$this->session->offsetSet('mail', $game->mail1);
					
					return $this->redirect()->toRoute('game');
				}
			}
			
			return array (
				'user' => $user,
				'form' => $form
			);

		}

		
		public function player2Action() {	

			$user = $this->getSession();
			$id = $this->idCheck();
			
			$game = $this->getGameTable()->getGame($id);
		
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
						return $this->redirect()
						->toRoute('game', array('id' => $id, 'action'=>'play'));
					}
					else
						$form->get('mail2')->setMessages(array('Wrong mail address!'));
				}
			}
			
			return array(
				'id' => $id,
				'user' => $user,
				'player2' => $game->player2,
				'form' => $form
			);
		
		}
		
		
		public function playAction() {
		
			$user = $this->getSession();		
			$id = $this->idCheck();
			
			$game = $this->session->offsetGet('game');	
			
			$game->choice2--;	 // form and DB indices start at 1
			$enum = $this->getGameLogic()->getEnum();
			$game->choice2 = $enum[$game->choice2];
			
			$game->getResult();
			$this->getGameTable()->saveGame($game);
					
					
			return array(
				'id'   => $id,				
				'user' => $user,
				'game' => $game
			);		
		}

		
		public function resultAction() {	

			$user = $this->getSession();
			$results = array('user' => $user);			
			
			if(!empty($user))		{
				$games = array(
					'closedgames' => $this->getGameTable()->fetchClosedGames($user),
				);				
				$results = $results + $games;
			}
			
			return $results;			
		}
		
		
		public function deleteAction() {	

			$user = $this->getSession();
			$id = $this->idCheck();

			$request = $this->getRequest();			
			if ($request->isPost()) {			
				$delete = $request->getPost('delete', 'No');

				if ($delete == 'Yes')
					$this->getGameTable()->deleteGame($id);
					
				return $this->redirect()
						->toRoute('game', array('action'=>'result'));	
			}

			return array(
				'id'    => $id,
				'user' => $user
			);			
		}		
		
		
		public function getGameTable() {
		
			if (!$this->gameTable) {
				$sm = $this->getServiceLocator();
				$this->gameTable = $sm->get('Game\Model\GameTable');
			}
			return $this->gameTable;			
		}
		
		
		public function getGameLogic() {
		
			if (!$this->gameLogic) {
				$this->gameLogic = new GameLogic();
			}
			return $this->gameLogic;			
		}
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}
		
		
		public function idCheck() {
			
			$id = (int) $this->params()->fromRoute('id', 0);			
			if (!$id) {
				return $this->redirect()->toRoute('game');
			}
				
			return $id;
		}	
		
	}

?>