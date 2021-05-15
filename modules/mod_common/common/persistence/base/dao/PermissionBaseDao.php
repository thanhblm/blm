<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PermissionVo;
use common\persistence\base\mapping\PermissionMapping;

class PermissionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PermissionVo $permissionVo = null) {
		$result = $this->executeSelectOne ( PermissionMapping::class, 'selectByKey', $permissionVo );
		return $result;
	}
	final public function selectAll(PermissionVo $permissionVo = null) {
		$result = $this->executeSelectList ( PermissionMapping::class, 'selectAll', $permissionVo );
		return $result;
	}
	final public function selectByFilter(PermissionVo $permissionVo = null) {
		$result = $this->executeSelectList ( PermissionMapping::class, 'selectByFilter', $permissionVo );
		return $result;
	}
	final public function countByFilter(PermissionVo $permissionVo = null) {
		$result = $this->executeCount ( PermissionMapping::class, 'countByFilter', $permissionVo );
		return $result;
	}
	final public function insertDynamic(PermissionVo $permissionVo = null) {
		$result = $this->executeInsert ( PermissionMapping::class, 'insertDynamic', $permissionVo );
		return $result;
	}
	final public function insertDynamicWithId(PermissionVo $permissionVo = null) {
		$result = $this->executeInsert ( PermissionMapping::class, 'insertDynamicWithId', $permissionVo );
		return $result;
	}
	final public function updateDynamicByKey(PermissionVo $permissionVo = null) {
		$result = $this->executeUpdate ( PermissionMapping::class, 'updateDynamicByKey', $permissionVo );
		return $result;
	}
	final public function deleteByKey(PermissionVo $permissionVo = null) {
		$result = $this->executeDelete ( PermissionMapping::class, 'deleteByKey', $permissionVo );
		return $result;
	}
}

