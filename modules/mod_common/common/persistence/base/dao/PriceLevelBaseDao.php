<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\base\mapping\PriceLevelMapping;

class PriceLevelBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeSelectOne ( PriceLevelMapping::class, 'selectByKey', $priceLevelVo );
		return $result;
	}
	final public function selectAll(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeSelectList ( PriceLevelMapping::class, 'selectAll', $priceLevelVo );
		return $result;
	}
	final public function selectByFilter(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeSelectList ( PriceLevelMapping::class, 'selectByFilter', $priceLevelVo );
		return $result;
	}
	final public function countByFilter(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeCount ( PriceLevelMapping::class, 'countByFilter', $priceLevelVo );
		return $result;
	}
	final public function insertDynamic(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeInsert ( PriceLevelMapping::class, 'insertDynamic', $priceLevelVo );
		return $result;
	}
	final public function insertDynamicWithId(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeInsert ( PriceLevelMapping::class, 'insertDynamicWithId', $priceLevelVo );
		return $result;
	}
	final public function updateDynamicByKey(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeUpdate ( PriceLevelMapping::class, 'updateDynamicByKey', $priceLevelVo );
		return $result;
	}
	final public function deleteByKey(PriceLevelVo $priceLevelVo = null) {
		$result = $this->executeDelete ( PriceLevelMapping::class, 'deleteByKey', $priceLevelVo );
		return $result;
	}
}

