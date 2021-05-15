<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\mapping\OrderProductMapping;

class OrderProductBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(OrderProductVo $orderProductVo = null) {
		$result = $this->executeSelectOne ( OrderProductMapping::class, 'selectByKey', $orderProductVo );
		return $result;
	}
	final public function selectAll(OrderProductVo $orderProductVo = null) {
		$result = $this->executeSelectList ( OrderProductMapping::class, 'selectAll', $orderProductVo );
		return $result;
	}
	final public function selectByFilter(OrderProductVo $orderProductVo = null) {
		$result = $this->executeSelectList ( OrderProductMapping::class, 'selectByFilter', $orderProductVo );
		return $result;
	}
	final public function countByFilter(OrderProductVo $orderProductVo = null) {
		$result = $this->executeCount ( OrderProductMapping::class, 'countByFilter', $orderProductVo );
		return $result;
	}
	final public function insertDynamic(OrderProductVo $orderProductVo = null) {
		$result = $this->executeInsert ( OrderProductMapping::class, 'insertDynamic', $orderProductVo );
		return $result;
	}
	final public function insertDynamicWithId(OrderProductVo $orderProductVo = null) {
		$result = $this->executeInsert ( OrderProductMapping::class, 'insertDynamicWithId', $orderProductVo );
		return $result;
	}
	final public function updateDynamicByKey(OrderProductVo $orderProductVo = null) {
		$result = $this->executeUpdate ( OrderProductMapping::class, 'updateDynamicByKey', $orderProductVo );
		return $result;
	}
	final public function deleteByKey(OrderProductVo $orderProductVo = null) {
		$result = $this->executeDelete ( OrderProductMapping::class, 'deleteByKey', $orderProductVo );
		return $result;
	}
}

