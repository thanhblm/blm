<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BlogRegionVo;
use common\persistence\base\mapping\BlogRegionMapping;

class BlogRegionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeSelectOne ( BlogRegionMapping::class, 'selectByKey', $blogRegionVo );
		return $result;
	}
	final public function selectAll(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeSelectList ( BlogRegionMapping::class, 'selectAll', $blogRegionVo );
		return $result;
	}
	final public function selectByFilter(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeSelectList ( BlogRegionMapping::class, 'selectByFilter', $blogRegionVo );
		return $result;
	}
	final public function countByFilter(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeCount ( BlogRegionMapping::class, 'countByFilter', $blogRegionVo );
		return $result;
	}
	final public function insertDynamic(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeInsert ( BlogRegionMapping::class, 'insertDynamic', $blogRegionVo );
		return $result;
	}
	final public function insertDynamicWithId(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeInsert ( BlogRegionMapping::class, 'insertDynamicWithId', $blogRegionVo );
		return $result;
	}
	final public function updateDynamicByKey(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeUpdate ( BlogRegionMapping::class, 'updateDynamicByKey', $blogRegionVo );
		return $result;
	}
	final public function deleteByKey(BlogRegionVo $blogRegionVo = null) {
		$result = $this->executeDelete ( BlogRegionMapping::class, 'deleteByKey', $blogRegionVo );
		return $result;
	}
}

