<?php
namespace Empregado\Form;

use Zend\Form\Form;

class EmpregadoForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('empregado');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Nome:',
            ),
        ));
        $this->add(array(
            'name' => 'telefone',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Telefone: ',
            ),
        ));
        $this->add(array(
        		'name' => 'login',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Login: ',
        		),
        ));
        $this->add(array(
        		'name' => 'senha',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Senha: ',
        		),
        ));
        $this->add(array(
                'name' => 'loginp',
                'attributes' => array(
                        'type'  => 'text',
                ),
                'options' => array(
                        'label' => 'Login Patrão: ',
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