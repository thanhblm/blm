<?php

namespace common\persistence\extend\dao;
use core\database\BaseDao;
use core\database\SqlMapClient;
use common\persistence\extend\vo\WidgetExtendVo;
use common\persistence\extend\mapping\WidgetExtendMapping;

class WidgetExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function getWidgetList(WidgetExtendVo $widgetExtendVo = null) {
		return $this->executeSelectList ( WidgetExtendMapping::class, 'getWidgetList', $widgetExtendVo );
	}
}