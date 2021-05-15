<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\mapping\CustomerMapping;

class CustomerBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CustomerVo $customerVo = null) {
		$result = $this->executeSelectOne ( CustomerMapping::class, 'selectByKey', $customerVo );
		return $result;
	}
	final public function selectAll(CustomerVo $customerVo = null) {
		$result = $this->executeSelectList ( CustomerMapping::class, 'selectAll', $customerVo );
		return $result;
	}
	final public function selectByFilter(CustomerVo $customerVo = null) {
		$result = $this->executeSelectList ( CustomerMapping::class, 'selectByFilter', $customerVo );
		return $result;
	}
	final public function countByFilter(CustomerVo $customerVo = null) {
		$result = $this->executeCount ( CustomerMapping::class, 'countByFilter', $customerVo );
		return $result;
	}
	final public function insertDynamic(CustomerVo $customerVo = null) {
		$result = $this->executeInsert ( CustomerMapping::class, 'insertDynamic', $customerVo );
		return $result;
	}
	final public function insertDynamicWithId(CustomerVo $customerVo = null) {
		$result = $this->executeInsert ( CustomerMapping::class, 'insertDynamicWithId', $customerVo );
		return $result;
	}
	final public function updateDynamicByKey(CustomerVo $customerVo = null) {
		$result = $this->executeUpdate ( CustomerMapping::class, 'updateDynamicByKey', $customerVo );
		return $result;
	}
	final public function deleteByKey(CustomerVo $customerVo = null) {
		$result = $this->executeDelete ( CustomerMapping::class, 'deleteByKey', $customerVo );
		return $result;
	}
}

