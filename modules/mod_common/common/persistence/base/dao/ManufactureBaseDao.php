<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ManufactureVo;
use common\persistence\base\mapping\ManufactureMapping;

class ManufactureBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ManufactureVo $manufactureVo = null) {
		$result = $this->executeSelectOne ( ManufactureMapping::class, 'selectByKey', $manufactureVo );
		return $result;
	}
	final public function selectAll(ManufactureVo $manufactureVo = null) {
		$result = $this->executeSelectList ( ManufactureMapping::class, 'selectAll', $manufactureVo );
		return $result;
	}
	final public function selectByFilter(ManufactureVo $manufactureVo = null) {
		$result = $this->executeSelectList ( ManufactureMapping::class, 'selectByFilter', $manufactureVo );
		return $result;
	}
	final public function countByFilter(ManufactureVo $manufactureVo = null) {
		$result = $this->executeCount ( ManufactureMapping::class, 'countByFilter', $manufactureVo );
		return $result;
	}
	final public function insertDynamic(ManufactureVo $manufactureVo = null) {
		$result = $this->executeInsert ( ManufactureMapping::class, 'insertDynamic', $manufactureVo );
		return $result;
	}
	final public function insertDynamicWithId(ManufactureVo $manufactureVo = null) {
		$result = $this->executeInsert ( ManufactureMapping::class, 'insertDynamicWithId', $manufactureVo );
		return $result;
	}
	final public function updateDynamicByKey(ManufactureVo $manufactureVo = null) {
		$result = $this->executeUpdate ( ManufactureMapping::class, 'updateDynamicByKey', $manufactureVo );
		return $result;
	}
	final public function deleteByKey(ManufactureVo $manufactureVo = null) {
		$result = $this->executeDelete ( ManufactureMapping::class, 'deleteByKey', $manufactureVo );
		return $result;
	}
}

