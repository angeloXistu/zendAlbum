<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Horario\Controller\Horario' => 'Horario\Controller\HorarioController' 
				) 
		),
		// The following section is new and should be added to your file
		'router' => array (
				'routes' => array (
						'horario' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/horario[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
										'constraints' => array (
												'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
												'page' => '[0-9]+',
												'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'order' => 'ASC|DESC' 
										),
										'defaults' => array (
												'controller' => 'Horario\Controller\Horario',
												'action' => 'index' 
										) 
								) 
						) 
				) 
		),
		
		'view_manager' => array (
				'template_path_stack' => array (
						'horario' => __DIR__ . '/../view' 
				),
		), 
);