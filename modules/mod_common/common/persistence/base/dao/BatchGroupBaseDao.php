<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BatchGroupVo;
use common\persistence\base\mapping\BatchGroupMapping;

class BatchGroupBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeSelectOne ( BatchGroupMapping::class, 'selectByKey', $batchGroupVo );
		return $result;
	}
	final public function selectAll(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeSelectList ( BatchGroupMapping::class, 'selectAll', $batchGroupVo );
		return $result;
	}
	final public function selectByFilter(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeSelectList ( BatchGroupMapping::class, 'selectByFilter', $batchGroupVo );
		return $result;
	}
	final public function countByFilter(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeCount ( BatchGroupMapping::class, 'countByFilter', $batchGroupVo );
		return $result;
	}
	final public function insertDynamic(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeInsert ( BatchGroupMapping::class, 'insertDynamic', $batchGroupVo );
		return $result;
	}
	final public function insertDynamicWithId(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeInsert ( BatchGroupMapping::class, 'insertDynamicWithId', $batchGroupVo );
		return $result;
	}
	final public function updateDynamicByKey(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeUpdate ( BatchGroupMapping::class, 'updateDynamicByKey', $batchGroupVo );
		return $result;
	}
	final public function deleteByKey(BatchGroupVo $batchGroupVo = null) {
		$result = $this->executeDelete ( BatchGroupMapping::class, 'deleteByKey', $batchGroupVo );
		return $result;
	}
}

