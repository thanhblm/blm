<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BlogLangVo;
use common\persistence\base\mapping\BlogLangMapping;

class BlogLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BlogLangVo $blogLangVo = null) {
		$result = $this->executeSelectOne ( BlogLangMapping::class, 'selectByKey', $blogLangVo );
		return $result;
	}
	final public function selectAll(BlogLangVo $blogLangVo = null) {
		$result = $this->executeSelectList ( BlogLangMapping::class, 'selectAll', $blogLangVo );
		return $result;
	}
	final public function selectByFilter(BlogLangVo $blogLangVo = null) {
		$result = $this->executeSelectList ( BlogLangMapping::class, 'selectByFilter', $blogLangVo );
		return $result;
	}
	final public function countByFilter(BlogLangVo $blogLangVo = null) {
		$result = $this->executeCount ( BlogLangMapping::class, 'countByFilter', $blogLangVo );
		return $result;
	}
	final public function insertDynamic(BlogLangVo $blogLangVo = null) {
		$result = $this->executeInsert ( BlogLangMapping::class, 'insertDynamic', $blogLangVo );
		return $result;
	}
	final public function insertDynamicWithId(BlogLangVo $blogLangVo = null) {
		$result = $this->executeInsert ( BlogLangMapping::class, 'insertDynamicWithId', $blogLangVo );
		return $result;
	}
	final public function updateDynamicByKey(BlogLangVo $blogLangVo = null) {
		$result = $this->executeUpdate ( BlogLangMapping::class, 'updateDynamicByKey', $blogLangVo );
		return $result;
	}
	final public function deleteByKey(BlogLangVo $blogLangVo = null) {
		$result = $this->executeDelete ( BlogLangMapping::class, 'deleteByKey', $blogLangVo );
		return $result;
	}
}

