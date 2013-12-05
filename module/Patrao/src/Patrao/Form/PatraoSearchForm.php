<?php

namespace Patrao\Form;

use Zend\Form\Form;
use \Zend\Form\Element;

class PatraoSearchForm extends Form {
	public function __construct($name = null) {
		parent::__construct ( 'patrao' );
		$this->setAttribute ( 'class', 'form-horizontal' );
		$this->setAttribute ( 'method', 'post' );
		
		$nome = new Element\Text ( 'nome' );
		$nome->setLabel ( 'Nome' )->setAttribute ( 'class', 'required' )->setAttribute ( 'placeholder', 'Nome' );
		$submit = new Element\Submit ( 'submit' );
		$submit->setValue ( 'Search' )->setAttribute ( 'class', 'btn btn-primary' );
		
		$this->add ( $nome );
		
		$this->add ( $submit );
	}
}


    