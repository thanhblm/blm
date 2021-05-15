<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\mapping\CountryMapping;

class CountryBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CountryVo $countryVo = null) {
		$result = $this->executeSelectOne ( CountryMapping::class, 'selectByKey', $countryVo );
		return $result;
	}
	final public function selectAll(CountryVo $countryVo = null) {
		$result = $this->executeSelectList ( CountryMapping::class, 'selectAll', $countryVo );
		return $result;
	}
	final public function selectByFilter(CountryVo $countryVo = null) {
		$result = $this->executeSelectList ( CountryMapping::class, 'selectByFilter', $countryVo );
		return $result;
	}
	final public function countByFilter(CountryVo $countryVo = null) {
		$result = $this->executeCount ( CountryMapping::class, 'countByFilter', $countryVo );
		return $result;
	}
	final public function insertDynamic(CountryVo $countryVo = null) {
		$result = $this->executeInsert ( CountryMapping::class, 'insertDynamic', $countryVo );
		return $result;
	}
	final public function insertDynamicWithId(CountryVo $countryVo = null) {
		$result = $this->executeInsert ( CountryMapping::class, 'insertDynamicWithId', $countryVo );
		return $result;
	}
	final public function updateDynamicByKey(CountryVo $countryVo = null) {
		$result = $this->executeUpdate ( CountryMapping::class, 'updateDynamicByKey', $countryVo );
		return $result;
	}
	final public function deleteByKey(CountryVo $countryVo = null) {
		$result = $this->executeDelete ( CountryMapping::class, 'deleteByKey', $countryVo );
		return $result;
	}
}

