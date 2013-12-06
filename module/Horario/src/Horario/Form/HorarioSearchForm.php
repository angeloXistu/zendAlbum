<?php

namespace Horario\Form;

use Zend\Form\Form;
use \Zend\Form\Element;

class HorarioSearchForm extends Form {
	public function __construct($name = null) {
		parent::__construct ( 'horario' );
		$this->setAttribute ( 'class', 'form-horizontal' );
		$this->setAttribute ( 'method', 'post' );
		
		$nome = new Element\Text ( 'loginFuncionario' );
		$nome->setLabel ( 'loginFuncionario' )->setAttribute ( 'class', 'required' )->setAttribute ( 'placeholder', 'fk_funcionario' );
		$submit = new Element\Submit ( 'submit' );
		$submit->setValue ( 'Search' )->setAttribute ( 'class', 'btn btn-primary' );
		
		$this->add ( $nome );
		
		$this->add ( $submit );
	}
}


    