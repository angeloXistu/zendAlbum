<?php
namespace PatraoRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Patrao\Model\Patrao;
use Patrao\Form\PatraoForm;
use Patrao\Model\PatraoTable;
use Zend\View\Model\JsonModel;

class PatraoRestController extends AbstractRestfulController
{

    protected $patraoTable;

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
        $patrao = $this->getPatraoTable()->getPatrao($id);
        
        //return array(
          //  "data" => $patrao
        //);
        
        $teste = array();
        $teste[] = $patrao;
        $result = new \Zend\View\Model\JsonModel($teste);

        return $result;
    }
    */
    
    public function get($login)
    {
    	$patrao = $this->getPatraoTable()->getPatraoByLogin($login);
    
    	//return array(
    	//  "data" => $patrao
    	//);
    
    	$teste = array();
    	$teste[] = $patrao;
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