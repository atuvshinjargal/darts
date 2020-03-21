<?php
class Admin_Model_Score{
	protected $_name='score';
	public function getScores(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name);
	return $select;
	}
	public function getPlayers($game_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from(array('s'=>$this->_name),'s.id as sid')
			->where('game_id =? ', $game_id)
			->join(array('u'=>'users'), 'u.id=s.user_id');
	return $select->query()->fetchAll();
	}
	public function getPlayerScore($game_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from(array('s'=>$this->_name),array('sid'=>'s.id','score'=>'s.score','liveScore'=>'s.liveScore','lastScore'=>'s.lastScore'))
			->where('game_id =? ', $game_id)
			->join(array('u'=>'users'), 'u.id=s.user_id');
	return $select->query()->fetchAll();
	}
	public function insertScore($data){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->insert($this->_name,$data);
	}
	public function deleteScore($score_id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($this->_name, 'id = '.$score_id);
	}
	public function getLastId(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select();
        $select->from($this->_name, "id");
        $select->order('id DESC');
        $select->limit(0, 0);
        $result = $select->query()->fetch();
        return $result['id'];
	}
	public function updateScore($data,$id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->update($this->_name, $data,'id = '.$id);
	}
}