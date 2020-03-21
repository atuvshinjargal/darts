<?php
class Form_LoginForm extends Zend_Form{
	public function __construct($option =null){
		parent::__construct($option);
		$this->setName('register');
		$username= new Zend_Form_Element_Text('username');
		$username->setLabel('Хэрэглэгчийн нэр:')
				->setRequired();
		$password= new Zend_Form_Element_Password('password');
		$password->setLabel('Паспорт:')
				->setRequired(true);
		$login=new Zend_Form_Element_Submit('login');
		$login->setAttrib('class', 'btn');
		$login->setLabel('Нэвтрэх');
		$this->addElements(array($username,$password,$login));
		$this->setMethod(post);
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/autentication/login');
	}
}