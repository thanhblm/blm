<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductRelateVo;
use common\persistence\base\mapping\ProductRelateMapping;

class ProductRelateBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeSelectOne ( ProductRelateMapping::class, 'selectByKey', $productRelateVo );
		return $result;
	}
	final public function selectAll(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeSelectList ( ProductRelateMapping::class, 'selectAll', $productRelateVo );
		return $result;
	}
	final public function selectByFilter(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeSelectList ( ProductRelateMapping::class, 'selectByFilter', $productRelateVo );
		return $result;
	}
	final public function countByFilter(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeCount ( ProductRelateMapping::class, 'countByFilter', $productRelateVo );
		return $result;
	}
	final public function insertDynamic(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeInsert ( ProductRelateMapping::class, 'insertDynamic', $productRelateVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeUpdate ( ProductRelateMapping::class, 'updateDynamicByKey', $productRelateVo );
		return $result;
	}
	final public function deleteByKey(ProductRelateVo $productRelateVo = null) {
		$result = $this->executeDelete ( ProductRelateMapping::class, 'deleteByKey', $productRelateVo );
		return $result;
	}
}

