<?php
namespace Horario\Model;

use Zend\InputFilter\Factory as InputFactory; // <-- Add this import
use Zend\InputFilter\InputFilter; // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface; // <-- Add this import
use Zend\InputFilter\InputFilterInterface; // <-- Add this import

class Horario //implements InputFilterAwareInterface
{
    public $id;
    public $entrada;
    public $saida;
    public $fk_patrao;
    public $fk_funcionario;
    public $data;
    protected $inputFilter; // <-- Add this variable

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->entrada = (isset($data['entrada'])) ? $data['entrada'] : null;
        $this->saida = (isset($data['saida'])) ? $data['saida'] : null;
        $this->fk_patrao = (isset($data['fk_patrao'])) ? $data['fk_patrao'] : null;
        $this->fk_funcionario = (isset($data['fk_funcionario'])) ? $data['fk_funcionario'] : null;
        $this->data = (isset($data['data'])) ? $data['data'] : null;
    }
  
    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'data',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}