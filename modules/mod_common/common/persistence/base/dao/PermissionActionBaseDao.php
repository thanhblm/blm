<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PermissionActionVo;
use common\persistence\base\mapping\PermissionActionMapping;

class PermissionActionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeSelectOne ( PermissionActionMapping::class, 'selectByKey', $permissionActionVo );
		return $result;
	}
	final public function selectAll(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeSelectList ( PermissionActionMapping::class, 'selectAll', $permissionActionVo );
		return $result;
	}
	final public function selectByFilter(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeSelectList ( PermissionActionMapping::class, 'selectByFilter', $permissionActionVo );
		return $result;
	}
	final public function countByFilter(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeCount ( PermissionActionMapping::class, 'countByFilter', $permissionActionVo );
		return $result;
	}
	final public function insertDynamic(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeInsert ( PermissionActionMapping::class, 'insertDynamic', $permissionActionVo );
		return $result;
	}
	final public function insertDynamicWithId(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeInsert ( PermissionActionMapping::class, 'insertDynamicWithId', $permissionActionVo );
		return $result;
	}
	final public function updateDynamicByKey(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeUpdate ( PermissionActionMapping::class, 'updateDynamicByKey', $permissionActionVo );
		return $result;
	}
	final public function deleteByKey(PermissionActionVo $permissionActionVo = null) {
		$result = $this->executeDelete ( PermissionActionMapping::class, 'deleteByKey', $permissionActionVo );
		return $result;
	}
}

