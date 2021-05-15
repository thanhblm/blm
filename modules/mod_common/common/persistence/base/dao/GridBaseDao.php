<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\GridVo;
use common\persistence\base\mapping\GridMapping;

class GridBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(GridVo $gridVo = null) {
		$result = $this->executeSelectOne ( GridMapping::class, 'selectByKey', $gridVo );
		return $result;
	}
	final public function selectAll(GridVo $gridVo = null) {
		$result = $this->executeSelectList ( GridMapping::class, 'selectAll', $gridVo );
		return $result;
	}
	final public function selectByFilter(GridVo $gridVo = null) {
		$result = $this->executeSelectList ( GridMapping::class, 'selectByFilter', $gridVo );
		return $result;
	}
	final public function countByFilter(GridVo $gridVo = null) {
		$result = $this->executeCount ( GridMapping::class, 'countByFilter', $gridVo );
		return $result;
	}
	final public function insertDynamic(GridVo $gridVo = null) {
		$result = $this->executeInsert ( GridMapping::class, 'insertDynamic', $gridVo );
		return $result;
	}
	final public function insertDynamicWithId(GridVo $gridVo = null) {
		$result = $this->executeInsert ( GridMapping::class, 'insertDynamicWithId', $gridVo );
		return $result;
	}
	final public function updateDynamicByKey(GridVo $gridVo = null) {
		$result = $this->executeUpdate ( GridMapping::class, 'updateDynamicByKey', $gridVo );
		return $result;
	}
	final public function deleteByKey(GridVo $gridVo = null) {
		$result = $this->executeDelete ( GridMapping::class, 'deleteByKey', $gridVo );
		return $result;
	}
}

