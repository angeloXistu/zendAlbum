<?php
namespace AlbumRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Album\Model\Album;
use Album\Form\AlbumForm;
use Album\Model\AlbumTable;
use Zend\View\Model\JsonModel;

class AlbumRestController extends AbstractRestfulController
{

    protected $albumTable;

    public function getAlbumTable()
    {
        if (! $this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

    public function getList()
    {
        $results = $this->getAlbumTable()->fetchAll();
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

    public function get($id)
    {
        $album = $this->getAlbumTable()->getAlbum($id);
        
        //return array(
          //  "data" => $album
        //);
        
        $teste = array();
        $teste[] = $album;
        $result = new \Zend\View\Model\JsonModel($teste);

        return $result;
    }

    public function create($data)
    {
        $form = new AlbumForm();
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $album->exchangeArray($form->getData());
            $id = $this->getAlbumTable()->saveAlbum($album);
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $album = $this->getAlbumTable()->getAlbum($id);
        $form = new AlbumForm();
        $form->bind($album);
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getAlbumTable()->saveAlbum($form->getData());
        }
        
        return new JsonModel(array(
            'data' => $this->get($id)
        ));
    }

    public function delete($id)
    {
        $this->getAlbumTable()->deleteAlbum($id);
        
        return new JsonModel(array(
            'data' => 'deleted'
        ));
    }
}