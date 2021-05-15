<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ShippingMethodSettingVo;
use common\persistence\base\mapping\ShippingMethodSettingMapping;

class ShippingMethodSettingBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeSelectOne ( ShippingMethodSettingMapping::class, 'selectByKey', $shippingMethodSettingVo );
		return $result;
	}
	final public function selectAll(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeSelectList ( ShippingMethodSettingMapping::class, 'selectAll', $shippingMethodSettingVo );
		return $result;
	}
	final public function selectByFilter(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeSelectList ( ShippingMethodSettingMapping::class, 'selectByFilter', $shippingMethodSettingVo );
		return $result;
	}
	final public function countByFilter(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeCount ( ShippingMethodSettingMapping::class, 'countByFilter', $shippingMethodSettingVo );
		return $result;
	}
	final public function insertDynamic(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeInsert ( ShippingMethodSettingMapping::class, 'insertDynamic', $shippingMethodSettingVo );
		return $result;
	}
	final public function updateDynamicByKey(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeUpdate ( ShippingMethodSettingMapping::class, 'updateDynamicByKey', $shippingMethodSettingVo );
		return $result;
	}
	final public function deleteByKey(ShippingMethodSettingVo $shippingMethodSettingVo = null) {
		$result = $this->executeDelete ( ShippingMethodSettingMapping::class, 'deleteByKey', $shippingMethodSettingVo );
		return $result;
	}
}

