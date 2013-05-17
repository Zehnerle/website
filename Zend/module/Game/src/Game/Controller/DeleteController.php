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
			$id = $this->idCheck();

			$request = $this->getRequest();			
			if ($request->isPost()) {			
				$delete = $request->getPost('delete', 'No');

				if ($delete == 'Yes')				
					$this->getGameTable()->deleteGame($id);
					
				return $this->redirect()
						->toRoute('game/result');	
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