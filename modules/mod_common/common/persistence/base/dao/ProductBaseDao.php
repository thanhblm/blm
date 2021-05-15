<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\mapping\ProductMapping;

class ProductBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductVo $productVo = null) {
		$result = $this->executeSelectOne ( ProductMapping::class, 'selectByKey', $productVo );
		return $result;
	}
	final public function selectAll(ProductVo $productVo = null) {
		$result = $this->executeSelectList ( ProductMapping::class, 'selectAll', $productVo );
		return $result;
	}
	final public function selectByFilter(ProductVo $productVo = null) {
		$result = $this->executeSelectList ( ProductMapping::class, 'selectByFilter', $productVo );
		return $result;
	}
	final public function countByFilter(ProductVo $productVo = null) {
		$result = $this->executeCount ( ProductMapping::class, 'countByFilter', $productVo );
		return $result;
	}
	final public function insertDynamic(ProductVo $productVo = null) {
		$result = $this->executeInsert ( ProductMapping::class, 'insertDynamic', $productVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductVo $productVo = null) {
		$result = $this->executeInsert ( ProductMapping::class, 'insertDynamicWithId', $productVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductVo $productVo = null) {
		$result = $this->executeUpdate ( ProductMapping::class, 'updateDynamicByKey', $productVo );
		return $result;
	}
	final public function deleteByKey(ProductVo $productVo = null) {
		$result = $this->executeDelete ( ProductMapping::class, 'deleteByKey', $productVo );
		return $result;
	}
}

