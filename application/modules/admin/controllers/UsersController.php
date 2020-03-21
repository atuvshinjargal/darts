<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
    	$request=$this->getRequest();
    	$form= new Form_SearchForm();
    	$this->view->search=$form;
    	$search='';
       $users= new Model_User();
       if ($request->isPost()){
    		if($form->isValid($this->_request->getPost())){
    			$search=$form->getValue('search');
    		}
       }
       $data=$users->getUsers($search.'%');
       $paginator=new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($data));
    	$paginator->setItemCountPerPage(10)
    			->setCurrentPageNumber($this->_getParam('page',1));
       $this->view->data=$paginator;
    }
    public function payAction()
    {
    	$form=new Form_InsertpayForm();
    	$pays= new Admin_Model_Pay();
    	$data=$pays->getpays($this->_getParam('id',1));
    	$paginator=new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($data));
    	$paginator->setItemCountPerPage(10)
    			->setCurrentPageNumber($this->_getParam('page',1));
       $this->view->pays=$paginator;
       $this->view->form=$form;
    }
    public function editAction()
    {
	    	$user =new Model_User();
	    	$userdata=$user->getUser(Zend_Auth::getInstance()->getIdentity()->id);
	    	$request=$this->getRequest();
	    	$form=new Form_RegisterForm();
	    	$img= new Zend_Form_Element_Image('img');
	    	$img->setOrder(0);
	    	$img->src=Zend_Controller_Front::getInstance()->getBaseUrl().'/data/'.$userdata[0]['image'];
	    	$img->setLabel('Өөрийн зураг:');
	    	$form->addElement($img);
	    	$id=new Zend_Form_Element_Hidden('id');
	    	$id->setValue($this->_getParam('id',1));
	    	$image= new Zend_Form_Element_file('image');
	    	$image->setOrder(1);
			$image->setLabel('Солих зурaгаа оруулна уу..')
		      ->setDestination(APPLICATION_PATH.'/../data/upload')
		      ->setRequired(true)
		      ->setMaxFileSize(10240000);  // limits the filesize on the client side
		               // ensure only 1 file
			$image->addValidator('Size', false, 10240000);            // limit to 10 meg
			$image->addValidator('Extension', false, 'jpg,jpeg,png,gif');// only JPEG, PNG, and GIFs
	    	$form->addElement($id);
	    	$form->addElement($image);
	    	$form->setAttrib('enctype', 'multipart/form-data');
	    	$form->getElement('username')->setValue($userdata[0]['username']);
	    	$form->getElement('firstname')->setValue($userdata[0]['firstname']);
	    	$form->getElement('lastname')->setValue($userdata[0]['lastname']);
	    	$form->getElement('email')->setValue($userdata[0]['email']);
	    	$form->getElement('age')->setValue($userdata[0]['age']);
	    	$form->getElement('sex')->setValue($userdata[0]['sex']);
	    	$form->getElement('singup')->setLabel('Ok');
	    	$form->removeElement('captcha');
	    	$form->removeElement('password');
	    	$form->removeElement('confirmPassword');
	    	$form->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/users/edit');
    		if ($request->isPost()){
    			if($form->isValid($this->_request->getPost())){
    				$data = $form->getValues();
    			 	$form->image->receive();
    				$path=md5(microtime()).'.'.pathinfo($form->image->getFileName(), PATHINFO_EXTENSION);
    			 	$image = new Admin_Model_SimpleImage();
   					$image->load($form->image->getFileName());
   					$image->resize(150,200);
   					$image->save(APPLICATION_PATH.'/../public/data/'.$path);
   					unlink($form->image->getFileName());
   					unlink(APPLICATION_PATH.'/../public/data/'.$userdata[0]['image']);
	    				$data['image']=$path;
	    				unset($data['img']);
	    				unset($data['id']);
	    				$user->updateUser($data, Zend_Auth::getInstance()->getIdentity()->id);
	    				$this->view->message='complete..';
    					$this->_redirect('admin/users/edit');
    			}
    		}
	    	$this->view->form=$form;
	    	
	    	
    }
	public function deleteAction()
    {
    	$user =new Model_User();
    	
    	$user->deleteUser($this->_getParam('id',1));
    }
	public function profileAction()
    {
    	$user =new Model_User();
    	$this->view->user=$user->getUser($this->_getParam('id',1));
    }
}



