<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\mapping\RegionShippingMethodMapping;

class RegionShippingMethodBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeSelectOne ( RegionShippingMethodMapping::class, 'selectByKey', $regionShippingMethodVo );
		return $result;
	}
	final public function selectAll(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeSelectList ( RegionShippingMethodMapping::class, 'selectAll', $regionShippingMethodVo );
		return $result;
	}
	final public function selectByFilter(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeSelectList ( RegionShippingMethodMapping::class, 'selectByFilter', $regionShippingMethodVo );
		return $result;
	}
	final public function countByFilter(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeCount ( RegionShippingMethodMapping::class, 'countByFilter', $regionShippingMethodVo );
		return $result;
	}
	final public function insertDynamic(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeInsert ( RegionShippingMethodMapping::class, 'insertDynamic', $regionShippingMethodVo );
		return $result;
	}
	final public function insertDynamicWithId(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeInsert ( RegionShippingMethodMapping::class, 'insertDynamicWithId', $regionShippingMethodVo );
		return $result;
	}
	final public function updateDynamicByKey(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeUpdate ( RegionShippingMethodMapping::class, 'updateDynamicByKey', $regionShippingMethodVo );
		return $result;
	}
	final public function deleteByKey(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeDelete ( RegionShippingMethodMapping::class, 'deleteByKey', $regionShippingMethodVo );
		return $result;
	}
}

