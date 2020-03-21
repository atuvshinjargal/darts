<?php
class Form_AddContestForm extends Zend_Form{
	public function __construct($option =null){
		parent::__construct($option);
		$this->setName('add');
		//$this->setAttrib('enctype','multipart/form-data');
		
		$title= new Zend_Form_Element_Text('name');
		$title->setLabel('Тэмцээний нэр')
				->setRequired();
				
		
		$add=new Zend_Form_Element_Submit('Add');
		$add->setLabel('Үүсгэх');
		
		$players= new Zend_Form_Element_Multiselect('players');
		$players->setLabel('Тоглох тоглогчдыг сонгох')
				->setRequired(true);
		
		$pl= new Model_User();
		$users=$pl->getUsers('%')->query()->fetchAll();
		
		foreach ($users as $user){
			$players->addMultiOption($user['id'], $user['username']);
		}
		
		$startdate = new ZendX_JQuery_Form_Element_DatePicker('startdate');
		$startdate->setLabel('Startdate:')
			->setRequired(true);
		
		$this->addElements(array($title,$players,$startdate,$add));
		$this->setMethod(post);
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/book/add');
	}
}