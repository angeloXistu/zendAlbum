<?php

namespace Horario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Horario\Model\Horario; // <-- Add this import
use Horario\Form\HorarioForm; // <-- Add this import
use Horario\Form\HorarioSearchForm;
use Zend\Db\Sql\Select;
use Zend\Validator\File\Size;

class HorarioController extends AbstractActionController {
	protected $horarioTable;
	public function getHorarioTable() {
		if (! $this->horarioTable) {
			$sm = $this->getServiceLocator ();
			$this->horarioTable = $sm->get ( 'Horario\Model\HorarioTable' );
		}
		return $this->horarioTable;
	}
	public function indexAction() {
		/*$searchform = new HorarioSearchForm ();
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
				// var_dump($this->getHorarioTable ()->getHorarioByName ( $formdata ['nome']));
				if ($this->getHorarioTable ()->getHorarioByName ( $formdata ['nome'] )) {
					return new ViewModel ( array (
							'search_by' => $search_by,
							'pageAction' => 'horario',
							'form' => $searchform,
							'horarios' => array (
									$this->getHorarioTable ()->getHorarioByName ( $formdata ['nome'] ) 
							) 
					) );
				}
			}
		}
		return new ViewModel ( array (
				'search_by' => $search_by,
				'pageAction' => 'horario',
				'form' => $searchform,
				'horarios' => $this->getHorarioTable ()->fetchAll () 
		) );*/
		return new ViewModel(array(
				'horarios' => $this->getHorarioTable()->fetchAll(),
		));
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
		$form = new HorarioForm ();
		$form->get ( 'submit' )->setValue ( 'Add' );
		$horario = new Horario (); // Instantiation is moved here to be able to bind
		$form->bind ( $horario ); // Bind instead of manualy exchange data with exchangeArray()
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			// - $horario = new Horario();
			//$form->setInputFilter ( $horario->getInputFilter () );
			$form->setData ( $request->getPost () );			
			if ($form->isValid ()) {
				// - $horario->exchangeArray($form->getData());
				$this->getHorarioTable ()->saveHorario ( $horario );
				var_dump($horario);
				
				// Redirect to list of horarios
				return $this->redirect ()->toRoute ( 'horario' );
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'horario', array (
					'action' => 'add' 
			) );
		}
		$horario = $this->getHorarioTable ()->getHorario ( $id );
		
		$form = new HorarioForm ();
		
		$form->bind ( $horario );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $horario->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				// - $this->getHorarioTable()->saveHorario($form->getData());
				$this->getHorarioTable ()->saveHorario ( $horario ); // We have to deal with the object not data anymore
				                                                  
				// Redirect to list of horarios
				return $this->redirect ()->toRoute ( 'horario' );
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
			return $this->redirect ()->toRoute ( 'horario' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ( 'id' );
				$this->getHorarioTable ()->deleteHorario ( $id );
			}
			
			// Redirect to list of horarios
			return $this->redirect ()->toRoute ( 'horario' );
		}
		
		return array (
				
				'id' => $id,
				'horario' => $this->getHorarioTable ()->getHorario ( $id ) 
		);
	}
}