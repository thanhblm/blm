<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SystemSettingGroupVo;
use common\persistence\base\mapping\SystemSettingGroupMapping;

class SystemSettingGroupBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeSelectOne ( SystemSettingGroupMapping::class, 'selectByKey', $systemSettingGroupVo );
		return $result;
	}
	final public function selectAll(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeSelectList ( SystemSettingGroupMapping::class, 'selectAll', $systemSettingGroupVo );
		return $result;
	}
	final public function selectByFilter(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeSelectList ( SystemSettingGroupMapping::class, 'selectByFilter', $systemSettingGroupVo );
		return $result;
	}
	final public function countByFilter(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeCount ( SystemSettingGroupMapping::class, 'countByFilter', $systemSettingGroupVo );
		return $result;
	}
	final public function insertDynamic(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeInsert ( SystemSettingGroupMapping::class, 'insertDynamic', $systemSettingGroupVo );
		return $result;
	}
	final public function insertDynamicWithId(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeInsert ( SystemSettingGroupMapping::class, 'insertDynamicWithId', $systemSettingGroupVo );
		return $result;
	}
	final public function updateDynamicByKey(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeUpdate ( SystemSettingGroupMapping::class, 'updateDynamicByKey', $systemSettingGroupVo );
		return $result;
	}
	final public function deleteByKey(SystemSettingGroupVo $systemSettingGroupVo = null) {
		$result = $this->executeDelete ( SystemSettingGroupMapping::class, 'deleteByKey', $systemSettingGroupVo );
		return $result;
	}
}

