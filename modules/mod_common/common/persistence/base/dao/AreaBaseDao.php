<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AreaVo;
use common\persistence\base\mapping\AreaMapping;

class AreaBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AreaVo $areaVo = null) {
		$result = $this->executeSelectOne ( AreaMapping::class, 'selectByKey', $areaVo );
		return $result;
	}
	final public function selectAll(AreaVo $areaVo = null) {
		$result = $this->executeSelectList ( AreaMapping::class, 'selectAll', $areaVo );
		return $result;
	}
	final public function selectByFilter(AreaVo $areaVo = null) {
		$result = $this->executeSelectList ( AreaMapping::class, 'selectByFilter', $areaVo );
		return $result;
	}
	final public function countByFilter(AreaVo $areaVo = null) {
		$result = $this->executeCount ( AreaMapping::class, 'countByFilter', $areaVo );
		return $result;
	}
	final public function insertDynamic(AreaVo $areaVo = null) {
		$result = $this->executeInsert ( AreaMapping::class, 'insertDynamic', $areaVo );
		return $result;
	}
	final public function insertDynamicWithId(AreaVo $areaVo = null) {
		$result = $this->executeInsert ( AreaMapping::class, 'insertDynamicWithId', $areaVo );
		return $result;
	}
	final public function updateDynamicByKey(AreaVo $areaVo = null) {
		$result = $this->executeUpdate ( AreaMapping::class, 'updateDynamicByKey', $areaVo );
		return $result;
	}
	final public function deleteByKey(AreaVo $areaVo = null) {
		$result = $this->executeDelete ( AreaMapping::class, 'deleteByKey', $areaVo );
		return $result;
	}
}

