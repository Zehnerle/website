<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\Player2Filter;
	use Game\Form\Player2Form; 
	use Zend\Session\Container;	

	class Player2Controller extends AbstractActionController {

		protected $gameTable;
		protected $session;				
		
		public function player2Action() {	

			$user = $this->getSession();
			$hash = $this->hashCheck();
			
			$game = $this->getGameTable()->getGameByHash($hash);
		
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
						
						if(!strcmp($data['mailcheckbox'], 'mail'))
							$this->session->offsetSet('sendmail', 'yes');		
						
						return $this->redirect()
						->toRoute('game/play', array('hash' => $hash));
					}
					else
						$form->get('mail2')->setMessages(array('Wrong mail address!'));
				}
			}
			
			return array(
				'hash' => $hash,
				'user' => $user,
				'player2' => $game->player2,
				'form' => $form
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