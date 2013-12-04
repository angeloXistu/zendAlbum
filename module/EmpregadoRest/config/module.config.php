<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'EmpregadoRest\Controller\EmpregadoRest' => 'EmpregadoRest\Controller\EmpregadoRestController' 
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'empregado-rest' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/empregado-rest[/:id]',
										'defaults' => array (
												'controller' => 'EmpregadoRest\Controller\EmpregadoRest' 
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