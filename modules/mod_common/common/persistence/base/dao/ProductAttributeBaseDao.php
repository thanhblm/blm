<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\mapping\ProductAttributeMapping;

class ProductAttributeBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeSelectOne ( ProductAttributeMapping::class, 'selectByKey', $productAttributeVo );
		return $result;
	}
	final public function selectAll(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeSelectList ( ProductAttributeMapping::class, 'selectAll', $productAttributeVo );
		return $result;
	}
	final public function selectByFilter(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeSelectList ( ProductAttributeMapping::class, 'selectByFilter', $productAttributeVo );
		return $result;
	}
	final public function countByFilter(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeCount ( ProductAttributeMapping::class, 'countByFilter', $productAttributeVo );
		return $result;
	}
	final public function insertDynamic(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeInsert ( ProductAttributeMapping::class, 'insertDynamic', $productAttributeVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeInsert ( ProductAttributeMapping::class, 'insertDynamicWithId', $productAttributeVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeUpdate ( ProductAttributeMapping::class, 'updateDynamicByKey', $productAttributeVo );
		return $result;
	}
	final public function deleteByKey(ProductAttributeVo $productAttributeVo = null) {
		$result = $this->executeDelete ( ProductAttributeMapping::class, 'deleteByKey', $productAttributeVo );
		return $result;
	}
}

