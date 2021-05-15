<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CurrencyVo;
use common\persistence\base\mapping\CurrencyMapping;

class CurrencyBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CurrencyVo $currencyVo = null) {
		$result = $this->executeSelectOne ( CurrencyMapping::class, 'selectByKey', $currencyVo );
		return $result;
	}
	final public function selectAll(CurrencyVo $currencyVo = null) {
		$result = $this->executeSelectList ( CurrencyMapping::class, 'selectAll', $currencyVo );
		return $result;
	}
	final public function selectByFilter(CurrencyVo $currencyVo = null) {
		$result = $this->executeSelectList ( CurrencyMapping::class, 'selectByFilter', $currencyVo );
		return $result;
	}
	final public function countByFilter(CurrencyVo $currencyVo = null) {
		$result = $this->executeCount ( CurrencyMapping::class, 'countByFilter', $currencyVo );
		return $result;
	}
	final public function insertDynamic(CurrencyVo $currencyVo = null) {
		$result = $this->executeInsert ( CurrencyMapping::class, 'insertDynamic', $currencyVo );
		return $result;
	}
	final public function insertDynamicWithId(CurrencyVo $currencyVo = null) {
		$result = $this->executeInsert ( CurrencyMapping::class, 'insertDynamicWithId', $currencyVo );
		return $result;
	}
	final public function updateDynamicByKey(CurrencyVo $currencyVo = null) {
		$result = $this->executeUpdate ( CurrencyMapping::class, 'updateDynamicByKey', $currencyVo );
		return $result;
	}
	final public function deleteByKey(CurrencyVo $currencyVo = null) {
		$result = $this->executeDelete ( CurrencyMapping::class, 'deleteByKey', $currencyVo );
		return $result;
	}
}

