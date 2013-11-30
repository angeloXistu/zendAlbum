<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	protected $albumTable;
	
	public function getAlbumTable(){
		if (!$this->albumTable) {
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Album\Model\AlbumTable');
		}
		return $this->albumTable;
	}
	
    public function indexAction(){
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }
    
    public function editAction(){
    	return new ViewModel(array(
    			'albums' => $this->getAlbumTable()->fetchAll(),
    	));
    }
    public function deleteAction(){
    	return new ViewModel(array(
    			'albums' => $this->getAlbumTable()->fetchAll(),
    	));
    }
    public function addAction(){
    	return new ViewModel(array(
    			'albums' => $this->getAlbumTable()->fetchAll(),
    	));
    }
}
