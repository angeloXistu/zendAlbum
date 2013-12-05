<?php

namespace Patrao\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Patrao\Model\Patrao; // <-- Add this import
use Patrao\Form\PatraoForm; // <-- Add this import
use Patrao\Form\PatraoSearchForm;
use Zend\Db\Sql\Select;
use Zend\Validator\File\Size;

class PatraoController extends AbstractActionController {
	protected $patraoTable;
	public function getPatraoTable() {
		if (! $this->patraoTable) {
			$sm = $this->getServiceLocator ();
			$this->patraoTable = $sm->get ( 'Patrao\Model\PatraoTable' );
		}
		return $this->patraoTable;
	}
	public function indexAction() {
		$searchform = new PatraoSearchForm ();
		$searchform->get ( 'submit' )->setValue ( 'Search' );
		
		$select = new Select ();
		
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_ASCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		$select->order ( $order_by . ' ' . $order );
		$search_by = $this->params ()->fromRoute ( 'search_by' ) ? $this->params ()->fromRoute ( 'search_by' ) : '';
		
		$where = new \Zend\Db\Sql\Where ();
		$formdata = array ();
		// var_dump($search_by );
		if (! empty ( $search_by )) {
			$formdata = ( array ) json_decode ( $search_by );
			if (! empty ( $formdata ['nome'] )) {
				// var_dump($this->getPatraoTable ()->getPatraoByName ( $formdata ['nome']));
				if ($this->getPatraoTable ()->getPatraoByName ( $formdata ['nome'] )) {
					return new ViewModel ( array (
							'search_by' => $search_by,
							'pageAction' => 'patrao',
							'form' => $searchform,
							'patraos' => array (
									$this->getPatraoTable ()->getPatraoByName ( $formdata ['nome'] ) 
							) 
					) );
				}
			}
		}
		return new ViewModel ( array (
				'search_by' => $search_by,
				'pageAction' => 'patrao',
				'form' => $searchform,
				'patraos' => $this->getPatraoTable ()->fetchAll () 
		) );
	}
	public function searchAction() {
		$request = $this->getRequest ();
		
		$url = 'index';
		
		if ($request->isPost ()) {
			$formdata = ( array ) $request->getPost ();
			$search_data = array ();
			foreach ( $formdata as $key => $value ) {
				if ($key != 'submit') {
					if (! empty ( $value )) {
						$search_data [$key] = $value;
					}
				}
			}
			if (! empty ( $search_data )) {
				$search_by = json_encode ( $search_data );
				$url .= '/search_by/' . $search_by;
			}
		}
		$this->redirect ()->toUrl ( $url );
	}
	public function addAction() {
		$form = new PatraoForm ();
		$form->get ( 'submit' )->setValue ( 'Add' );
		$patrao = new Patrao (); // Instantiation is moved here to be able to bind
		$form->bind ( $patrao ); // Bind instead of manualy exchange data with exchangeArray()
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			// - $patrao = new Patrao();
			$form->setInputFilter ( $patrao->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				// - $patrao->exchangeArray($form->getData());
				$this->getPatraoTable ()->savePatrao ( $patrao );
				
				// Redirect to list of patraos
				return $this->redirect ()->toRoute ( 'patrao' );
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'patrao', array (
					'action' => 'add' 
			) );
		}
		$patrao = $this->getPatraoTable ()->getPatrao ( $id );
		
		$form = new PatraoForm ();
		
		$form->bind ( $patrao );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $patrao->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				// - $this->getPatraoTable()->savePatrao($form->getData());
				$this->getPatraoTable ()->savePatrao ( $patrao ); // We have to deal with the object not data anymore
				                                                  
				// Redirect to list of patraos
				return $this->redirect ()->toRoute ( 'patrao' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'patrao' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ( 'id' );
				$this->getPatraoTable ()->deletePatrao ( $id );
			}
			
			// Redirect to list of patraos
			return $this->redirect ()->toRoute ( 'patrao' );
		}
		
		return array (
				
				'id' => $id,
				'patrao' => $this->getPatraoTable ()->getPatrao ( $id ) 
		);
	}
}