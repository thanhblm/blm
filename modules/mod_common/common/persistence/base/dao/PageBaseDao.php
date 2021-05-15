<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PageVo;
use common\persistence\base\mapping\PageMapping;

class PageBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PageVo $pageVo = null) {
		$result = $this->executeSelectOne ( PageMapping::class, 'selectByKey', $pageVo );
		return $result;
	}
	final public function selectAll(PageVo $pageVo = null) {
		$result = $this->executeSelectList ( PageMapping::class, 'selectAll', $pageVo );
		return $result;
	}
	final public function selectByFilter(PageVo $pageVo = null) {
		$result = $this->executeSelectList ( PageMapping::class, 'selectByFilter', $pageVo );
		return $result;
	}
	final public function countByFilter(PageVo $pageVo = null) {
		$result = $this->executeCount ( PageMapping::class, 'countByFilter', $pageVo );
		return $result;
	}
	final public function insertDynamic(PageVo $pageVo = null) {
		$result = $this->executeInsert ( PageMapping::class, 'insertDynamic', $pageVo );
		return $result;
	}
	final public function insertDynamicWithId(PageVo $pageVo = null) {
		$result = $this->executeInsert ( PageMapping::class, 'insertDynamicWithId', $pageVo );
		return $result;
	}
	final public function updateDynamicByKey(PageVo $pageVo = null) {
		$result = $this->executeUpdate ( PageMapping::class, 'updateDynamicByKey', $pageVo );
		return $result;
	}
	final public function deleteByKey(PageVo $pageVo = null) {
		$result = $this->executeDelete ( PageMapping::class, 'deleteByKey', $pageVo );
		return $result;
	}
}

