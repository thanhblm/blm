<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductRelationVo;
use common\persistence\base\mapping\ProductRelationMapping;

class ProductRelationBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeSelectOne ( ProductRelationMapping::class, 'selectByKey', $productRelationVo );
		return $result;
	}
	final public function selectAll(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeSelectList ( ProductRelationMapping::class, 'selectAll', $productRelationVo );
		return $result;
	}
	final public function selectByFilter(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeSelectList ( ProductRelationMapping::class, 'selectByFilter', $productRelationVo );
		return $result;
	}
	final public function countByFilter(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeCount ( ProductRelationMapping::class, 'countByFilter', $productRelationVo );
		return $result;
	}
	final public function insertDynamic(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeInsert ( ProductRelationMapping::class, 'insertDynamic', $productRelationVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeInsert ( ProductRelationMapping::class, 'insertDynamicWithId', $productRelationVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeUpdate ( ProductRelationMapping::class, 'updateDynamicByKey', $productRelationVo );
		return $result;
	}
	final public function deleteByKey(ProductRelationVo $productRelationVo = null) {
		$result = $this->executeDelete ( ProductRelationMapping::class, 'deleteByKey', $productRelationVo );
		return $result;
	}
}

