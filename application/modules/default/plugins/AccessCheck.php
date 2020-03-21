<?php
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{

	private $_acl =null;
	
	public function __construct(Zend_Acl $acl){
		$this->_acl=$acl;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
//		$view->lang=Zend_Registry::get('locale');
		$layout = Zend_Layout::getMvcInstance();
      		$view = $layout->getView();
      		$players=new Admin_Model_player();
    	$view->playerAllRate=$players->getPlayersAllRate();
		$module=$request->getModuleName();
		$resource=$request->getControllerName();
		$action=$request->getActionName();
		
		
		if (!($this->_acl->isAllowed(Zend_Registry::get('role'), $module.':'.$resource, $action)) ){
			$request->setModuleName('default')
					->setControllerName('autentication')
					->setActionName('login');
		}
	}
}