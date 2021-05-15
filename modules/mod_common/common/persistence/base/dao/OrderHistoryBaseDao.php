<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\mapping\OrderHistoryMapping;

class OrderHistoryBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeSelectOne ( OrderHistoryMapping::class, 'selectByKey', $orderHistoryVo );
		return $result;
	}
	final public function selectAll(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeSelectList ( OrderHistoryMapping::class, 'selectAll', $orderHistoryVo );
		return $result;
	}
	final public function selectByFilter(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeSelectList ( OrderHistoryMapping::class, 'selectByFilter', $orderHistoryVo );
		return $result;
	}
	final public function countByFilter(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeCount ( OrderHistoryMapping::class, 'countByFilter', $orderHistoryVo );
		return $result;
	}
	final public function insertDynamic(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeInsert ( OrderHistoryMapping::class, 'insertDynamic', $orderHistoryVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeInsert ( OrderHistoryMapping::class, 'insertDynamicWithId', $orderHistoryVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeUpdate ( OrderHistoryMapping::class, 'updateDynamicByKey', $orderHistoryVo );
		return $result;
	}
	final public function deleteByKey(OrderHistoryVo $orderHistoryVo = null) {
		$result = $this->executeDelete ( OrderHistoryMapping::class, 'deleteByKey', $orderHistoryVo );
		return $result;
	}
}

