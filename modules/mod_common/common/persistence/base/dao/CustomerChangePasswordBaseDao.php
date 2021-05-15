<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CustomerChangePasswordVo;
use common\persistence\base\mapping\CustomerChangePasswordMapping;

class CustomerChangePasswordBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeSelectOne ( CustomerChangePasswordMapping::class, 'selectByKey', $customerChangePasswordVo );
		return $result;
	}
	final public function selectAll(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeSelectList ( CustomerChangePasswordMapping::class, 'selectAll', $customerChangePasswordVo );
		return $result;
	}
	final public function selectByFilter(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeSelectList ( CustomerChangePasswordMapping::class, 'selectByFilter', $customerChangePasswordVo );
		return $result;
	}
	final public function countByFilter(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeCount ( CustomerChangePasswordMapping::class, 'countByFilter', $customerChangePasswordVo );
		return $result;
	}
	final public function insertDynamic(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeInsert ( CustomerChangePasswordMapping::class, 'insertDynamic', $customerChangePasswordVo );
		return $result;
	}
	final public function insertDynamicWithId(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeInsert ( CustomerChangePasswordMapping::class, 'insertDynamicWithId', $customerChangePasswordVo );
		return $result;
	}
	final public function updateDynamicByKey(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeUpdate ( CustomerChangePasswordMapping::class, 'updateDynamicByKey', $customerChangePasswordVo );
		return $result;
	}
	final public function deleteByKey(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		$result = $this->executeDelete ( CustomerChangePasswordMapping::class, 'deleteByKey', $customerChangePasswordVo );
		return $result;
	}
}

