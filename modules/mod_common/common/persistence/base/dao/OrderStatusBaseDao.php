<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderStatusVo;
use common\persistence\base\mapping\OrderStatusMapping;

class OrderStatusBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeSelectOne ( OrderStatusMapping::class, 'selectByKey', $orderStatusVo );
		return $result;
	}
	final public function selectAll(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeSelectList ( OrderStatusMapping::class, 'selectAll', $orderStatusVo );
		return $result;
	}
	final public function selectByFilter(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeSelectList ( OrderStatusMapping::class, 'selectByFilter', $orderStatusVo );
		return $result;
	}
	final public function countByFilter(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeCount ( OrderStatusMapping::class, 'countByFilter', $orderStatusVo );
		return $result;
	}
	final public function insertDynamic(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeInsert ( OrderStatusMapping::class, 'insertDynamic', $orderStatusVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeInsert ( OrderStatusMapping::class, 'insertDynamicWithId', $orderStatusVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeUpdate ( OrderStatusMapping::class, 'updateDynamicByKey', $orderStatusVo );
		return $result;
	}
	final public function deleteByKey(OrderStatusVo $orderStatusVo = null) {
		$result = $this->executeDelete ( OrderStatusMapping::class, 'deleteByKey', $orderStatusVo );
		return $result;
	}
}

