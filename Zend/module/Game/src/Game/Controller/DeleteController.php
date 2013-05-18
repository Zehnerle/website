<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	
	use Game\Model\GameTable;

	class DeleteController extends AbstractActionController {

		protected $gameTable;
		protected $gameLogic;
		protected $session;				
		
		public function deleteAction() {

			$user = $this->getSession();
			$hash = $this->hashCheck();

			$request = $this->getRequest();			
			if ($request->isPost()) {			
				$delete = $request->getPost('delete', 'No');

				if ($delete == 'Yes')				
					$this->getGameTable()->deleteGame($hash);
					
				return $this->redirect()
						->toRoute('game/result');	
			}

			return array(
				'hash' => $hash,
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
		
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}
		
		
		public function hashCheck() {
			
			$hash = $this->params()->fromRoute('hash', 0);			
			if (!$hash) {
				return $this->redirect()->toRoute('game');
			}
				
			return $hash;
		}	
		
	}

?>