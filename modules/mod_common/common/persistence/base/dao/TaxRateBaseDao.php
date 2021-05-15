<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\TaxRateVo;
use common\persistence\base\mapping\TaxRateMapping;

class TaxRateBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(TaxRateVo $taxRateVo = null) {
		$result = $this->executeSelectOne ( TaxRateMapping::class, 'selectByKey', $taxRateVo );
		return $result;
	}
	final public function selectAll(TaxRateVo $taxRateVo = null) {
		$result = $this->executeSelectList ( TaxRateMapping::class, 'selectAll', $taxRateVo );
		return $result;
	}
	final public function selectByFilter(TaxRateVo $taxRateVo = null) {
		$result = $this->executeSelectList ( TaxRateMapping::class, 'selectByFilter', $taxRateVo );
		return $result;
	}
	final public function countByFilter(TaxRateVo $taxRateVo = null) {
		$result = $this->executeCount ( TaxRateMapping::class, 'countByFilter', $taxRateVo );
		return $result;
	}
	final public function insertDynamic(TaxRateVo $taxRateVo = null) {
		$result = $this->executeInsert ( TaxRateMapping::class, 'insertDynamic', $taxRateVo );
		return $result;
	}
	final public function insertDynamicWithId(TaxRateVo $taxRateVo = null) {
		$result = $this->executeInsert ( TaxRateMapping::class, 'insertDynamicWithId', $taxRateVo );
		return $result;
	}
	final public function updateDynamicByKey(TaxRateVo $taxRateVo = null) {
		$result = $this->executeUpdate ( TaxRateMapping::class, 'updateDynamicByKey', $taxRateVo );
		return $result;
	}
	final public function deleteByKey(TaxRateVo $taxRateVo = null) {
		$result = $this->executeDelete ( TaxRateMapping::class, 'deleteByKey', $taxRateVo );
		return $result;
	}
}

