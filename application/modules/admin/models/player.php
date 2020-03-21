<?php
class Admin_Model_player{
	protected $_name='players';
	public function getPlayers($contest_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->where('contest_id = ?',$contest_id);
	return $select;
	}
	public function getPlayersRate($contest_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from(array('p'=>$this->_name))
			->where('contest_id = ?',$contest_id)
			->join(array('u'=>'users'),'u.id=p.user_id')
			->order('win DESC')
			->order('lose ASC');
	return $select->query()->fetchAll();
	}
	public function getPlayersAllRate(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from(array('p'=>$this->_name),array('win'=>'SUM(win)','lose'=>'SUM(lose)'))
			->join(array('u'=>'users'),'u.id=p.user_id')
			->group('user_id')
			->order('win DESC')
			->order('lose ASC')
			->limit(5,0);
	return $select->query()->fetchAll();
	}
	public function insertPlayer($data){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->insert($this->_name,$data);
	}
	public function updatePlayer($data,$where){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->update($this->_name,$data,$where);
	}
	public function getPlayer($where){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->where($where);
	return $select->query()->fetch();
	}
	public function deletePlayer($user_id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($this->_name, 'user_id = '.$user_id);
	}
	public function deletePlayers($contest_id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($this->_name, 'contest_id = '.$contest_id);
	}
}