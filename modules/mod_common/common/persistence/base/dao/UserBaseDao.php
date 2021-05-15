<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\UserVo;
use common\persistence\base\mapping\UserMapping;

class UserBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(UserVo $userVo = null) {
		$result = $this->executeSelectOne ( UserMapping::class, 'selectByKey', $userVo );
		return $result;
	}
	final public function selectAll(UserVo $userVo = null) {
		$result = $this->executeSelectList ( UserMapping::class, 'selectAll', $userVo );
		return $result;
	}
	final public function selectByFilter(UserVo $userVo = null) {
		$result = $this->executeSelectList ( UserMapping::class, 'selectByFilter', $userVo );
		return $result;
	}
	final public function countByFilter(UserVo $userVo = null) {
		$result = $this->executeCount ( UserMapping::class, 'countByFilter', $userVo );
		return $result;
	}
	final public function insertDynamic(UserVo $userVo = null) {
		$result = $this->executeInsert ( UserMapping::class, 'insertDynamic', $userVo );
		return $result;
	}
	final public function insertDynamicWithId(UserVo $userVo = null) {
		$result = $this->executeInsert ( UserMapping::class, 'insertDynamicWithId', $userVo );
		return $result;
	}
	final public function updateDynamicByKey(UserVo $userVo = null) {
		$result = $this->executeUpdate ( UserMapping::class, 'updateDynamicByKey', $userVo );
		return $result;
	}
	final public function deleteByKey(UserVo $userVo = null) {
		$result = $this->executeDelete ( UserMapping::class, 'deleteByKey', $userVo );
		return $result;
	}
}

