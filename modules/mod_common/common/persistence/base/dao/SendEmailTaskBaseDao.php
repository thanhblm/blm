<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SendEmailTaskVo;
use common\persistence\base\mapping\SendEmailTaskMapping;

class SendEmailTaskBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeSelectOne ( SendEmailTaskMapping::class, 'selectByKey', $sendEmailTaskVo );
		return $result;
	}
	final public function selectAll(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeSelectList ( SendEmailTaskMapping::class, 'selectAll', $sendEmailTaskVo );
		return $result;
	}
	final public function selectByFilter(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeSelectList ( SendEmailTaskMapping::class, 'selectByFilter', $sendEmailTaskVo );
		return $result;
	}
	final public function countByFilter(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeCount ( SendEmailTaskMapping::class, 'countByFilter', $sendEmailTaskVo );
		return $result;
	}
	final public function insertDynamic(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeInsert ( SendEmailTaskMapping::class, 'insertDynamic', $sendEmailTaskVo );
		return $result;
	}
	final public function insertDynamicWithId(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeInsert ( SendEmailTaskMapping::class, 'insertDynamicWithId', $sendEmailTaskVo );
		return $result;
	}
	final public function updateDynamicByKey(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeUpdate ( SendEmailTaskMapping::class, 'updateDynamicByKey', $sendEmailTaskVo );
		return $result;
	}
	final public function deleteByKey(SendEmailTaskVo $sendEmailTaskVo = null) {
		$result = $this->executeDelete ( SendEmailTaskMapping::class, 'deleteByKey', $sendEmailTaskVo );
		return $result;
	}
}

