<?php
class Admin_Model_Game{
	protected $_name='game';
	public function getGames(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name);
	return $select;
	}
	public function getGamesofContest($contest_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from(array('g'=>$this->_name))
			->where('g.contest_id = ?',$contest_id)
			->order('g.id ASC')
			->join(array('s'=>'score'), 's.game_id=g.id')
			->join(array('u'=>'users'), 'u.id=s.user_id');
	return $select;
	}
	public function insertGame($data){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->insert($this->_name,$data);
	}
	public function deleteGame($game_id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($this->_name, 'id = '.$game_id);
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
	public function getReferee($id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select();
        $select->from(array('g'=>$this->_name), array('u.username','u.password'))
        		->where('g.id = ?',$id)
        		->join(array('u'=>'users'), 'u.id=g.operator_id','')
        		->limit(0, 0);
        return $result = $select->query()->fetch();
	}
}