<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\TaxShippingZoneVo;
use common\persistence\base\mapping\TaxShippingZoneMapping;

class TaxShippingZoneBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeSelectOne ( TaxShippingZoneMapping::class, 'selectByKey', $taxShippingZoneVo );
		return $result;
	}
	final public function selectAll(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeSelectList ( TaxShippingZoneMapping::class, 'selectAll', $taxShippingZoneVo );
		return $result;
	}
	final public function selectByFilter(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeSelectList ( TaxShippingZoneMapping::class, 'selectByFilter', $taxShippingZoneVo );
		return $result;
	}
	final public function countByFilter(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeCount ( TaxShippingZoneMapping::class, 'countByFilter', $taxShippingZoneVo );
		return $result;
	}
	final public function insertDynamic(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeInsert ( TaxShippingZoneMapping::class, 'insertDynamic', $taxShippingZoneVo );
		return $result;
	}
	final public function insertDynamicWithId(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeInsert ( TaxShippingZoneMapping::class, 'insertDynamicWithId', $taxShippingZoneVo );
		return $result;
	}
	final public function updateDynamicByKey(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeUpdate ( TaxShippingZoneMapping::class, 'updateDynamicByKey', $taxShippingZoneVo );
		return $result;
	}
	final public function deleteByKey(TaxShippingZoneVo $taxShippingZoneVo = null) {
		$result = $this->executeDelete ( TaxShippingZoneMapping::class, 'deleteByKey', $taxShippingZoneVo );
		return $result;
	}
}

