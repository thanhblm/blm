<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CategoryVo;
use common\persistence\base\mapping\CategoryMapping;

class CategoryBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CategoryVo $categoryVo = null) {
		$result = $this->executeSelectOne ( CategoryMapping::class, 'selectByKey', $categoryVo );
		return $result;
	}
	final public function selectAll(CategoryVo $categoryVo = null) {
		$result = $this->executeSelectList ( CategoryMapping::class, 'selectAll', $categoryVo );
		return $result;
	}
	final public function selectByFilter(CategoryVo $categoryVo = null) {
		$result = $this->executeSelectList ( CategoryMapping::class, 'selectByFilter', $categoryVo );
		return $result;
	}
	final public function countByFilter(CategoryVo $categoryVo = null) {
		$result = $this->executeCount ( CategoryMapping::class, 'countByFilter', $categoryVo );
		return $result;
	}
	final public function insertDynamic(CategoryVo $categoryVo = null) {
		$result = $this->executeInsert ( CategoryMapping::class, 'insertDynamic', $categoryVo );
		return $result;
	}
	final public function insertDynamicWithId(CategoryVo $categoryVo = null) {
		$result = $this->executeInsert ( CategoryMapping::class, 'insertDynamicWithId', $categoryVo );
		return $result;
	}
	final public function updateDynamicByKey(CategoryVo $categoryVo = null) {
		$result = $this->executeUpdate ( CategoryMapping::class, 'updateDynamicByKey', $categoryVo );
		return $result;
	}
	final public function deleteByKey(CategoryVo $categoryVo = null) {
		$result = $this->executeDelete ( CategoryMapping::class, 'deleteByKey', $categoryVo );
		return $result;
	}
}

