<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\RegionCountryVo;
use common\persistence\base\mapping\RegionCountryMapping;

class RegionCountryBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeSelectOne ( RegionCountryMapping::class, 'selectByKey', $regionCountryVo );
		return $result;
	}
	final public function selectAll(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeSelectList ( RegionCountryMapping::class, 'selectAll', $regionCountryVo );
		return $result;
	}
	final public function selectByFilter(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeSelectList ( RegionCountryMapping::class, 'selectByFilter', $regionCountryVo );
		return $result;
	}
	final public function countByFilter(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeCount ( RegionCountryMapping::class, 'countByFilter', $regionCountryVo );
		return $result;
	}
	final public function insertDynamic(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeInsert ( RegionCountryMapping::class, 'insertDynamic', $regionCountryVo );
		return $result;
	}
	final public function insertDynamicWithId(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeInsert ( RegionCountryMapping::class, 'insertDynamicWithId', $regionCountryVo );
		return $result;
	}
	final public function updateDynamicByKey(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeUpdate ( RegionCountryMapping::class, 'updateDynamicByKey', $regionCountryVo );
		return $result;
	}
	final public function deleteByKey(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeDelete ( RegionCountryMapping::class, 'deleteByKey', $regionCountryVo );
		return $result;
	}
}

