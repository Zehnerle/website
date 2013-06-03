<?php
	
	namespace Game\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Game\Model\MongoGameTable;
	use Zend\Json\Json;
	use Zend\View\Model\ViewModel;

	class GameController extends AbstractActionController {

		protected $session;			

		public function indexAction() {	
		
			return new ViewModel();
			
		}	

		public function indexAjaxAction() {
		
			$mongo = MongoGameTable::getDB();	
			
			$result = array(
				'highscore' => $mongo->getHighscore(),
			);
			
			return $this->getResponse()->setContent(Json::encode($result));
			
		}		
			
	}

?>