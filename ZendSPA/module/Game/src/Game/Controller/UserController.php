<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	
	use Zend\Json\Json;

	class UserController extends AbstractActionController {

		protected $session;	
		
		public function userAction() {
		
			$user = $this->getSession();	
			
			$result = array(
				'user' => $user
			);
			
			return $this->getResponse()->setContent(Json::encode($result));
		
		}	
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}
			
	}

?>