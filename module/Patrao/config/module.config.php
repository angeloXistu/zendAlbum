<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Patrao\Controller\Patrao' => 'Patrao\Controller\PatraoController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'patrao' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/patrao[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Patrao\Controller\Patrao',
                        'action'     => 'index',

                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'patrao' => __DIR__ . '/../view',
        ),
    ),
);