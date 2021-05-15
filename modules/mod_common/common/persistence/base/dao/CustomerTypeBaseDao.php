<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CustomerTypeVo;
use common\persistence\base\mapping\CustomerTypeMapping;

class CustomerTypeBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeSelectOne ( CustomerTypeMapping::class, 'selectByKey', $customerTypeVo );
		return $result;
	}
	final public function selectAll(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeSelectList ( CustomerTypeMapping::class, 'selectAll', $customerTypeVo );
		return $result;
	}
	final public function selectByFilter(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeSelectList ( CustomerTypeMapping::class, 'selectByFilter', $customerTypeVo );
		return $result;
	}
	final public function countByFilter(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeCount ( CustomerTypeMapping::class, 'countByFilter', $customerTypeVo );
		return $result;
	}
	final public function insertDynamic(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeInsert ( CustomerTypeMapping::class, 'insertDynamic', $customerTypeVo );
		return $result;
	}
	final public function insertDynamicWithId(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeInsert ( CustomerTypeMapping::class, 'insertDynamicWithId', $customerTypeVo );
		return $result;
	}
	final public function updateDynamicByKey(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeUpdate ( CustomerTypeMapping::class, 'updateDynamicByKey', $customerTypeVo );
		return $result;
	}
	final public function deleteByKey(CustomerTypeVo $customerTypeVo = null) {
		$result = $this->executeDelete ( CustomerTypeMapping::class, 'deleteByKey', $customerTypeVo );
		return $result;
	}
}

