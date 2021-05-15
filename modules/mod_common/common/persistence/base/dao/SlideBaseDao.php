<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SlideVo;
use common\persistence\base\mapping\SlideMapping;

class SlideBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SlideVo $slideVo = null) {
		$result = $this->executeSelectOne ( SlideMapping::class, 'selectByKey', $slideVo );
		return $result;
	}
	final public function selectAll(SlideVo $slideVo = null) {
		$result = $this->executeSelectList ( SlideMapping::class, 'selectAll', $slideVo );
		return $result;
	}
	final public function selectByFilter(SlideVo $slideVo = null) {
		$result = $this->executeSelectList ( SlideMapping::class, 'selectByFilter', $slideVo );
		return $result;
	}
	final public function countByFilter(SlideVo $slideVo = null) {
		$result = $this->executeCount ( SlideMapping::class, 'countByFilter', $slideVo );
		return $result;
	}
	final public function insertDynamic(SlideVo $slideVo = null) {
		$result = $this->executeInsert ( SlideMapping::class, 'insertDynamic', $slideVo );
		return $result;
	}
	final public function insertDynamicWithId(SlideVo $slideVo = null) {
		$result = $this->executeInsert ( SlideMapping::class, 'insertDynamicWithId', $slideVo );
		return $result;
	}
	final public function updateDynamicByKey(SlideVo $slideVo = null) {
		$result = $this->executeUpdate ( SlideMapping::class, 'updateDynamicByKey', $slideVo );
		return $result;
	}
	final public function deleteByKey(SlideVo $slideVo = null) {
		$result = $this->executeDelete ( SlideMapping::class, 'deleteByKey', $slideVo );
		return $result;
	}
}

