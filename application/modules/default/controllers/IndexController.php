<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$contextSwith=$this->_helper->getHelper('contextSwitch');
       $contextSwith->addActionContext('game','json')
       				->initContext();
    }

    public function indexAction()
    {
    	$this->view->headTitle('index page','PREPEND');
    	if (Zend_Registry::get('role')!='payer'){
    		$this->_redirect('/library/books/list');
    	}else{
    		$this->_redirect('/index/pay');
    	}
        // action body
    }
	public function payAction()
    {
    	$pays= new Admin_Model_Pay();
    	$data=$pays->getpays(Zend_Auth::getInstance()->getIdentity()->user_id);
    	$paginator=new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($data));
    	$paginator->setItemCountPerPage(10)
    			->setCurrentPageNumber($this->_getParam('page',1));
       $this->view->pays=$paginator;
    }
    public function editAction()
    {
        // action body
    }
	public function listAction()
    {
       $request=$this->getRequest();
    	$form= new Form_SearchForm();
    	$form->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/default/index/list');
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
    public function gameAction(){
    	$score= new Admin_Model_Score();
    	$data=$score->getPlayerScore($this->_getParam('id',1));
    	$contest= new Admin_Model_contest();
    	$con=$contest->getContestTime($this->_getParam('contest',1));
	    if (Zend_Registry::get('role')=='admins' && $con['finisdate']=='3000-00-00'){
	       		$form=new Form_editScoreForm();
	       		$form->getElement('score1')->setLabel($data[0]['firstname'].' '.$data[0]['lastname']);
	       		$form->getElement('score2')->setLabel($data[1]['firstname'].' '.$data[1]['lastname']);
	       		$form->getElement('id1')->setValue($data[0]['sid']);
	       		$form->getElement('id2')->setValue($data[1]['sid']);
	       		Zend_Controller_Front::getInstance()->getBaseUrl().'/default/index/game/id/'.$this->_getParam('id',1);
	       		$this->view->form=$form;
	       		$request=$this->getRequest();
       			if ($request->isPost()){
		    		if($form->isValid($this->_request->getPost())){
		    			$usename=$form->getValue('username');
		    			$score->updateScore(array('score'=>$form->getValue('score1')),$form->getValue('id1'));
		    			$score->updateScore(array('score'=>$form->getValue('score2')),$form->getValue('id2'));
		    		}
	    		}
	     }
    	$data=$score->getPlayerScore($this->_getParam('id',1));
    	$this->view->data=$data;
    	$this->view->contest=$this->_getParam('contest',1);
       	
    }
    public function contestsAction(){
    	$contest =new Admin_Model_contest();
    	$contests=$contest->getLiveContests();
    	$contestsar=array();
    	foreach ($contests as $con){
    		array_push($contestsar, array('id'=>$con['id'],
							'name'=>$con['name']));	
    	}
    	$this->view->contests=array('contests'=>$contestsar);
    }
 	public function gamesAction(){
    	$game=new Admin_Model_Game();
       	$games=$game->getGamesofContest($this->_getParam('contest',1))->query()->fetchAll();
       	$gameid=null;
       	$name=NULL;
       	$score=NULL;
       	$list=array();
       	$i=1;
       	foreach ($games as $game){
       		if ($game['game_id']==$gameid){
       			$l['id']=$gameid;
       			$l['name']=$i.'.  '.$name.' '.$score.' - '.$game['score'].' '.$game['username'];
       			array_push($list,$l);
       			$i++;
       		}
       		$gameid=$game['game_id'];
       		$name=$game['username'];
       		$score=$game['score'];
       	}
    	$this->view->contests=array('contests'=>$list);
    }
    public function refereeAction(){
    	$game=new Admin_Model_Game();
    	$this->view->contests=$game->getReferee($this->_getParam('id',1));
    }
    public function liveAction(){
    	$score= new Admin_Model_Score();
    	$list=array();
    	foreach ($score->getPlayers($this->_getParam('id',1)) as $player){
    		$l['id']=$player['sid'];
       		$l['name']=$player['username'];
    		array_push($list,$l);
    	}
    	$this->view->contests=array('contests'=>$list);
    }
   public function putAction(){
    	$score= new Admin_Model_Score();
		$score->updateScore(array('liveScore'=>$this->_getParam('score',1),'lastScore'=>$this->_getParam('last',1),'score'=>$this->_getParam('set',1)),$this->_getParam('id',1));
   		$this->view->contests=array('contests'=>'test');
   }
}



