<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SystemSettingVo;
use common\persistence\base\mapping\SystemSettingMapping;

class SystemSettingBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeSelectOne ( SystemSettingMapping::class, 'selectByKey', $systemSettingVo );
		return $result;
	}
	final public function selectAll(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeSelectList ( SystemSettingMapping::class, 'selectAll', $systemSettingVo );
		return $result;
	}
	final public function selectByFilter(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeSelectList ( SystemSettingMapping::class, 'selectByFilter', $systemSettingVo );
		return $result;
	}
	final public function countByFilter(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeCount ( SystemSettingMapping::class, 'countByFilter', $systemSettingVo );
		return $result;
	}
	final public function insertDynamic(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeInsert ( SystemSettingMapping::class, 'insertDynamic', $systemSettingVo );
		return $result;
	}
	final public function insertDynamicWithId(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeInsert ( SystemSettingMapping::class, 'insertDynamicWithId', $systemSettingVo );
		return $result;
	}
	final public function updateDynamicByKey(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeUpdate ( SystemSettingMapping::class, 'updateDynamicByKey', $systemSettingVo );
		return $result;
	}
	final public function deleteByKey(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeDelete ( SystemSettingMapping::class, 'deleteByKey', $systemSettingVo );
		return $result;
	}
}

