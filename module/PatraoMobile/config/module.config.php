<?php
return array (
		'controllers' => array (
				'invokables' => array (
                                                'PatraoMobile\Controller\PatraoMobile' => 'PatraoMobile\Controller\PatraoMobileController'
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'patrao-mobile' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/patrao-mobile[/:id]',
										'defaults' => array (
												'controller' => 'PatraoMobile\Controller\PatraoMobile' 
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