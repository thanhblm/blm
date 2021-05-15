<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\WidgetCatVo;
use common\persistence\base\mapping\WidgetCatMapping;

class WidgetCatBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeSelectOne ( WidgetCatMapping::class, 'selectByKey', $widgetCatVo );
		return $result;
	}
	final public function selectAll(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeSelectList ( WidgetCatMapping::class, 'selectAll', $widgetCatVo );
		return $result;
	}
	final public function selectByFilter(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeSelectList ( WidgetCatMapping::class, 'selectByFilter', $widgetCatVo );
		return $result;
	}
	final public function countByFilter(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeCount ( WidgetCatMapping::class, 'countByFilter', $widgetCatVo );
		return $result;
	}
	final public function insertDynamic(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeInsert ( WidgetCatMapping::class, 'insertDynamic', $widgetCatVo );
		return $result;
	}
	final public function insertDynamicWithId(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeInsert ( WidgetCatMapping::class, 'insertDynamicWithId', $widgetCatVo );
		return $result;
	}
	final public function updateDynamicByKey(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeUpdate ( WidgetCatMapping::class, 'updateDynamicByKey', $widgetCatVo );
		return $result;
	}
	final public function deleteByKey(WidgetCatVo $widgetCatVo = null) {
		$result = $this->executeDelete ( WidgetCatMapping::class, 'deleteByKey', $widgetCatVo );
		return $result;
	}
}

