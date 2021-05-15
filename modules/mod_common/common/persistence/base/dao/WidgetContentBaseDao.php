<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\WidgetContentVo;
use common\persistence\base\mapping\WidgetContentMapping;

class WidgetContentBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeSelectOne ( WidgetContentMapping::class, 'selectByKey', $widgetContentVo );
		return $result;
	}
	final public function selectAll(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeSelectList ( WidgetContentMapping::class, 'selectAll', $widgetContentVo );
		return $result;
	}
	final public function selectByFilter(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeSelectList ( WidgetContentMapping::class, 'selectByFilter', $widgetContentVo );
		return $result;
	}
	final public function countByFilter(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeCount ( WidgetContentMapping::class, 'countByFilter', $widgetContentVo );
		return $result;
	}
	final public function insertDynamic(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeInsert ( WidgetContentMapping::class, 'insertDynamic', $widgetContentVo );
		return $result;
	}
	final public function insertDynamicWithId(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeInsert ( WidgetContentMapping::class, 'insertDynamicWithId', $widgetContentVo );
		return $result;
	}
	final public function updateDynamicByKey(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeUpdate ( WidgetContentMapping::class, 'updateDynamicByKey', $widgetContentVo );
		return $result;
	}
	final public function deleteByKey(WidgetContentVo $widgetContentVo = null) {
		$result = $this->executeDelete ( WidgetContentMapping::class, 'deleteByKey', $widgetContentVo );
		return $result;
	}
}

