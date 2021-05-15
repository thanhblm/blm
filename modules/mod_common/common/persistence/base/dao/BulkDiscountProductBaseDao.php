<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BulkDiscountProductVo;
use common\persistence\base\mapping\BulkDiscountProductMapping;

class BulkDiscountProductBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeSelectOne ( BulkDiscountProductMapping::class, 'selectByKey', $bulkDiscountProductVo );
		return $result;
	}
	final public function selectAll(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeSelectList ( BulkDiscountProductMapping::class, 'selectAll', $bulkDiscountProductVo );
		return $result;
	}
	final public function selectByFilter(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeSelectList ( BulkDiscountProductMapping::class, 'selectByFilter', $bulkDiscountProductVo );
		return $result;
	}
	final public function countByFilter(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeCount ( BulkDiscountProductMapping::class, 'countByFilter', $bulkDiscountProductVo );
		return $result;
	}
	final public function insertDynamic(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeInsert ( BulkDiscountProductMapping::class, 'insertDynamic', $bulkDiscountProductVo );
		return $result;
	}
	final public function insertDynamicWithId(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeInsert ( BulkDiscountProductMapping::class, 'insertDynamicWithId', $bulkDiscountProductVo );
		return $result;
	}
	final public function updateDynamicByKey(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeUpdate ( BulkDiscountProductMapping::class, 'updateDynamicByKey', $bulkDiscountProductVo );
		return $result;
	}
	final public function deleteByKey(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		$result = $this->executeDelete ( BulkDiscountProductMapping::class, 'deleteByKey', $bulkDiscountProductVo );
		return $result;
	}
}

