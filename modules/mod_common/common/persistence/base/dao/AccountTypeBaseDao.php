<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AccountTypeVo;
use common\persistence\base\mapping\AccountTypeMapping;

class AccountTypeBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeSelectOne ( AccountTypeMapping::class, 'selectByKey', $accountTypeVo );
		return $result;
	}
	final public function selectAll(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeSelectList ( AccountTypeMapping::class, 'selectAll', $accountTypeVo );
		return $result;
	}
	final public function selectByFilter(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeSelectList ( AccountTypeMapping::class, 'selectByFilter', $accountTypeVo );
		return $result;
	}
	final public function countByFilter(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeCount ( AccountTypeMapping::class, 'countByFilter', $accountTypeVo );
		return $result;
	}
	final public function insertDynamic(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeInsert ( AccountTypeMapping::class, 'insertDynamic', $accountTypeVo );
		return $result;
	}
	final public function insertDynamicWithId(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeInsert ( AccountTypeMapping::class, 'insertDynamicWithId', $accountTypeVo );
		return $result;
	}
	final public function updateDynamicByKey(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeUpdate ( AccountTypeMapping::class, 'updateDynamicByKey', $accountTypeVo );
		return $result;
	}
	final public function deleteByKey(AccountTypeVo $accountTypeVo = null) {
		$result = $this->executeDelete ( AccountTypeMapping::class, 'deleteByKey', $accountTypeVo );
		return $result;
	}
}

