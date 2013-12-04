<?php
return array (
		'controllers' => array (
				'invokables' => array (
                                                'EmpregadoMobile\Controller\EmpregadoMobile' => 'EmpregadoMobile\Controller\EmpregadoMobileController'
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'empregado-mobile' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/empregado-mobile[/:id]',
										'defaults' => array (
												'controller' => 'EmpregadoMobile\Controller\EmpregadoMobile' 
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