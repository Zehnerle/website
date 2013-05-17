<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\Session\Container;	

	class RulesController extends AbstractActionController {

		protected $session;					
		
		public function rulesAction() {	

			$user = $this->getSession();

			return array(
				'user' => $user
			);				
		}			
		
		public function getSession() {
			
			if(!$this->session)
				$this->session = new Container('gameuser');
				
			if($this->session->offsetExists('name'))
				return $this->session->offsetGet('name');			
		}		
		
	}

?>