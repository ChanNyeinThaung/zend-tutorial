<?php 
namespace Artist\Controller;

use Artist\Model\ArtistTable;
use Artist\Model\Artist;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ArtistController extends AbstractActionController
{

	 private $table;

	 public function __construct(ArtistTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
    	$artists=$this->table->fetchall();

    	return ['artists' => $artists];
    }

    public function addAction()
    {
    	$request=$this->getRequest();

    	if($request->isPost()){
    		$artist=new Artist();
    		$artist->exchangeArray($request->getPost()->toArray());
    		$this->table->saveArtist($artist);

    		return $this->redirect()->toRoute('artist');
    	}
    }

    public function editAction()
    {

    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	$artist=$this->table->getArtist($id);
        $request = $this->getRequest();
        
        if ( $request->isPost()) {
        	$artist->exchangeArray($request->getPost()->toArray());
        	$this->table->saveArtist($artist);    
        	return $this->redirect()->toRoute('artist');
        }

        return ['artist'=>$artist];
    }


    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$this->table->deleteArtist($id);

    	return $this->redirect()->toRoute('artist');
    }
}