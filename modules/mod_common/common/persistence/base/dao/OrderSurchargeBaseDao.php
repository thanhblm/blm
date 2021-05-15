<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderSurchargeVo;
use common\persistence\base\mapping\OrderSurchargeMapping;

class OrderSurchargeBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeSelectOne ( OrderSurchargeMapping::class, 'selectByKey', $orderSurchargeVo );
		return $result;
	}
	final public function selectAll(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeSelectList ( OrderSurchargeMapping::class, 'selectAll', $orderSurchargeVo );
		return $result;
	}
	final public function selectByFilter(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeSelectList ( OrderSurchargeMapping::class, 'selectByFilter', $orderSurchargeVo );
		return $result;
	}
	final public function countByFilter(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeCount ( OrderSurchargeMapping::class, 'countByFilter', $orderSurchargeVo );
		return $result;
	}
	final public function insertDynamic(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeInsert ( OrderSurchargeMapping::class, 'insertDynamic', $orderSurchargeVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeInsert ( OrderSurchargeMapping::class, 'insertDynamicWithId', $orderSurchargeVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeUpdate ( OrderSurchargeMapping::class, 'updateDynamicByKey', $orderSurchargeVo );
		return $result;
	}
	final public function deleteByKey(OrderSurchargeVo $orderSurchargeVo = null) {
		$result = $this->executeDelete ( OrderSurchargeMapping::class, 'deleteByKey', $orderSurchargeVo );
		return $result;
	}
}

