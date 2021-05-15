<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ShippingStatusVo;
use common\persistence\base\mapping\ShippingStatusMapping;

class ShippingStatusBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeSelectOne ( ShippingStatusMapping::class, 'selectByKey', $shippingStatusVo );
		return $result;
	}
	final public function selectAll(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeSelectList ( ShippingStatusMapping::class, 'selectAll', $shippingStatusVo );
		return $result;
	}
	final public function selectByFilter(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeSelectList ( ShippingStatusMapping::class, 'selectByFilter', $shippingStatusVo );
		return $result;
	}
	final public function countByFilter(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeCount ( ShippingStatusMapping::class, 'countByFilter', $shippingStatusVo );
		return $result;
	}
	final public function insertDynamic(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeInsert ( ShippingStatusMapping::class, 'insertDynamic', $shippingStatusVo );
		return $result;
	}
	final public function insertDynamicWithId(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeInsert ( ShippingStatusMapping::class, 'insertDynamicWithId', $shippingStatusVo );
		return $result;
	}
	final public function updateDynamicByKey(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeUpdate ( ShippingStatusMapping::class, 'updateDynamicByKey', $shippingStatusVo );
		return $result;
	}
	final public function deleteByKey(ShippingStatusVo $shippingStatusVo = null) {
		$result = $this->executeDelete ( ShippingStatusMapping::class, 'deleteByKey', $shippingStatusVo );
		return $result;
	}
}

