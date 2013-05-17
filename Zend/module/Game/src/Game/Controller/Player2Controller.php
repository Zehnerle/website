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
			$id = $this->idCheck();
			
			$game = $this->getGameTable()->getGame($id);
		
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
						return $this->redirect()
						->toRoute('game/play', array('id' => $id));
					}
					else
						$form->get('mail2')->setMessages(array('Wrong mail address!'));
				}
			}
			
			return array(
				'id' => $id,
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
		
		
		public function idCheck() {
			
			$id = (int) $this->params()->fromRoute('id', 0);			
			if (!$id) {
				return $this->redirect()->toRoute('game');
			}
				
			return $id;
		}
		
	}

?>