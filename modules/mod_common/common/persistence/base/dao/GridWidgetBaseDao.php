<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\base\mapping\GridWidgetMapping;

class GridWidgetBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeSelectOne ( GridWidgetMapping::class, 'selectByKey', $gridWidgetVo );
		return $result;
	}
	final public function selectAll(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeSelectList ( GridWidgetMapping::class, 'selectAll', $gridWidgetVo );
		return $result;
	}
	final public function selectByFilter(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeSelectList ( GridWidgetMapping::class, 'selectByFilter', $gridWidgetVo );
		return $result;
	}
	final public function countByFilter(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeCount ( GridWidgetMapping::class, 'countByFilter', $gridWidgetVo );
		return $result;
	}
	final public function insertDynamic(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeInsert ( GridWidgetMapping::class, 'insertDynamic', $gridWidgetVo );
		return $result;
	}
	final public function insertDynamicWithId(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeInsert ( GridWidgetMapping::class, 'insertDynamicWithId', $gridWidgetVo );
		return $result;
	}
	final public function updateDynamicByKey(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeUpdate ( GridWidgetMapping::class, 'updateDynamicByKey', $gridWidgetVo );
		return $result;
	}
	final public function deleteByKey(GridWidgetVo $gridWidgetVo = null) {
		$result = $this->executeDelete ( GridWidgetMapping::class, 'deleteByKey', $gridWidgetVo );
		return $result;
	}
}

