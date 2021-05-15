<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\mapping\ProductPriceMapping;

class ProductPriceBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeSelectOne ( ProductPriceMapping::class, 'selectByKey', $productPriceVo );
		return $result;
	}
	final public function selectAll(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeSelectList ( ProductPriceMapping::class, 'selectAll', $productPriceVo );
		return $result;
	}
	final public function selectByFilter(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeSelectList ( ProductPriceMapping::class, 'selectByFilter', $productPriceVo );
		return $result;
	}
	final public function countByFilter(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeCount ( ProductPriceMapping::class, 'countByFilter', $productPriceVo );
		return $result;
	}
	final public function insertDynamic(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeInsert ( ProductPriceMapping::class, 'insertDynamic', $productPriceVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeInsert ( ProductPriceMapping::class, 'insertDynamicWithId', $productPriceVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeUpdate ( ProductPriceMapping::class, 'updateDynamicByKey', $productPriceVo );
		return $result;
	}
	final public function deleteByKey(ProductPriceVo $productPriceVo = null) {
		$result = $this->executeDelete ( ProductPriceMapping::class, 'deleteByKey', $productPriceVo );
		return $result;
	}
}

