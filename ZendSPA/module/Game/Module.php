<?php

	namespace Game;
	
	use Game\Model\Game;
	use Game\Model\GameTable;
	use Zend\Db\ResultSet\ResultSet;
	use Zend\Db\TableGateway\TableGateway;


	class Module {

		public function getAutoloaderConfig() {
			
			return array(
				'Zend\Loader\StandardAutoloader' => array(
					'namespaces' => array(
						__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					),
				),
			);
			
		}		
		
		public function getConfig() {
			return include __DIR__ . '/config/module.config.php';
		}	
		
	}

?>
