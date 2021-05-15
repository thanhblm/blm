<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductRegionVo;
use common\persistence\base\mapping\ProductRegionMapping;

class ProductRegionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeSelectOne ( ProductRegionMapping::class, 'selectByKey', $productRegionVo );
		return $result;
	}
	final public function selectAll(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeSelectList ( ProductRegionMapping::class, 'selectAll', $productRegionVo );
		return $result;
	}
	final public function selectByFilter(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeSelectList ( ProductRegionMapping::class, 'selectByFilter', $productRegionVo );
		return $result;
	}
	final public function countByFilter(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeCount ( ProductRegionMapping::class, 'countByFilter', $productRegionVo );
		return $result;
	}
	final public function insertDynamic(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeInsert ( ProductRegionMapping::class, 'insertDynamic', $productRegionVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeInsert ( ProductRegionMapping::class, 'insertDynamicWithId', $productRegionVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeUpdate ( ProductRegionMapping::class, 'updateDynamicByKey', $productRegionVo );
		return $result;
	}
	final public function deleteByKey(ProductRegionVo $productRegionVo = null) {
		$result = $this->executeDelete ( ProductRegionMapping::class, 'deleteByKey', $productRegionVo );
		return $result;
	}
}

