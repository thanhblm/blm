<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\UserGroupVo;
use common\persistence\base\mapping\UserGroupMapping;

class UserGroupBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(UserGroupVo $userGroupVo = null) {
		$result = $this->executeSelectOne ( UserGroupMapping::class, 'selectByKey', $userGroupVo );
		return $result;
	}
	final public function selectAll(UserGroupVo $userGroupVo = null) {
		$result = $this->executeSelectList ( UserGroupMapping::class, 'selectAll', $userGroupVo );
		return $result;
	}
	final public function selectByFilter(UserGroupVo $userGroupVo = null) {
		$result = $this->executeSelectList ( UserGroupMapping::class, 'selectByFilter', $userGroupVo );
		return $result;
	}
	final public function countByFilter(UserGroupVo $userGroupVo = null) {
		$result = $this->executeCount ( UserGroupMapping::class, 'countByFilter', $userGroupVo );
		return $result;
	}
	final public function insertDynamic(UserGroupVo $userGroupVo = null) {
		$result = $this->executeInsert ( UserGroupMapping::class, 'insertDynamic', $userGroupVo );
		return $result;
	}
	final public function insertDynamicWithId(UserGroupVo $userGroupVo = null) {
		$result = $this->executeInsert ( UserGroupMapping::class, 'insertDynamicWithId', $userGroupVo );
		return $result;
	}
	final public function updateDynamicByKey(UserGroupVo $userGroupVo = null) {
		$result = $this->executeUpdate ( UserGroupMapping::class, 'updateDynamicByKey', $userGroupVo );
		return $result;
	}
	final public function deleteByKey(UserGroupVo $userGroupVo = null) {
		$result = $this->executeDelete ( UserGroupMapping::class, 'deleteByKey', $userGroupVo );
		return $result;
	}
}

