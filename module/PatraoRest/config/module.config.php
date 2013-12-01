<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'PatraoRest\Controller\PatraoRest' => 'PatraoRest\Controller\PatraoRestController' 
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'patrao-rest' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/patrao-rest[/:id]',
										'defaults' => array (
												'controller' => 'PatraoRest\Controller\PatraoRest' 
										) 
								) 
						) 
				) 
		),
		'view_manager' => array ( // Add this config
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		) 
);