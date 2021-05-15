<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderRefundVo;
use common\persistence\base\mapping\OrderRefundMapping;

class OrderRefundBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeSelectOne ( OrderRefundMapping::class, 'selectByKey', $orderRefundVo );
		return $result;
	}
	final public function selectAll(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeSelectList ( OrderRefundMapping::class, 'selectAll', $orderRefundVo );
		return $result;
	}
	final public function selectByFilter(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeSelectList ( OrderRefundMapping::class, 'selectByFilter', $orderRefundVo );
		return $result;
	}
	final public function countByFilter(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeCount ( OrderRefundMapping::class, 'countByFilter', $orderRefundVo );
		return $result;
	}
	final public function insertDynamic(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeInsert ( OrderRefundMapping::class, 'insertDynamic', $orderRefundVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeInsert ( OrderRefundMapping::class, 'insertDynamicWithId', $orderRefundVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeUpdate ( OrderRefundMapping::class, 'updateDynamicByKey', $orderRefundVo );
		return $result;
	}
	final public function deleteByKey(OrderRefundVo $orderRefundVo = null) {
		$result = $this->executeDelete ( OrderRefundMapping::class, 'deleteByKey', $orderRefundVo );
		return $result;
	}
}

