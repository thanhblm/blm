<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ServiceVo;
use common\persistence\base\mapping\ServiceMapping;

class ServiceBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ServiceVo $serviceVo = null) {
		$result = $this->executeSelectOne ( ServiceMapping::class, 'selectByKey', $serviceVo );
		return $result;
	}
	final public function selectAll(ServiceVo $serviceVo = null) {
		$result = $this->executeSelectList ( ServiceMapping::class, 'selectAll', $serviceVo );
		return $result;
	}
	final public function selectByFilter(ServiceVo $serviceVo = null) {
		$result = $this->executeSelectList ( ServiceMapping::class, 'selectByFilter', $serviceVo );
		return $result;
	}
	final public function countByFilter(ServiceVo $serviceVo = null) {
		$result = $this->executeCount ( ServiceMapping::class, 'countByFilter', $serviceVo );
		return $result;
	}
	final public function insertDynamic(ServiceVo $serviceVo = null) {
		$result = $this->executeInsert ( ServiceMapping::class, 'insertDynamic', $serviceVo );
		return $result;
	}
	final public function insertDynamicWithId(ServiceVo $serviceVo = null) {
		$result = $this->executeInsert ( ServiceMapping::class, 'insertDynamicWithId', $serviceVo );
		return $result;
	}
	final public function updateDynamicByKey(ServiceVo $serviceVo = null) {
		$result = $this->executeUpdate ( ServiceMapping::class, 'updateDynamicByKey', $serviceVo );
		return $result;
	}
	final public function deleteByKey(ServiceVo $serviceVo = null) {
		$result = $this->executeDelete ( ServiceMapping::class, 'deleteByKey', $serviceVo );
		return $result;
	}
}

