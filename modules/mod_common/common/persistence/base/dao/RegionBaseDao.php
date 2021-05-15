<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\mapping\RegionMapping;

class RegionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(RegionVo $regionVo = null) {
		$result = $this->executeSelectOne ( RegionMapping::class, 'selectByKey', $regionVo );
		return $result;
	}
	final public function selectAll(RegionVo $regionVo = null) {
		$result = $this->executeSelectList ( RegionMapping::class, 'selectAll', $regionVo );
		return $result;
	}
	final public function selectByFilter(RegionVo $regionVo = null) {
		$result = $this->executeSelectList ( RegionMapping::class, 'selectByFilter', $regionVo );
		return $result;
	}
	final public function countByFilter(RegionVo $regionVo = null) {
		$result = $this->executeCount ( RegionMapping::class, 'countByFilter', $regionVo );
		return $result;
	}
	final public function insertDynamic(RegionVo $regionVo = null) {
		$result = $this->executeInsert ( RegionMapping::class, 'insertDynamic', $regionVo );
		return $result;
	}
	final public function insertDynamicWithId(RegionVo $regionVo = null) {
		$result = $this->executeInsert ( RegionMapping::class, 'insertDynamicWithId', $regionVo );
		return $result;
	}
	final public function updateDynamicByKey(RegionVo $regionVo = null) {
		$result = $this->executeUpdate ( RegionMapping::class, 'updateDynamicByKey', $regionVo );
		return $result;
	}
	final public function deleteByKey(RegionVo $regionVo = null) {
		$result = $this->executeDelete ( RegionMapping::class, 'deleteByKey', $regionVo );
		return $result;
	}
}

