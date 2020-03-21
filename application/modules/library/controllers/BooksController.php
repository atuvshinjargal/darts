<?php

class Library_BooksController extends Zend_Controller_Action
{

    public function init()
    {
       $contextSwith=$this->_helper->getHelper('contextSwitch');
       $contextSwith->addActionContext('list','json')
       				->initContext();
    }

    public function indexAction()
    {
    	
    }

    public function listAction()
    {
    	$contest= new Admin_Model_contest();
        $paginator=new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($contest->getcontests()));
    	$paginator->setItemCountPerPage(16)
    			->setCurrentPageNumber($this->_getParam('page',1));
    	$this->view->data=$paginator;
    }
	public function viewAction()
    {
    	$book=new Library_Model_Book();
    	$this->view->book=$book->getBook($this->_getParam('item',1));
    	
    }
	
}
