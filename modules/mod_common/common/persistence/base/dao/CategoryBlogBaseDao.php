<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\base\mapping\CategoryBlogMapping;

class CategoryBlogBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeSelectOne ( CategoryBlogMapping::class, 'selectByKey', $categoryBlogVo );
		return $result;
	}
	final public function selectAll(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeSelectList ( CategoryBlogMapping::class, 'selectAll', $categoryBlogVo );
		return $result;
	}
	final public function selectByFilter(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeSelectList ( CategoryBlogMapping::class, 'selectByFilter', $categoryBlogVo );
		return $result;
	}
	final public function countByFilter(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeCount ( CategoryBlogMapping::class, 'countByFilter', $categoryBlogVo );
		return $result;
	}
	final public function insertDynamic(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeInsert ( CategoryBlogMapping::class, 'insertDynamic', $categoryBlogVo );
		return $result;
	}
	final public function insertDynamicWithId(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeInsert ( CategoryBlogMapping::class, 'insertDynamicWithId', $categoryBlogVo );
		return $result;
	}
	final public function updateDynamicByKey(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeUpdate ( CategoryBlogMapping::class, 'updateDynamicByKey', $categoryBlogVo );
		return $result;
	}
	final public function deleteByKey(CategoryBlogVo $categoryBlogVo = null) {
		$result = $this->executeDelete ( CategoryBlogMapping::class, 'deleteByKey', $categoryBlogVo );
		return $result;
	}
}

