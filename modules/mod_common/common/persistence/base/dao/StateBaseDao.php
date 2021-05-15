<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\StateVo;
use common\persistence\base\mapping\StateMapping;

class StateBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(StateVo $stateVo = null) {
		$result = $this->executeSelectOne ( StateMapping::class, 'selectByKey', $stateVo );
		return $result;
	}
	final public function selectAll(StateVo $stateVo = null) {
		$result = $this->executeSelectList ( StateMapping::class, 'selectAll', $stateVo );
		return $result;
	}
	final public function selectByFilter(StateVo $stateVo = null) {
		$result = $this->executeSelectList ( StateMapping::class, 'selectByFilter', $stateVo );
		return $result;
	}
	final public function countByFilter(StateVo $stateVo = null) {
		$result = $this->executeCount ( StateMapping::class, 'countByFilter', $stateVo );
		return $result;
	}
	final public function insertDynamic(StateVo $stateVo = null) {
		$result = $this->executeInsert ( StateMapping::class, 'insertDynamic', $stateVo );
		return $result;
	}
	final public function insertDynamicWithId(StateVo $stateVo = null) {
		$result = $this->executeInsert ( StateMapping::class, 'insertDynamicWithId', $stateVo );
		return $result;
	}
	final public function updateDynamicByKey(StateVo $stateVo = null) {
		$result = $this->executeUpdate ( StateMapping::class, 'updateDynamicByKey', $stateVo );
		return $result;
	}
	final public function deleteByKey(StateVo $stateVo = null) {
		$result = $this->executeDelete ( StateMapping::class, 'deleteByKey', $stateVo );
		return $result;
	}
}

