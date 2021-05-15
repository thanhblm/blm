<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\mapping\OrderChargeInfoMapping;

class OrderChargeInfoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeSelectOne ( OrderChargeInfoMapping::class, 'selectByKey', $orderChargeInfoVo );
		return $result;
	}
	final public function selectAll(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeSelectList ( OrderChargeInfoMapping::class, 'selectAll', $orderChargeInfoVo );
		return $result;
	}
	final public function selectByFilter(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeSelectList ( OrderChargeInfoMapping::class, 'selectByFilter', $orderChargeInfoVo );
		return $result;
	}
	final public function countByFilter(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeCount ( OrderChargeInfoMapping::class, 'countByFilter', $orderChargeInfoVo );
		return $result;
	}
	final public function insertDynamic(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeInsert ( OrderChargeInfoMapping::class, 'insertDynamic', $orderChargeInfoVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeInsert ( OrderChargeInfoMapping::class, 'insertDynamicWithId', $orderChargeInfoVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeUpdate ( OrderChargeInfoMapping::class, 'updateDynamicByKey', $orderChargeInfoVo );
		return $result;
	}
	final public function deleteByKey(OrderChargeInfoVo $orderChargeInfoVo = null) {
		$result = $this->executeDelete ( OrderChargeInfoMapping::class, 'deleteByKey', $orderChargeInfoVo );
		return $result;
	}
}

