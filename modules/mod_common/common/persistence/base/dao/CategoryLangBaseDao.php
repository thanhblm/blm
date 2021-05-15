<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CategoryLangVo;
use common\persistence\base\mapping\CategoryLangMapping;

class CategoryLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeSelectOne ( CategoryLangMapping::class, 'selectByKey', $categoryLangVo );
		return $result;
	}
	final public function selectAll(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeSelectList ( CategoryLangMapping::class, 'selectAll', $categoryLangVo );
		return $result;
	}
	final public function selectByFilter(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeSelectList ( CategoryLangMapping::class, 'selectByFilter', $categoryLangVo );
		return $result;
	}
	final public function countByFilter(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeCount ( CategoryLangMapping::class, 'countByFilter', $categoryLangVo );
		return $result;
	}
	final public function insertDynamic(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeInsert ( CategoryLangMapping::class, 'insertDynamic', $categoryLangVo );
		return $result;
	}
	final public function insertDynamicWithId(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeInsert ( CategoryLangMapping::class, 'insertDynamicWithId', $categoryLangVo );
		return $result;
	}
	final public function updateDynamicByKey(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeUpdate ( CategoryLangMapping::class, 'updateDynamicByKey', $categoryLangVo );
		return $result;
	}
	final public function deleteByKey(CategoryLangVo $categoryLangVo = null) {
		$result = $this->executeDelete ( CategoryLangMapping::class, 'deleteByKey', $categoryLangVo );
		return $result;
	}
}

