<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	

	class GameController extends AbstractActionController {

		protected $gameTable;
		protected $session;		
	
	
		public function indexAction() {
		
			$user = $this->getSession();
		
			return array(
				'user' => $user,
				'games' => $this->getGameTable()->fetchOpenGames(),
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
			
	}

?>