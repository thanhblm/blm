<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\WidgetContentLangVo;
use common\persistence\base\mapping\WidgetContentLangMapping;

class WidgetContentLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeSelectOne ( WidgetContentLangMapping::class, 'selectByKey', $widgetContentLangVo );
		return $result;
	}
	final public function selectAll(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeSelectList ( WidgetContentLangMapping::class, 'selectAll', $widgetContentLangVo );
		return $result;
	}
	final public function selectByFilter(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeSelectList ( WidgetContentLangMapping::class, 'selectByFilter', $widgetContentLangVo );
		return $result;
	}
	final public function countByFilter(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeCount ( WidgetContentLangMapping::class, 'countByFilter', $widgetContentLangVo );
		return $result;
	}
	final public function insertDynamic(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeInsert ( WidgetContentLangMapping::class, 'insertDynamic', $widgetContentLangVo );
		return $result;
	}
	final public function insertDynamicWithId(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeInsert ( WidgetContentLangMapping::class, 'insertDynamicWithId', $widgetContentLangVo );
		return $result;
	}
	final public function updateDynamicByKey(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeUpdate ( WidgetContentLangMapping::class, 'updateDynamicByKey', $widgetContentLangVo );
		return $result;
	}
	final public function deleteByKey(WidgetContentLangVo $widgetContentLangVo = null) {
		$result = $this->executeDelete ( WidgetContentLangMapping::class, 'deleteByKey', $widgetContentLangVo );
		return $result;
	}
}

