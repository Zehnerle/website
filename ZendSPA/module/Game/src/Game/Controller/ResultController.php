<?php
	
	namespace Game\Controller;

	use Game\Model\MongoGameTable;
	use Game\Model\GameLogic;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	
	use Zend\Json\Json;

	class ResultController extends AbstractActionController {

		protected $gameLogic;
		protected $session;				
		
		public function resultAction() {	
		
			$mongo = MongoGameTable::getDB();			

			$hash = $this->params()->fromRoute('hash', 0);
			$enum = $this->getGameLogic()->getEnum();
			
			if ($hash) {
				$results = array(
					'actualgame' => $mongo->getGameByHash($hash),
					'enum' => $enum,
				);
			}
			
			return $this->getResponse()->setContent(Json::encode($results));
			
		}
		
		public function resultAjaxAction() {	
		
			$mongo = MongoGameTable::getDB();

			$user = $this->getSession();
			
			$enum = $this->getGameLogic()->getEnum();

			if(!empty($user)) {
								
				$results = array(
					"user" => $user,
					'opengames' => $mongo->fetchOpenGames($user),
					'closedgames' => $mongo->fetchClosedGames($user),
					'enum' => $enum,
				);
				
				return $this->getResponse()->setContent(Json::encode($results));
			}
			
			return $this->getResponse()->setContent(Json::encode(array("success" => false)));
			
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
		
	}

?>