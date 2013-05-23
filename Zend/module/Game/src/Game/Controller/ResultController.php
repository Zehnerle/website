<?php
	
	namespace Game\Controller;

	use Game\Model\MongoGameTable;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	

	class ResultController extends AbstractActionController {

		protected $gameTable;
		protected $session;				
		
		public function resultAction() {	
		
			$mongo = MongoGameTable::getDB();

			$user = $this->getSession();
			$results = array('user' => $user);

			// if came in via mail notification
			$hash = $this->params()->fromRoute('hash', 0);
			if ($hash) {
				//$actual = array('actualgame' => $this->getGameTable()->getGameByHash($hash));
				$actual = array('actualgame' => $mongo->getGameByHash($hash));
				$results = $results + $actual;
			}
			
			// normal
			else if(!empty($user))		{
				
				/*$games = array(
					'opengames' => $this->getGameTable()->fetchOpenGames($user),
					'closedgames' => $this->getGameTable()->fetchClosedGames($user),
				);	*/			
								
				$games = array(
					'opengames' => $mongo->fetchOpenGames($user),
					'closedgames' => $mongo->fetchClosedGames($user),
				);
				
				$results = $results + $games;
			}
			
			return $results;			
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
		
	}

?>