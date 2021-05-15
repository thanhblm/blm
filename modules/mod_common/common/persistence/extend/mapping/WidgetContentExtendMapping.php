<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\WidgetContentExtendVo;
use core\database\SqlStatementInfo;

class WidgetContentExtendMapping {
	public function getWidgetContentInfo(WidgetContentExtendVo $widgetContentExtendVo) {
		try {
			$query = "
				select 
					wcontent.*,
					w.`name` as widget_name, 
					w.description as widget_description, 
					w.controller as widget_controller, 
					w.icon as widget_icon, 
					wcat.`id` as widget_cat_id, 
					wcat.`name` as widget_cat_name
				from widget_content as wcontent
				left join widget as w on w.id = wcontent.widget_id
				left join widget_cat as wcat on wcat.id = w.widget_cat_id
				where wcontent.id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getWidgetContentList(WidgetContentExtendVo $widgetContentExtendVo = null) {
		try {
			$query = "
				select 
					wcontent.*, 
					w.`name` as widget_name, 
					w.description as widget_description, 
					w.controller as widget_controller, 
					w.icon as widget_icon, 
					wcat.`id` as widget_cat_id, 
					wcat.`name` as widget_cat_name
				from widget_content as wcontent
				left join widget as w on w.id = wcontent.widget_id
				left join widget_cat as wcat on wcat.id = w.widget_cat_id
				order by wcat.id asc, w.id asc, wcontent.`name` asc, wcontent.id asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}