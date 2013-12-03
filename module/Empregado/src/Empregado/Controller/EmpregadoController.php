<?php
namespace Empregado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Empregado\Model\Empregado;          // <-- Add this import
use Empregado\Form\EmpregadoForm;       // <-- Add this import

class EmpregadoController extends AbstractActionController
{
    protected $empregadoTable;
    
    public function getEmpregadoTable()
    {
        if (!$this->empregadoTable) {
            $sm = $this->getServiceLocator();
            $this->empregadoTable = $sm->get('Empregado\Model\EmpregadoTable');
        }
        return $this->empregadoTable;
    }
    
    public function indexAction()
    {
        return new ViewModel(array(
            'empregados' => $this->getEmpregadoTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new EmpregadoForm();
        $form->get('submit')->setValue('Add');
		$empregado = new Empregado(); // Instantiation is moved here to be able to bind 
		$form->bind($empregado); // Bind instead of manualy exchange data with exchangeArray()
        $request = $this->getRequest();
        if ($request->isPost()) {
//-            $empregado = new Empregado();
            $form->setInputFilter($empregado->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
 //-               $empregado->exchangeArray($form->getData());
                $this->getEmpregadoTable()->saveEmpregado($empregado);

                // Redirect to list of empregados
                return $this->redirect()->toRoute('empregado');
            }
        }
        return array('form' => $form);
    }


    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('empregado', array(
                'action' => 'add'
            ));
        }
        $empregado = $this->getEmpregadoTable()->getEmpregado($id);


        $form = new EmpregadoForm();

        $form->bind($empregado);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($empregado->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
//-                $this->getEmpregadoTable()->saveEmpregado($form->getData());
                $this->getEmpregadoTable()->saveEmpregado($empregado); // We have to deal with the object not data anymore
				
                // Redirect to list of empregados
                return $this->redirect()->toRoute('empregado');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('empregado');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getEmpregadoTable()->deleteEmpregado($id);
            }

            // Redirect to list of empregados
            return $this->redirect()->toRoute('empregado');
        }

        return array(

            'id'    => $id,
            'empregado' => $this->getEmpregadoTable()->getEmpregado($id)
        );
    }
}