<?php 
namespace Album\Controller;

use Album\Model\AlbumTable;
use Album\Model\Album;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class AlbumController extends AbstractActionController
{

	 private $table;

	 public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
    	$albums=$this->table->fetchall();

    	return ['albums' => $albums];
    }

    public function addAction()
    {
    	$request=$this->getRequest();

    	if($request->isPost()){
    		$album=new Album();
    		$album->exchangeArray($request->getPost()->toArray());
    		$this->table->saveAlbum($album);

    		return $this->redirect()->toRoute('album');
    	}
    }

    public function editAction()
    {

    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	$album=$this->table->getAlbum($id);
        $request = $this->getRequest();
        
        if ( $request->isPost()) {
        	$album->exchangeArray($request->getPost()->toArray());
        	$this->table->saveAlbum($album);    
        	return $this->redirect()->toRoute('album');
        }

        return ['album'=>$album];
    }


    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$this->table->deleteAlbum($id);

    	return $this->redirect()->toRoute('album');
    }
}