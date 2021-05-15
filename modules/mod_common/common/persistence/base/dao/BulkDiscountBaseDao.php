<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\base\mapping\BulkDiscountMapping;

class BulkDiscountBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeSelectOne ( BulkDiscountMapping::class, 'selectByKey', $bulkDiscountVo );
		return $result;
	}
	final public function selectAll(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeSelectList ( BulkDiscountMapping::class, 'selectAll', $bulkDiscountVo );
		return $result;
	}
	final public function selectByFilter(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeSelectList ( BulkDiscountMapping::class, 'selectByFilter', $bulkDiscountVo );
		return $result;
	}
	final public function countByFilter(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeCount ( BulkDiscountMapping::class, 'countByFilter', $bulkDiscountVo );
		return $result;
	}
	final public function insertDynamic(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeInsert ( BulkDiscountMapping::class, 'insertDynamic', $bulkDiscountVo );
		return $result;
	}
	final public function insertDynamicWithId(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeInsert ( BulkDiscountMapping::class, 'insertDynamicWithId', $bulkDiscountVo );
		return $result;
	}
	final public function updateDynamicByKey(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeUpdate ( BulkDiscountMapping::class, 'updateDynamicByKey', $bulkDiscountVo );
		return $result;
	}
	final public function deleteByKey(BulkDiscountVo $bulkDiscountVo = null) {
		$result = $this->executeDelete ( BulkDiscountMapping::class, 'deleteByKey', $bulkDiscountVo );
		return $result;
	}
}

