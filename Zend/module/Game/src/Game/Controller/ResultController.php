<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	

	class ResultController extends AbstractActionController {

		protected $gameTable;
		protected $session;				
		
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