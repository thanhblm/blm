<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\UserGroupPermissionVo;
use common\persistence\base\mapping\UserGroupPermissionMapping;

class UserGroupPermissionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeSelectOne ( UserGroupPermissionMapping::class, 'selectByKey', $userGroupPermissionVo );
		return $result;
	}
	final public function selectAll(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeSelectList ( UserGroupPermissionMapping::class, 'selectAll', $userGroupPermissionVo );
		return $result;
	}
	final public function selectByFilter(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeSelectList ( UserGroupPermissionMapping::class, 'selectByFilter', $userGroupPermissionVo );
		return $result;
	}
	final public function countByFilter(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeCount ( UserGroupPermissionMapping::class, 'countByFilter', $userGroupPermissionVo );
		return $result;
	}
	final public function insertDynamic(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeInsert ( UserGroupPermissionMapping::class, 'insertDynamic', $userGroupPermissionVo );
		return $result;
	}
	final public function insertDynamicWithId(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeInsert ( UserGroupPermissionMapping::class, 'insertDynamicWithId', $userGroupPermissionVo );
		return $result;
	}
	final public function updateDynamicByKey(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeUpdate ( UserGroupPermissionMapping::class, 'updateDynamicByKey', $userGroupPermissionVo );
		return $result;
	}
	final public function deleteByKey(UserGroupPermissionVo $userGroupPermissionVo = null) {
		$result = $this->executeDelete ( UserGroupPermissionMapping::class, 'deleteByKey', $userGroupPermissionVo );
		return $result;
	}
}

