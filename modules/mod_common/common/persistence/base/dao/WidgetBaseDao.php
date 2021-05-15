<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\WidgetVo;
use common\persistence\base\mapping\WidgetMapping;

class WidgetBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(WidgetVo $widgetVo = null) {
		$result = $this->executeSelectOne ( WidgetMapping::class, 'selectByKey', $widgetVo );
		return $result;
	}
	final public function selectAll(WidgetVo $widgetVo = null) {
		$result = $this->executeSelectList ( WidgetMapping::class, 'selectAll', $widgetVo );
		return $result;
	}
	final public function selectByFilter(WidgetVo $widgetVo = null) {
		$result = $this->executeSelectList ( WidgetMapping::class, 'selectByFilter', $widgetVo );
		return $result;
	}
	final public function countByFilter(WidgetVo $widgetVo = null) {
		$result = $this->executeCount ( WidgetMapping::class, 'countByFilter', $widgetVo );
		return $result;
	}
	final public function insertDynamic(WidgetVo $widgetVo = null) {
		$result = $this->executeInsert ( WidgetMapping::class, 'insertDynamic', $widgetVo );
		return $result;
	}
	final public function insertDynamicWithId(WidgetVo $widgetVo = null) {
		$result = $this->executeInsert ( WidgetMapping::class, 'insertDynamicWithId', $widgetVo );
		return $result;
	}
	final public function updateDynamicByKey(WidgetVo $widgetVo = null) {
		$result = $this->executeUpdate ( WidgetMapping::class, 'updateDynamicByKey', $widgetVo );
		return $result;
	}
	final public function deleteByKey(WidgetVo $widgetVo = null) {
		$result = $this->executeDelete ( WidgetMapping::class, 'deleteByKey', $widgetVo );
		return $result;
	}
}

