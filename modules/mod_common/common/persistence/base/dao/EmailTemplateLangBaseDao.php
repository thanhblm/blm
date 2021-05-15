<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\EmailTemplateLangVo;
use common\persistence\base\mapping\EmailTemplateLangMapping;

class EmailTemplateLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeSelectOne ( EmailTemplateLangMapping::class, 'selectByKey', $emailTemplateLangVo );
		return $result;
	}
	final public function selectAll(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeSelectList ( EmailTemplateLangMapping::class, 'selectAll', $emailTemplateLangVo );
		return $result;
	}
	final public function selectByFilter(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeSelectList ( EmailTemplateLangMapping::class, 'selectByFilter', $emailTemplateLangVo );
		return $result;
	}
	final public function countByFilter(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeCount ( EmailTemplateLangMapping::class, 'countByFilter', $emailTemplateLangVo );
		return $result;
	}
	final public function insertDynamic(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeInsert ( EmailTemplateLangMapping::class, 'insertDynamic', $emailTemplateLangVo );
		return $result;
	}
	final public function insertDynamicWithId(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeInsert ( EmailTemplateLangMapping::class, 'insertDynamicWithId', $emailTemplateLangVo );
		return $result;
	}
	final public function updateDynamicByKey(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeUpdate ( EmailTemplateLangMapping::class, 'updateDynamicByKey', $emailTemplateLangVo );
		return $result;
	}
	final public function deleteByKey(EmailTemplateLangVo $emailTemplateLangVo = null) {
		$result = $this->executeDelete ( EmailTemplateLangMapping::class, 'deleteByKey', $emailTemplateLangVo );
		return $result;
	}
}

