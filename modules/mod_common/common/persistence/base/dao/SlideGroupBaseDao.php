<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SlideGroupVo;
use common\persistence\base\mapping\SlideGroupMapping;

class SlideGroupBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeSelectOne ( SlideGroupMapping::class, 'selectByKey', $slideGroupVo );
		return $result;
	}
	final public function selectAll(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeSelectList ( SlideGroupMapping::class, 'selectAll', $slideGroupVo );
		return $result;
	}
	final public function selectByFilter(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeSelectList ( SlideGroupMapping::class, 'selectByFilter', $slideGroupVo );
		return $result;
	}
	final public function countByFilter(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeCount ( SlideGroupMapping::class, 'countByFilter', $slideGroupVo );
		return $result;
	}
	final public function insertDynamic(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeInsert ( SlideGroupMapping::class, 'insertDynamic', $slideGroupVo );
		return $result;
	}
	final public function insertDynamicWithId(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeInsert ( SlideGroupMapping::class, 'insertDynamicWithId', $slideGroupVo );
		return $result;
	}
	final public function updateDynamicByKey(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeUpdate ( SlideGroupMapping::class, 'updateDynamicByKey', $slideGroupVo );
		return $result;
	}
	final public function deleteByKey(SlideGroupVo $slideGroupVo = null) {
		$result = $this->executeDelete ( SlideGroupMapping::class, 'deleteByKey', $slideGroupVo );
		return $result;
	}
}

