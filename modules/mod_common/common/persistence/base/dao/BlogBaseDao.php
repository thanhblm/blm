<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BlogVo;
use common\persistence\base\mapping\BlogMapping;

class BlogBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BlogVo $blogVo = null) {
		$result = $this->executeSelectOne ( BlogMapping::class, 'selectByKey', $blogVo );
		return $result;
	}
	final public function selectAll(BlogVo $blogVo = null) {
		$result = $this->executeSelectList ( BlogMapping::class, 'selectAll', $blogVo );
		return $result;
	}
	final public function selectByFilter(BlogVo $blogVo = null) {
		$result = $this->executeSelectList ( BlogMapping::class, 'selectByFilter', $blogVo );
		return $result;
	}
	final public function countByFilter(BlogVo $blogVo = null) {
		$result = $this->executeCount ( BlogMapping::class, 'countByFilter', $blogVo );
		return $result;
	}
	final public function insertDynamic(BlogVo $blogVo = null) {
		$result = $this->executeInsert ( BlogMapping::class, 'insertDynamic', $blogVo );
		return $result;
	}
	final public function insertDynamicWithId(BlogVo $blogVo = null) {
		$result = $this->executeInsert ( BlogMapping::class, 'insertDynamicWithId', $blogVo );
		return $result;
	}
	final public function updateDynamicByKey(BlogVo $blogVo = null) {
		$result = $this->executeUpdate ( BlogMapping::class, 'updateDynamicByKey', $blogVo );
		return $result;
	}
	final public function deleteByKey(BlogVo $blogVo = null) {
		$result = $this->executeDelete ( BlogMapping::class, 'deleteByKey', $blogVo );
		return $result;
	}
}

