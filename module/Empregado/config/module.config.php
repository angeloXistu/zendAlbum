<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Empregado\Controller\Empregado' => 'Empregado\Controller\EmpregadoController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'empregado' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/empregado[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Empregado\Controller\Empregado',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'empregado' => __DIR__ . '/../view',
        ),
    ),
);