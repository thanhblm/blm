<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\UserProfileVo;
use common\persistence\base\mapping\UserProfileMapping;

class UserProfileBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(UserProfileVo $userProfileVo = null) {
		$result = $this->executeSelectOne ( UserProfileMapping::class, 'selectByKey', $userProfileVo );
		return $result;
	}
	final public function selectAll(UserProfileVo $userProfileVo = null) {
		$result = $this->executeSelectList ( UserProfileMapping::class, 'selectAll', $userProfileVo );
		return $result;
	}
	final public function selectByFilter(UserProfileVo $userProfileVo = null) {
		$result = $this->executeSelectList ( UserProfileMapping::class, 'selectByFilter', $userProfileVo );
		return $result;
	}
	final public function countByFilter(UserProfileVo $userProfileVo = null) {
		$result = $this->executeCount ( UserProfileMapping::class, 'countByFilter', $userProfileVo );
		return $result;
	}
	final public function insertDynamic(UserProfileVo $userProfileVo = null) {
		$result = $this->executeInsert ( UserProfileMapping::class, 'insertDynamic', $userProfileVo );
		return $result;
	}
	final public function insertDynamicWithId(UserProfileVo $userProfileVo = null) {
		$result = $this->executeInsert ( UserProfileMapping::class, 'insertDynamicWithId', $userProfileVo );
		return $result;
	}
	final public function updateDynamicByKey(UserProfileVo $userProfileVo = null) {
		$result = $this->executeUpdate ( UserProfileMapping::class, 'updateDynamicByKey', $userProfileVo );
		return $result;
	}
	final public function deleteByKey(UserProfileVo $userProfileVo = null) {
		$result = $this->executeDelete ( UserProfileMapping::class, 'deleteByKey', $userProfileVo );
		return $result;
	}
}

