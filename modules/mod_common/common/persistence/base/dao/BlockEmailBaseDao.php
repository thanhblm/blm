<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\BlockEmailVo;
use common\persistence\base\mapping\BlockEmailMapping;

class BlockEmailBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeSelectOne ( BlockEmailMapping::class, 'selectByKey', $blockEmailVo );
		return $result;
	}
	final public function selectAll(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeSelectList ( BlockEmailMapping::class, 'selectAll', $blockEmailVo );
		return $result;
	}
	final public function selectByFilter(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeSelectList ( BlockEmailMapping::class, 'selectByFilter', $blockEmailVo );
		return $result;
	}
	final public function countByFilter(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeCount ( BlockEmailMapping::class, 'countByFilter', $blockEmailVo );
		return $result;
	}
	final public function insertDynamic(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeInsert ( BlockEmailMapping::class, 'insertDynamic', $blockEmailVo );
		return $result;
	}
	final public function insertDynamicWithId(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeInsert ( BlockEmailMapping::class, 'insertDynamicWithId', $blockEmailVo );
		return $result;
	}
	final public function updateDynamicByKey(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeUpdate ( BlockEmailMapping::class, 'updateDynamicByKey', $blockEmailVo );
		return $result;
	}
	final public function deleteByKey(BlockEmailVo $blockEmailVo = null) {
		$result = $this->executeDelete ( BlockEmailMapping::class, 'deleteByKey', $blockEmailVo );
		return $result;
	}
}

