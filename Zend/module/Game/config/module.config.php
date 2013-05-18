<?php

	return array(
		'controllers' => array(
			'invokables' => array(
				'Game\Controller\Game' => 'Game\Controller\GameController',
				'Game\Controller\New' => 'Game\Controller\NewController',
				'Game\Controller\Play' => 'Game\Controller\PlayController',
				'Game\Controller\Player2' => 'Game\Controller\Player2Controller',
				'Game\Controller\Delete' => 'Game\Controller\DeleteController',
				'Game\Controller\Result' => 'Game\Controller\ResultController',
				'Game\Controller\Rules' => 'Game\Controller\RulesController',
				'Game\Controller\Help' => 'Game\Controller\HelpController',
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
						
						'new' => array(
							'type'    => 'literal',
							'options' => array(
								'route'    => '/new',
								'defaults' => array(
									'controller' => 'Game\Controller\New',
									'action'     => 'new',
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
					
					
						'delete' => array(
							'type'    => 'segment',
							'options' => array(
								'route'    => '[/:hash]/delete',
								'constraints' => array(
									'hash' => '[a-zA-Z0-9_-]*',
								),
								'defaults' => array(
									'controller' => 'Game\Controller\Delete',
									'action'     => 'delete',
								),
							),
						),
						
						'rules' => array(
							'type'    => 'literal',
							'options' => array(
								'route'    => '/rules',
								'defaults' => array(
									'controller' => 'Game\Controller\Rules',
									'action'     => 'rules',
								),
							),
						),
						
						'help' => array(
							'type'    => 'literal',
							'options' => array(
								'route'    => '/help',
								'defaults' => array(
									'controller' => 'Game\Controller\Help',
									'action'     => 'help',
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
		),
	);

?>
