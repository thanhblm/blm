<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\TaxShippingZoneInfoVo;
use common\persistence\base\mapping\TaxShippingZoneInfoMapping;

class TaxShippingZoneInfoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeSelectOne ( TaxShippingZoneInfoMapping::class, 'selectByKey', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function selectAll(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeSelectList ( TaxShippingZoneInfoMapping::class, 'selectAll', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function selectByFilter(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeSelectList ( TaxShippingZoneInfoMapping::class, 'selectByFilter', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function countByFilter(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeCount ( TaxShippingZoneInfoMapping::class, 'countByFilter', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function insertDynamic(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeInsert ( TaxShippingZoneInfoMapping::class, 'insertDynamic', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function insertDynamicWithId(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeInsert ( TaxShippingZoneInfoMapping::class, 'insertDynamicWithId', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function updateDynamicByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeUpdate ( TaxShippingZoneInfoMapping::class, 'updateDynamicByKey', $taxShippingZoneInfoVo );
		return $result;
	}
	final public function deleteByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		$result = $this->executeDelete ( TaxShippingZoneInfoMapping::class, 'deleteByKey', $taxShippingZoneInfoVo );
		return $result;
	}
}

