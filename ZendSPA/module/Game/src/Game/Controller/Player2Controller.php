<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Form\Player2Form; 
	use Zend\Session\Container;	
	use Game\Model\MongoGameTable;
	use Zend\Json\Json;

	class Player2Controller extends AbstractActionController {

		protected $session;				
		
		public function player2Action() {		
			
			$hash = $this->hashCheck();
			
			$mongo = MongoGameTable::getDB();
			$game = $mongo->getGameByHash($hash);
			
			$result = array(
				'player2' => $game->player2,
				'msg1' => $game->msg1,
			);
			
			return $this->getResponse()->setContent(Json::encode($result));
		
		}
		
		
		public function player2AjaxAction() {	

			$user = $this->getSession();
			$hash = $this->hashCheck();
		
			$mongo = MongoGameTable::getDB();
			$game = $mongo->getGameByHash($hash);
		
			$form = new Player2Form();
			
			$request = $this->getRequest();
			if ($request->isPost()) {	
				
				$form->setData($request->getPost());				
				$form->isValid(); // zend hack
				
				$data = $form->getData();
					
				$game->choice2 = $data['choice2'];
				$game->msg2 = $data['msg2'];
				
				$this->session->offsetSet('name', $game->player2);
				$this->session->offsetSet('mail', $game->mail2);
				$this->session->offsetSet('game', $game);
				
				if(!strcmp($data['mailcheckbox'], 'mail'))
					$this->session->offsetSet('sendmail', 'yes');	
				else 				
					$this->session->offsetSet('sendmail', 'no');
				
				return $this->getResponse()->setContent(Json::encode(array("success" => true)));
				
			}
			
			return $this->getResponse()->setContent(Json::encode(array("success" => false)));
		
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