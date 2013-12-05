<?php
namespace PatraoMobile\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Empregado\Model\Empregado;
use Empregado\Form\EmpregadoForm;
use Empregado\Model\EmpregadoTable;
use Zend\View\Model\JsonModel;
use Patrao\Model\PatraoTable;
use Patrao\Model\Patrao;
use Patrao\Form\PatraoForm;

class PatraoMobileController extends AbstractRestfulController
{

    protected $empregadoTable;
    protected $patraoTable;

    public function getEmpregadoTable()
    {
        if (! $this->empregadoTable) {
            $sm = $this->getServiceLocator();
            $this->empregadoTable = $sm->get('Empregado\Model\EmpregadoTable');
        }
        return $this->empregadoTable;
    }
    
    public function getPatraoTable()
    {
        if (! $this->patraoTable) {
            $sm = $this->getServiceLocator();
            $this->patraoTable = $sm->get('Patrao\Model\PatraoTable');
        }
        return $this->patraoTable;
    }

    public function getList()
    {
        $results = $this->getPatraoTable()->fetchAll();
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
    	$patrao = $this->getPatraoTable()->getPatraoByLogin($login);
    
        if(isset($_GET['long'])){
            $long = $_GET['long'];
            $lat = $_GET['lat'];
            $patrao->longitude = $long;
            $patrao->latitude = $lat;
            $this->getPatraoTable()->savePatrao($patrao);
        }
    	//return array(
    	//  "data" => $patrao
    	//);
    
    	$teste = array();
    
        if(isset($_GET['findAll'])){
            $patrao = $_GET['findAll'];
            $emps = $this->getEmpregadoTable()->getEmpregadoByLoginp($patrao);
            foreach ($emps as $emp){
                if(strcmp($patrao, $emp->loginp) == 0)
                    $teste[] = $emp;
            }
        }else{
            $teste[] = $patrao;
        }
        
    	$result = new \Zend\View\Model\JsonModel($teste);
        
    	return $result;
    }

    public function create($data)
    {
        $form = new PatraoForm();
        $patrao = new Patrao();
        $form->setInputFilter($patrao->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $patrao->exchangeArray($form->getData());
            $id = $this->getPatraoTable()->savePatrao($patrao);
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $patrao = $this->getPatraoTable()->getPatrao($id);
        $form = new PatraoForm();
        $form->bind($patrao);
        $form->setInputFilter($patrao->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getPatraoTable()->savePatrao($form->getData());
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function delete($id)
    {
        $this->getPatraoTable()->deletePatrao($id);
        
        return new JsonModel(array(
            'data' => 'deleted'
        ));
    }
}