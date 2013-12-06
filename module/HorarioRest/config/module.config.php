<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'HorarioRest\Controller\HorarioRest' => 'HorarioRest\Controller\HorarioRestController',
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'horario-rest' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/horario-rest[/:id]',
										'defaults' => array (
												'controller' => 'HorarioRest\Controller\HorarioRest' 
										) 
								),
                                                    ),
						), 
				
		),
		'view_manager' => array ( // Add this config
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		) 
);