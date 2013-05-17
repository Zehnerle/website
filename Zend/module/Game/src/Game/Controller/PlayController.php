<?php
	
	namespace Game\Controller;

	use Game\Model\GameLogic;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;

	class PlayController extends AbstractActionController {
	
		protected $gameLogic;
		protected $gameTable;
		protected $session;				
		
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
		
		public function getGameLogic() {
		
			if (!$this->gameLogic) {
				$this->gameLogic = new GameLogic();
			}
			return $this->gameLogic;			
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