<?php
class Form_editScoreForm extends Zend_Form{
	public function __construct($option =null){
		parent::__construct($option);
		$this->setName('login');
		$score1= new Zend_Form_Element_Text('score1');
		$score2= new Zend_Form_Element_Text('score2');
		$id1= new Zend_Form_Element_Hidden('id1');
		$id2= new Zend_Form_Element_Hidden('id2');
		$submit=new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Өөрчлөх');
		$this->addElements(array($score1,$score2,$id1,$id2,$submit));
		$this->setMethod(post);
	}
}