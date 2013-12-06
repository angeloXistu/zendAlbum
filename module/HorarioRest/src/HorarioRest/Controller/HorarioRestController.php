<?php

namespace HorarioRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Horario\Model\Horario;
use Horario\Form\HorarioForm;
use Horario\Model\HorarioTable;
use Zend\View\Model\JsonModel;

class HorarioRestController extends AbstractRestfulController {
	protected $horarioTable;
	public function getHorarioTable() {
		if (! $this->horarioTable) {
			$sm = $this->getServiceLocator ();
			$this->horarioTable = $sm->get ( 'Horario\Model\HorarioTable' );
		}
		return $this->horarioTable;
	}
	public function getList() {
		$results = $this->getHorarioTable ()->fetchAll ();
		$data = array ();
		foreach ( $results as $result ) {
			$data [] = $result;
		}
		$result = new \Zend\View\Model\JsonModel ( $data );
		return $result;
		// return array(
		// 'data' => $data
		// );
	}
	/*
	 * public function get($id) { $horario = $this->getHorarioTable()->getHorario($id); //return array( // "data" => $horario //); $teste = array(); $teste[] = $horario; $result = new \Zend\View\Model\JsonModel($teste); return $result; }
	 */
	public function get($login) {
		$horarios = array ();
		$horarios = $this->getHorarioTable ()->getHorariosByLoginFuncionario ( $login );
                
                if(isset($_GET['hora_i'])){
                    $horaAtualI = $_GET['hora_i'];
                    $dataAtualI = $_GET['data_i'];
                    $horaAtualF = $_GET['hora_f'];
                    $patrao = $_GET['patrao'];
                    
                    
                    
     
                    $horaSalva = end($horarios);
                    if($horaSalva != null){
                        $horaSalva->entrada = $horaAtualI;
                        $horaSalva->saida = $horaAtualF;
                        $horaSalva->data = $dataAtualI;
                        
                        $id = $this->getHorarioTable()->saveHorario($horaSalva);
                        
                    } else{
                        $horaSalvaObj = new Horario();
                        $horaSalvaObj->entrada = $horaAtualI;
                        $horaSalvaObj->saida = $horaAtualF;
                        $horaSalvaObj->data = $dataAtualI;
                        $horaSalvaObj->fk_patrao = $patrao;
                        $horaSalvaObj->fk_funcionario = $login;
                        
                        $id = $this->getHorarioTable()->saveHorario($horaSalvaObj);
                    }
                }
                
                $result = new \Zend\View\Model\JsonModel ( $horarios );
		return $result;
	}
	public function create($data) {
		$form = new HorarioForm ();
		$horario = new Horario ();
		$form->setInputFilter ( $horario->getInputFilter () );
		$form->setData ( $data );
		if ($form->isValid ()) {
			$horario->exchangeArray ( $form->getData () );
			$id = $this->getHorarioTable ()->saveHorario ( $horario );
		}
		
		return new JsonModel ( array (
				'data' => $this->get ( $id ) 
		) );
	}
	public function update($id, $data) {
		$data ['id'] = $id;
		$horario = $this->getHorarioTable ()->getHorario ( $id );
		$form = new HorarioForm ();
		$form->bind ( $horario );
		$form->setInputFilter ( $horario->getInputFilter () );
		$form->setData ( $data );
		if ($form->isValid ()) {
			$id = $this->getHorarioTable ()->saveHorario ( $form->getData () );
		}
		
		return new JsonModel ( array (
				'data' => $this->get ( $id ) 
		) );
	}
	public function delete($id) {
		$this->getHorarioTable ()->deleteHorario ( $id );
		
		return new JsonModel ( array (
				'data' => 'deleted' 
		) );
	}
}