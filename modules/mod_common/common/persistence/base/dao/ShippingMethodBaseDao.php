<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\base\mapping\ShippingMethodMapping;

class ShippingMethodBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeSelectOne ( ShippingMethodMapping::class, 'selectByKey', $shippingMethodVo );
		return $result;
	}
	final public function selectAll(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeSelectList ( ShippingMethodMapping::class, 'selectAll', $shippingMethodVo );
		return $result;
	}
	final public function selectByFilter(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeSelectList ( ShippingMethodMapping::class, 'selectByFilter', $shippingMethodVo );
		return $result;
	}
	final public function countByFilter(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeCount ( ShippingMethodMapping::class, 'countByFilter', $shippingMethodVo );
		return $result;
	}
	final public function insertDynamic(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeInsert ( ShippingMethodMapping::class, 'insertDynamic', $shippingMethodVo );
		return $result;
	}
	final public function insertDynamicWithId(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeInsert ( ShippingMethodMapping::class, 'insertDynamicWithId', $shippingMethodVo );
		return $result;
	}
	final public function updateDynamicByKey(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeUpdate ( ShippingMethodMapping::class, 'updateDynamicByKey', $shippingMethodVo );
		return $result;
	}
	final public function deleteByKey(ShippingMethodVo $shippingMethodVo = null) {
		$result = $this->executeDelete ( ShippingMethodMapping::class, 'deleteByKey', $shippingMethodVo );
		return $result;
	}
}

