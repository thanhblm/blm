<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\base\mapping\RegionPaymentMethodMapping;

class RegionPaymentMethodBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeSelectOne ( RegionPaymentMethodMapping::class, 'selectByKey', $regionPaymentMethodVo );
		return $result;
	}
	final public function selectAll(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeSelectList ( RegionPaymentMethodMapping::class, 'selectAll', $regionPaymentMethodVo );
		return $result;
	}
	final public function selectByFilter(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeSelectList ( RegionPaymentMethodMapping::class, 'selectByFilter', $regionPaymentMethodVo );
		return $result;
	}
	final public function countByFilter(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeCount ( RegionPaymentMethodMapping::class, 'countByFilter', $regionPaymentMethodVo );
		return $result;
	}
	final public function insertDynamic(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeInsert ( RegionPaymentMethodMapping::class, 'insertDynamic', $regionPaymentMethodVo );
		return $result;
	}
	final public function insertDynamicWithId(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeInsert ( RegionPaymentMethodMapping::class, 'insertDynamicWithId', $regionPaymentMethodVo );
		return $result;
	}
	final public function updateDynamicByKey(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeUpdate ( RegionPaymentMethodMapping::class, 'updateDynamicByKey', $regionPaymentMethodVo );
		return $result;
	}
	final public function deleteByKey(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeDelete ( RegionPaymentMethodMapping::class, 'deleteByKey', $regionPaymentMethodVo );
		return $result;
	}
}

