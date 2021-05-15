<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ContactVo;
use common\persistence\base\mapping\ContactMapping;

class ContactBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ContactVo $contactVo = null) {
		$result = $this->executeSelectOne ( ContactMapping::class, 'selectByKey', $contactVo );
		return $result;
	}
	final public function selectAll(ContactVo $contactVo = null) {
		$result = $this->executeSelectList ( ContactMapping::class, 'selectAll', $contactVo );
		return $result;
	}
	final public function selectByFilter(ContactVo $contactVo = null) {
		$result = $this->executeSelectList ( ContactMapping::class, 'selectByFilter', $contactVo );
		return $result;
	}
	final public function countByFilter(ContactVo $contactVo = null) {
		$result = $this->executeCount ( ContactMapping::class, 'countByFilter', $contactVo );
		return $result;
	}
	final public function insertDynamic(ContactVo $contactVo = null) {
		$result = $this->executeInsert ( ContactMapping::class, 'insertDynamic', $contactVo );
		return $result;
	}
	final public function insertDynamicWithId(ContactVo $contactVo = null) {
		$result = $this->executeInsert ( ContactMapping::class, 'insertDynamicWithId', $contactVo );
		return $result;
	}
	final public function updateDynamicByKey(ContactVo $contactVo = null) {
		$result = $this->executeUpdate ( ContactMapping::class, 'updateDynamicByKey', $contactVo );
		return $result;
	}
	final public function deleteByKey(ContactVo $contactVo = null) {
		$result = $this->executeDelete ( ContactMapping::class, 'deleteByKey', $contactVo );
		return $result;
	}
}

