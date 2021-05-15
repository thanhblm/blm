<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\mapping\OrderTotalMapping;

class OrderTotalBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeSelectOne ( OrderTotalMapping::class, 'selectByKey', $orderTotalVo );
		return $result;
	}
	final public function selectAll(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeSelectList ( OrderTotalMapping::class, 'selectAll', $orderTotalVo );
		return $result;
	}
	final public function selectByFilter(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeSelectList ( OrderTotalMapping::class, 'selectByFilter', $orderTotalVo );
		return $result;
	}
	final public function countByFilter(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeCount ( OrderTotalMapping::class, 'countByFilter', $orderTotalVo );
		return $result;
	}
	final public function insertDynamic(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeInsert ( OrderTotalMapping::class, 'insertDynamic', $orderTotalVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeInsert ( OrderTotalMapping::class, 'insertDynamicWithId', $orderTotalVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeUpdate ( OrderTotalMapping::class, 'updateDynamicByKey', $orderTotalVo );
		return $result;
	}
	final public function deleteByKey(OrderTotalVo $orderTotalVo = null) {
		$result = $this->executeDelete ( OrderTotalMapping::class, 'deleteByKey', $orderTotalVo );
		return $result;
	}
}

