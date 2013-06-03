<?php

	return array(
		'controllers' => array(
			'invokables' => array(
				'Game\Controller\Game' => 'Game\Controller\GameController',
				'Game\Controller\New' => 'Game\Controller\NewController',
				'Game\Controller\Play' => 'Game\Controller\PlayController',
				'Game\Controller\Player2' => 'Game\Controller\Player2Controller',
				'Game\Controller\Result' => 'Game\Controller\ResultController',				
				'Game\Controller\User' => 'Game\Controller\UserController',
			),
		),
		
		'router' => array(
			'routes' => array(
				'game' => array(
					'type'    => 'literal',
					'options' => array(
						'route'    => '/game',
						'defaults' => array(
							'controller' => 'Game\Controller\Game',
							'action'     => 'index',
						),
					),
					
					'may_terminate' => true,
					'child_routes' => array(
					
						'highscore' => array(
							'type'    => 'literal',
							'options' => array(
								'route'    => '/indexAjax',
								'defaults' => array(
									'controller' => 'Game\Controller\Game',
									'action'     => 'indexAjax',
								),
							),
						),
						
						'new' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/new',
								'defaults' => array(
									'controller' => 'Game\Controller\New',
									'action'     => 'new',
								),
							),
						),						
						
						'newAjax' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/newAjax',
								'defaults' => array(
									'controller' => 'Game\Controller\New',
									'action'     => 'newAjax',
								),
							),
						),						
						
						'player2' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/player2',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Player2',
									'action'     => 'player2',
								),
							),
						),
						
						'player2Ajax' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/player2Ajax',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Player2',
									'action'     => 'player2Ajax',
								),
							),
						),
						
						
						'play' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/play',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Play',
									'action'     => 'play',
								),
							),
						),	
						
						'playAjax' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/playAjax',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Play',
									'action'     => 'playAjax',
								),
							),
						),	
						
					
						'result' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/result',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Result',
									'action'     => 'result',
								),
							),
						),
						
						'resultAjax' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/resultAjax',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Result',
									'action'     => 'resultAjax',
								),
							),
						),	

						'user' => array(
							'type'    => 'literal',
							'options' => array(
								'route'    => '/user',
								'defaults' => array(
									'controller' => 'Game\Controller\User',
									'action'     => 'user',
								),
							),
						),						
						
												
					),					
				),						
			),
		),
		
		'view_manager' => array(
			'template_path_stack' => array(
				'game' => __DIR__ . '/../view',
			),
			'strategies' => array(
				'ViewJsonStrategy',
			),
		),
	);

?>
