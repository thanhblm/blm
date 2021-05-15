<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\base\mapping\TaxRateInfoMapping;

class TaxRateInfoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeSelectOne ( TaxRateInfoMapping::class, 'selectByKey', $taxRateInfoVo );
		return $result;
	}
	final public function selectAll(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeSelectList ( TaxRateInfoMapping::class, 'selectAll', $taxRateInfoVo );
		return $result;
	}
	final public function selectByFilter(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeSelectList ( TaxRateInfoMapping::class, 'selectByFilter', $taxRateInfoVo );
		return $result;
	}
	final public function countByFilter(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeCount ( TaxRateInfoMapping::class, 'countByFilter', $taxRateInfoVo );
		return $result;
	}
	final public function insertDynamic(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeInsert ( TaxRateInfoMapping::class, 'insertDynamic', $taxRateInfoVo );
		return $result;
	}
	final public function insertDynamicWithId(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeInsert ( TaxRateInfoMapping::class, 'insertDynamicWithId', $taxRateInfoVo );
		return $result;
	}
	final public function updateDynamicByKey(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeUpdate ( TaxRateInfoMapping::class, 'updateDynamicByKey', $taxRateInfoVo );
		return $result;
	}
	final public function deleteByKey(TaxRateInfoVo $taxRateInfoVo = null) {
		$result = $this->executeDelete ( TaxRateInfoMapping::class, 'deleteByKey', $taxRateInfoVo );
		return $result;
	}
}

