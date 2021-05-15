<?php

namespace common\persistence\extend\dao;
use core\database\BaseDao;
use core\database\SqlMapClient;
use common\persistence\extend\vo\WidgetContentExtendVo;
use common\persistence\extend\mapping\WidgetContentExtendMapping;

class WidgetContentExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function getWidgetContentInfo(WidgetContentExtendVo $widgetContentExtendVo) {
		return $this->executeSelectOne( WidgetContentExtendMapping::class, 'getWidgetContentInfo', $widgetContentExtendVo );
	}
	
	public function getWidgetContentList(WidgetContentExtendVo $widgetContentExtendVo = null) {
		return $this->executeSelectList ( WidgetContentExtendMapping::class, 'getWidgetContentList', $widgetContentExtendVo );
	}
}