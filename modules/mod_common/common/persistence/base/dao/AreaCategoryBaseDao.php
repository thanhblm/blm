<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AreaCategoryVo;
use common\persistence\base\mapping\AreaCategoryMapping;

class AreaCategoryBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeSelectOne ( AreaCategoryMapping::class, 'selectByKey', $areaCategoryVo );
		return $result;
	}
	final public function selectAll(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeSelectList ( AreaCategoryMapping::class, 'selectAll', $areaCategoryVo );
		return $result;
	}
	final public function selectByFilter(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeSelectList ( AreaCategoryMapping::class, 'selectByFilter', $areaCategoryVo );
		return $result;
	}
	final public function countByFilter(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeCount ( AreaCategoryMapping::class, 'countByFilter', $areaCategoryVo );
		return $result;
	}
	final public function insertDynamic(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeInsert ( AreaCategoryMapping::class, 'insertDynamic', $areaCategoryVo );
		return $result;
	}
	final public function insertDynamicWithId(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeInsert ( AreaCategoryMapping::class, 'insertDynamicWithId', $areaCategoryVo );
		return $result;
	}
	final public function updateDynamicByKey(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeUpdate ( AreaCategoryMapping::class, 'updateDynamicByKey', $areaCategoryVo );
		return $result;
	}
	final public function deleteByKey(AreaCategoryVo $areaCategoryVo = null) {
		$result = $this->executeDelete ( AreaCategoryMapping::class, 'deleteByKey', $areaCategoryVo );
		return $result;
	}
}

