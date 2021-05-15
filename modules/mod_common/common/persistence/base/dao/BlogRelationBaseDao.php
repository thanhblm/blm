<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BlogRelationVo;
use common\persistence\base\mapping\BlogRelationMapping;

class BlogRelationBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeSelectOne ( BlogRelationMapping::class, 'selectByKey', $blogRelationVo );
		return $result;
	}
	final public function selectAll(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeSelectList ( BlogRelationMapping::class, 'selectAll', $blogRelationVo );
		return $result;
	}
	final public function selectByFilter(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeSelectList ( BlogRelationMapping::class, 'selectByFilter', $blogRelationVo );
		return $result;
	}
	final public function countByFilter(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeCount ( BlogRelationMapping::class, 'countByFilter', $blogRelationVo );
		return $result;
	}
	final public function insertDynamic(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeInsert ( BlogRelationMapping::class, 'insertDynamic', $blogRelationVo );
		return $result;
	}
	final public function insertDynamicWithId(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeInsert ( BlogRelationMapping::class, 'insertDynamicWithId', $blogRelationVo );
		return $result;
	}
	final public function updateDynamicByKey(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeUpdate ( BlogRelationMapping::class, 'updateDynamicByKey', $blogRelationVo );
		return $result;
	}
	final public function deleteByKey(BlogRelationVo $blogRelationVo = null) {
		$result = $this->executeDelete ( BlogRelationMapping::class, 'deleteByKey', $blogRelationVo );
		return $result;
	}
}

