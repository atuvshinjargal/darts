<?php
class Admin_Model_contest{
	protected $_name='contest';
	public function getcontests(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->order('finisdate DESC')
			->order('startdate ASC');
	return $select;
	}
	public function getContest($contest_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->where('id = ? ',$contest_id);
	return $select->query()->fetch();
	}
	public function getContestTime($contest_id){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->where('startdate <= NOW() AND id = ? ',$contest_id);
	return $select->query()->fetch();
	}
	public function getLiveContests(){
	$db = Zend_Db_Table::getDefaultAdapter();
	$select = new Zend_Db_Select($db);
	$select->from($this->_name)
			->where('startdate <= NOW() AND finisdate=\'3000-00-00\'');
	return $select->query()->fetchAll();
	}
	public function insertContest($data){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->insert($this->_name,$data);
	}
	public function updateContest($data,$where){
	$db = Zend_Db_Table::getDefaultAdapter();
	 $db->update($this->_name, $data,$where);
	}
	public function deleteContest($user_id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($this->_name, 'id = '.$user_id);
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
}