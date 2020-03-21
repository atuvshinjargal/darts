<?php
class Form_RegisterForm extends Zend_Form{
	public function __construct($option =null){
		parent::__construct($option);
		$this->setName('register');
		$this->setAttrib('class', 'form-horizontal');
		$username= new Zend_Form_Element_Text('username');
		$username->setLabel('Хэрэглэгчийн нэр: *')
				->setRequired();	
				
		$password= new Zend_Form_Element_Password('password');
		$password->setLabel('Пасспорт оруулна уу: *')
				->setRequired(true);
		$password->addFilter(new Zend_Filter_StringTrim())
    			->addValidator(new Zend_Validate_NotEmpty());
				
		$confirmpassword= new Zend_Form_Element_Password('confirmPassword');
		$confirmpassword->setLabel('Пасспорт дахин оруулна уу: *')
				->setRequired(true);
		$confirmpassword->addValidator('StringLength', false, array(6,24))
            ->addFilter(new Zend_Filter_StringTrim())
    		->addValidator(new Zend_Validate_Identical($_POST['password']));		

		$firstname = new Zend_Form_Element_Text('firstname');
		$firstname->setLabel('Овог:')
				->setRequired(true);
		
		$lastname = new Zend_Form_Element_Text('lastname');
		$lastname->setLabel('Нэр:')
				->setRequired(true);
		
		$age = new Zend_Form_Element_Text('age');
		$age->setLabel('Нас:')
				->setRequired(true);
		
		$sex = new Zend_Form_Element_Select('sex');
		$sex->setLabel('Хүйс:')
				->setRequired(true);
		$sex->addMultiOption('Эр','Эр');
		$sex->addMultiOption('Эм','Эм');
			
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email: *')
			->addFilters(array('StringTrim', 'StripTags'))
    		->addValidator('EmailAddress',  TRUE  )
				->setRequired(true);	
		
		$singup=new Zend_Form_Element_Submit('singup');
		$singup->setAttrib('class', 'btn');
		$singup->setLabel('Бүртгүүлэх')
				->setIgnore(true);;
		
		$this->addElements(array($username,$password,$confirmpassword,$firstname,$lastname,$age,$sex,$email,$singup));
		$this->setMethod(post);
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/autentication/signup');
	}
}