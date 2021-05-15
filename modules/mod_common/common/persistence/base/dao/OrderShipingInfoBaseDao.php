<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\base\mapping\OrderShipingInfoMapping;

class OrderShipingInfoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeSelectOne ( OrderShipingInfoMapping::class, 'selectByKey', $orderShipingInfoVo );
		return $result;
	}
	final public function selectAll(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeSelectList ( OrderShipingInfoMapping::class, 'selectAll', $orderShipingInfoVo );
		return $result;
	}
	final public function selectByFilter(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeSelectList ( OrderShipingInfoMapping::class, 'selectByFilter', $orderShipingInfoVo );
		return $result;
	}
	final public function countByFilter(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeCount ( OrderShipingInfoMapping::class, 'countByFilter', $orderShipingInfoVo );
		return $result;
	}
	final public function insertDynamic(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeInsert ( OrderShipingInfoMapping::class, 'insertDynamic', $orderShipingInfoVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeInsert ( OrderShipingInfoMapping::class, 'insertDynamicWithId', $orderShipingInfoVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeUpdate ( OrderShipingInfoMapping::class, 'updateDynamicByKey', $orderShipingInfoVo );
		return $result;
	}
	final public function deleteByKey(OrderShipingInfoVo $orderShipingInfoVo = null) {
		$result = $this->executeDelete ( OrderShipingInfoMapping::class, 'deleteByKey', $orderShipingInfoVo );
		return $result;
	}
}

