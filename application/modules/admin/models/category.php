<?php
class Admin_Model_Category {
	public function getCategorys(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$identity = Zend_Auth::getInstance()->getIdentity();
	$select = $db->select()->from('category');
	$categorys=$select->query()->fetchAll();
	return $categorys;
	}
}