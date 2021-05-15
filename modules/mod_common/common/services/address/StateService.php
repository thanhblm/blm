<?php

namespace common\services\address;

use common\services\base\BaseService;
use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\vo\StateVo;

class StateService extends BaseService{
	private $dao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->dao = new StateBaseDao($this->context);
	}
	public function selectByKey(StateVo $vo) {
		return $this->dao->selectByKey ( $vo );
	}
	public function selectByFilter(StateVo $vo){
		return $this->dao->selectByFilter( $vo );
	}
	public function countByFilter(StateVo $vo){
		return $this->dao->countByFilter( $vo );
	}
	public function createState(StateVo $vo){
		return $this->dao->insertDynamic($vo);
	}
	public function updateState(StateVo $vo){
		return $this->dao->updateDynamicByKey($vo);
	}
	public function deleteState(StateVo $vo){
		return $this->dao->deleteByKey($vo);
	}
	public function selectAll(){
		return $this->dao->selectAll();
	}
}