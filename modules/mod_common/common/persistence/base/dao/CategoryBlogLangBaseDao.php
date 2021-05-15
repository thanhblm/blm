<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CategoryBlogLangVo;
use common\persistence\base\mapping\CategoryBlogLangMapping;

class CategoryBlogLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeSelectOne ( CategoryBlogLangMapping::class, 'selectByKey', $categoryBlogLangVo );
		return $result;
	}
	final public function selectAll(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeSelectList ( CategoryBlogLangMapping::class, 'selectAll', $categoryBlogLangVo );
		return $result;
	}
	final public function selectByFilter(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeSelectList ( CategoryBlogLangMapping::class, 'selectByFilter', $categoryBlogLangVo );
		return $result;
	}
	final public function countByFilter(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeCount ( CategoryBlogLangMapping::class, 'countByFilter', $categoryBlogLangVo );
		return $result;
	}
	final public function insertDynamic(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeInsert ( CategoryBlogLangMapping::class, 'insertDynamic', $categoryBlogLangVo );
		return $result;
	}
	final public function insertDynamicWithId(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeInsert ( CategoryBlogLangMapping::class, 'insertDynamicWithId', $categoryBlogLangVo );
		return $result;
	}
	final public function updateDynamicByKey(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeUpdate ( CategoryBlogLangMapping::class, 'updateDynamicByKey', $categoryBlogLangVo );
		return $result;
	}
	final public function deleteByKey(CategoryBlogLangVo $categoryBlogLangVo = null) {
		$result = $this->executeDelete ( CategoryBlogLangMapping::class, 'deleteByKey', $categoryBlogLangVo );
		return $result;
	}
}

