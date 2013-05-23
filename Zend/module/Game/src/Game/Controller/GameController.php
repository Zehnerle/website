<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	
	use Game\Model\MongoGameTable;

	class GameController extends AbstractActionController {

		protected $gameTable;
		protected $session;		
	
	
		public function indexAction() {
		
			$user = $this->getSession();
			$mongo = MongoGameTable::getDB();		
		
			return array(
				'user' => $user,
				//'highscore' => $this->getGameTable()->getHighscore(),
				'highscore' => $mongo->getHighscore(),
			);
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