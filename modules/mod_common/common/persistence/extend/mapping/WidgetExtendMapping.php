<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\WidgetExtendVo;
use core\database\SqlStatementInfo;

class WidgetExtendMapping {
	public function getWidgetList(WidgetExtendVo $widgetExtendVo = null) {
		try {
			$query = "
				select 
					w.*, 
					wcat.`name` as widget_cat_name, 
					wcat.`description` as widget_cat_description
				from widget as w
				left join widget_cat as wcat on wcat.id = w.widget_cat_id";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}