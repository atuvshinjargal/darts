<?php

class Admin_BookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $game=new Admin_Model_Game();
       $datas=$game->getGamesofContest($this->_getParam('contest',1))->query()->fetchAll();
		$this->view->data=$datas;
		$player=new Admin_Model_player();
		$pre=NULL;
		$preScore=0;
		$preId=0;
			$player->updatePlayer(array('win'=>0,'lose'=>0), 'contest_id = '.$this->_getParam('contest',1));	
		foreach ($datas as $data){
			if ($data['game_id']==$pre){
				if ($preScore>$data['score']){
					$pl=$player->getPlayer('user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('win'=>$pl['win']+1), 'user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$pl=$player->getPlayer('user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('lose'=>$pl['lose']+1), 'user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
				}else{
					if ($preScore<$data['score']){
					$pl=$player->getPlayer('user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('lose'=>$pl['lose']+1), 'user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$pl=$player->getPlayer('user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('win'=>$pl['win']+1), 'user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					}
				}
			}
			$pre=$data['game_id'];
			$preScore=$data['score'];
			$preId=$data['user_id'];
		}
       $this->view->players=$player->getPlayersRate($this->_getParam('contest',1));
    }

    public function addAction()
    {
        $contest= new Admin_Model_contest();
        $paginator=new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($contest->getcontests()));
    	$paginator->setItemCountPerPage(15)
    			->setCurrentPageNumber($this->_getParam('page',1));
    	$this->view->data=$paginator;
       $form=new Form_AddContestForm();
       $this->view->form=$form;
       $request=$this->getRequest();
       if ($request->isPost()){
    		if($form->isValid($this->_request->getPost())){
    			$data = $form->getValues();
    			$data['date']=new Zend_Db_Expr('NOW()');
    			unset($data['Add']);
    			$players=$data['players'];
    			unset($data['players']);
    			$contest->insertContest($data);
    			$contest_id=$contest->getLastId();
    			$pl=new Admin_Model_player();
    			foreach ($players as $payer){
    				$pl->insertPlayer(array('user_id'=>$payer,'contest_id'=>$contest_id));
    			}
    			$game=new Admin_Model_Game();
    			$score=new Admin_Model_Score();
    			for ($i=0;$i<sizeof($players)-1;$i++){
    				for ($j=$i+1;$j<sizeof($players);$j++){
    					$game->insertGame(array('contest_id'=>$contest_id,'date'=>$data['date'],'operator_id'=>'1'));
    					$game_id=$game->getLastId();
    					$score->insertScore(array('user_id'=>$players[$i],'score'=>'0','game_id'=>$game_id));
    					$score->insertScore(array('user_id'=>$players[$j],'score'=>'0','game_id'=>$game_id));
    				}
    			}
    		}
    	}
    }
    public function playerAction()
    {
        
    }

    public function deleteAction()
    {
        $book=new Admin_Model_contest();
        $book->deleteContest($this->_getParam('id',1));
        $pl=new Admin_Model_player();
        $pl->deletePlayers($this->_getParam('id',1));
    	$this->_redirect('admin/book/add');
    }
    public function finisAction()
    {
    $player=new Admin_Model_player();
    $game=new Admin_Model_Game();
       $datas=$game->getGamesofContest($this->_getParam('contest',1))->query()->fetchAll();
		$pre=NULL;
		$preScore=0;
		$preId=0;
			$player->updatePlayer(array('win'=>0,'lose'=>0), 'contest_id = '.$this->_getParam('contest',1));	
		foreach ($datas as $data){
			if ($data['game_id']==$pre){
				if ($preScore>$data['score']){
					$pl=$player->getPlayer('user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('win'=>$pl['win']+1), 'user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$pl=$player->getPlayer('user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('lose'=>$pl['lose']+1), 'user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
				}else{
					if ($preScore<$data['score']){
					$pl=$player->getPlayer('user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('lose'=>$pl['lose']+1), 'user_id = '.$preId.' AND contest_id = '.$this->_getParam('contest',1));
					$pl=$player->getPlayer('user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					$player->updatePlayer(array('win'=>$pl['win']+1), 'user_id = '.$data['user_id'].' AND contest_id = '.$this->_getParam('contest',1));
					}
				}
			}
			$pre=$data['game_id'];
			$preScore=$data['score'];
			$preId=$data['user_id'];
		}
    	$contest = new Admin_Model_contest();
    	$contest->updateContest(array('finisdate'=>new Zend_Db_Expr('NOW()')),array('id = ?'=>$this->_getParam('id',1)));
    	$this->_redirect('admin/book/add');
    }
}







