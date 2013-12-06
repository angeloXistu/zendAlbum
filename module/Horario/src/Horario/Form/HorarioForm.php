<?php
namespace Horario\Form;

use Zend\Form\Form;

class HorarioForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('horario');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'data',
            'attributes' => array(
                'type'  => 'date',
            ),
            'options' => array(
                'label' => 'Data',
            ),
        ));
        $this->add(array(
            'name' => 'fk_patrao',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'loginPatrao',
            ),
        ));
        $this->add(array(
        		'name' => 'fk_funcionario',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'LoginEmpregado',
        		),
        ));
        $this->add(array(
        		'name' => 'entrada',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'entrada',
        		),
        ));
        $this->add(array(
                'name' => 'saida',
                'attributes' => array(
                        'type'  => 'text',
                ),
                'options' => array(
                        'label' => 'saida',
                ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}