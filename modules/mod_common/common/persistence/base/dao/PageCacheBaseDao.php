<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PageCacheVo;
use common\persistence\base\mapping\PageCacheMapping;

class PageCacheBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeSelectOne ( PageCacheMapping::class, 'selectByKey', $pageCacheVo );
		return $result;
	}
	final public function selectAll(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeSelectList ( PageCacheMapping::class, 'selectAll', $pageCacheVo );
		return $result;
	}
	final public function selectByFilter(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeSelectList ( PageCacheMapping::class, 'selectByFilter', $pageCacheVo );
		return $result;
	}
	final public function countByFilter(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeCount ( PageCacheMapping::class, 'countByFilter', $pageCacheVo );
		return $result;
	}
	final public function insertDynamic(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeInsert ( PageCacheMapping::class, 'insertDynamic', $pageCacheVo );
		return $result;
	}
	final public function insertDynamicWithId(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeInsert ( PageCacheMapping::class, 'insertDynamicWithId', $pageCacheVo );
		return $result;
	}
	final public function updateDynamicByKey(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeUpdate ( PageCacheMapping::class, 'updateDynamicByKey', $pageCacheVo );
		return $result;
	}
	final public function deleteByKey(PageCacheVo $pageCacheVo = null) {
		$result = $this->executeDelete ( PageCacheMapping::class, 'deleteByKey', $pageCacheVo );
		return $result;
	}
}

