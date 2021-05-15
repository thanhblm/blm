<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\mapping\OrderMapping;

class OrderBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderVo $orderVo = null) {
		$result = $this->executeSelectOne ( OrderMapping::class, 'selectByKey', $orderVo );
		return $result;
	}
	final public function selectAll(OrderVo $orderVo = null) {
		$result = $this->executeSelectList ( OrderMapping::class, 'selectAll', $orderVo );
		return $result;
	}
	final public function selectByFilter(OrderVo $orderVo = null) {
		$result = $this->executeSelectList ( OrderMapping::class, 'selectByFilter', $orderVo );
		return $result;
	}
	final public function countByFilter(OrderVo $orderVo = null) {
		$result = $this->executeCount ( OrderMapping::class, 'countByFilter', $orderVo );
		return $result;
	}
	final public function insertDynamic(OrderVo $orderVo = null) {
		$result = $this->executeInsert ( OrderMapping::class, 'insertDynamic', $orderVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderVo $orderVo = null) {
		$result = $this->executeInsert ( OrderMapping::class, 'insertDynamicWithId', $orderVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderVo $orderVo = null) {
		$result = $this->executeUpdate ( OrderMapping::class, 'updateDynamicByKey', $orderVo );
		return $result;
	}
	final public function deleteByKey(OrderVo $orderVo = null) {
		$result = $this->executeDelete ( OrderMapping::class, 'deleteByKey', $orderVo );
		return $result;
	}
}

