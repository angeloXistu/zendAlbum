<?php
namespace EmpregadoRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Empregado\Model\Empregado;
use Empregado\Form\EmpregadoForm;
use Empregado\Model\EmpregadoTable;
use Zend\View\Model\JsonModel;

class EmpregadoRestController extends AbstractRestfulController
{

    protected $empregadoTable;

    public function getEmpregadoTable()
    {
        if (! $this->empregadoTable) {
            $sm = $this->getServiceLocator();
            $this->empregadoTable = $sm->get('Empregado\Model\EmpregadoTable');
        }
        return $this->empregadoTable;
    }

    public function getList()
    {
        $results = $this->getEmpregadoTable()->fetchAll();
        $data = array();
        foreach ($results as $result) {
            $data[] = $result;
        }
        $result = new \Zend\View\Model\JsonModel($data);
        return $result;
        //return array(
        //    'data' => $data
        //);
    }
/*
    public function get($id)
    {
        $empregado = $this->getEmpregadoTable()->getEmpregado($id);
        
        //return array(
          //  "data" => $empregado
        //);
        
        $teste = array();
        $teste[] = $empregado;
        $result = new \Zend\View\Model\JsonModel($teste);

        return $result;
    }
    */
    
    public function get($login)
    {
    	$empregado = $this->getEmpregadoTable()->getEmpregadoByLogin($login);
    
    	//return array(
    	//  "data" => $empregado
    	//);
    
    	$teste = array();
    	$teste[] = $empregado;
    	$result = new \Zend\View\Model\JsonModel($teste);
    
    	return $result;
    }

    public function create($data)
    {
        $form = new EmpregadoForm();
        $empregado = new Empregado();
        $form->setInputFilter($empregado->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $empregado->exchangeArray($form->getData());
            $id = $this->getEmpregadoTable()->saveEmpregado($empregado);
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $empregado = $this->getEmpregadoTable()->getEmpregado($id);
        $form = new EmpregadoForm();
        $form->bind($empregado);
        $form->setInputFilter($empregado->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getEmpregadoTable()->saveEmpregado($form->getData());
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function delete($id)
    {
        $this->getEmpregadoTable()->deleteEmpregado($id);
        
        return new JsonModel(array(
            'data' => 'deleted'
        ));
    }
}