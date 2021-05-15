<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\mapping\EmailTemplateMapping;

class EmailTemplateBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeSelectOne ( EmailTemplateMapping::class, 'selectByKey', $emailTemplateVo );
		return $result;
	}
	final public function selectAll(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeSelectList ( EmailTemplateMapping::class, 'selectAll', $emailTemplateVo );
		return $result;
	}
	final public function selectByFilter(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeSelectList ( EmailTemplateMapping::class, 'selectByFilter', $emailTemplateVo );
		return $result;
	}
	final public function countByFilter(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeCount ( EmailTemplateMapping::class, 'countByFilter', $emailTemplateVo );
		return $result;
	}
	final public function insertDynamic(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeInsert ( EmailTemplateMapping::class, 'insertDynamic', $emailTemplateVo );
		return $result;
	}
	final public function insertDynamicWithId(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeInsert ( EmailTemplateMapping::class, 'insertDynamicWithId', $emailTemplateVo );
		return $result;
	}
	final public function updateDynamicByKey(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeUpdate ( EmailTemplateMapping::class, 'updateDynamicByKey', $emailTemplateVo );
		return $result;
	}
	final public function deleteByKey(EmailTemplateVo $emailTemplateVo = null) {
		$result = $this->executeDelete ( EmailTemplateMapping::class, 'deleteByKey', $emailTemplateVo );
		return $result;
	}
}

