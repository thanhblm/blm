<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BatchVo;
use common\persistence\base\mapping\BatchMapping;

class BatchBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BatchVo $batchVo = null) {
		$result = $this->executeSelectOne ( BatchMapping::class, 'selectByKey', $batchVo );
		return $result;
	}
	final public function selectAll(BatchVo $batchVo = null) {
		$result = $this->executeSelectList ( BatchMapping::class, 'selectAll', $batchVo );
		return $result;
	}
	final public function selectByFilter(BatchVo $batchVo = null) {
		$result = $this->executeSelectList ( BatchMapping::class, 'selectByFilter', $batchVo );
		return $result;
	}
	final public function countByFilter(BatchVo $batchVo = null) {
		$result = $this->executeCount ( BatchMapping::class, 'countByFilter', $batchVo );
		return $result;
	}
	final public function insertDynamic(BatchVo $batchVo = null) {
		$result = $this->executeInsert ( BatchMapping::class, 'insertDynamic', $batchVo );
		return $result;
	}
	final public function insertDynamicWithId(BatchVo $batchVo = null) {
		$result = $this->executeInsert ( BatchMapping::class, 'insertDynamicWithId', $batchVo );
		return $result;
	}
	final public function updateDynamicByKey(BatchVo $batchVo = null) {
		$result = $this->executeUpdate ( BatchMapping::class, 'updateDynamicByKey', $batchVo );
		return $result;
	}
	final public function deleteByKey(BatchVo $batchVo = null) {
		$result = $this->executeDelete ( BatchMapping::class, 'deleteByKey', $batchVo );
		return $result;
	}
}

