<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BackendMenuVo;
use common\persistence\base\mapping\BackendMenuMapping;

class BackendMenuBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeSelectOne ( BackendMenuMapping::class, 'selectByKey', $backendMenuVo );
		return $result;
	}
	final public function selectAll(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeSelectList ( BackendMenuMapping::class, 'selectAll', $backendMenuVo );
		return $result;
	}
	final public function selectByFilter(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeSelectList ( BackendMenuMapping::class, 'selectByFilter', $backendMenuVo );
		return $result;
	}
	final public function countByFilter(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeCount ( BackendMenuMapping::class, 'countByFilter', $backendMenuVo );
		return $result;
	}
	final public function insertDynamic(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeInsert ( BackendMenuMapping::class, 'insertDynamic', $backendMenuVo );
		return $result;
	}
	final public function updateDynamicByKey(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeUpdate ( BackendMenuMapping::class, 'updateDynamicByKey', $backendMenuVo );
		return $result;
	}
	final public function deleteByKey(BackendMenuVo $backendMenuVo = null) {
		$result = $this->executeDelete ( BackendMenuMapping::class, 'deleteByKey', $backendMenuVo );
		return $result;
	}
}

