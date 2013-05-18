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
		
		
		public function getServiceConfig() {
		 
			return array(
				'factories' => array(
					'Game\Model\GameTable' =>  function($sm) {
						$tableGateway = $sm->get('GameTableGateway');
						$scoreGateway = $sm->get('ScoreTableGateway');
						$table = new GameTable($tableGateway, $scoreGateway);
						return $table;
					},
					'GameTableGateway' => function ($sm) {
						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Game());
						return new TableGateway('game', $dbAdapter, null, $resultSetPrototype);
					},
					'ScoreTableGateway' => function ($sm) {
						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						return new TableGateway('game', $dbAdapter, null, null);
					},
				),
			);
			
		}

		
	}

?>
