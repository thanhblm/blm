<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\mapping\ContainerMapping;

class ContainerBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ContainerVo $containerVo = null) {
		$result = $this->executeSelectOne ( ContainerMapping::class, 'selectByKey', $containerVo );
		return $result;
	}
	final public function selectAll(ContainerVo $containerVo = null) {
		$result = $this->executeSelectList ( ContainerMapping::class, 'selectAll', $containerVo );
		return $result;
	}
	final public function selectByFilter(ContainerVo $containerVo = null) {
		$result = $this->executeSelectList ( ContainerMapping::class, 'selectByFilter', $containerVo );
		return $result;
	}
	final public function countByFilter(ContainerVo $containerVo = null) {
		$result = $this->executeCount ( ContainerMapping::class, 'countByFilter', $containerVo );
		return $result;
	}
	final public function insertDynamic(ContainerVo $containerVo = null) {
		$result = $this->executeInsert ( ContainerMapping::class, 'insertDynamic', $containerVo );
		return $result;
	}
	final public function insertDynamicWithId(ContainerVo $containerVo = null) {
		$result = $this->executeInsert ( ContainerMapping::class, 'insertDynamicWithId', $containerVo );
		return $result;
	}
	final public function updateDynamicByKey(ContainerVo $containerVo = null) {
		$result = $this->executeUpdate ( ContainerMapping::class, 'updateDynamicByKey', $containerVo );
		return $result;
	}
	final public function deleteByKey(ContainerVo $containerVo = null) {
		$result = $this->executeDelete ( ContainerMapping::class, 'deleteByKey', $containerVo );
		return $result;
	}
}

