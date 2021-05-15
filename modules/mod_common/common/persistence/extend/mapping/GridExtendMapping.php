<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\GridVo;
use common\persistence\extend\vo\WidgetContentExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class GridExtendMapping {
	public function getWidgetContentListOfGrid(GridVo $gridVo) {
		try {
			$query = "
				select 
					wcontent.*, 
					gw.id as grid_widget_id, 
					gw.`status` as grid_widget_status, 
					gw.`order` as grid_widget_order,
					w.`name` as widget_name, 
					w.description as widget_description, 
					w.controller as widget_controller, 
					w.field_check as widget_field_check,
					w.icon as widget_icon, 
					wcat.`id` as widget_cat_id, 
					wcat.`name` as widget_cat_name
				from widget_content as wcontent
				left join grid_widget as gw on gw.widget_content_id = wcontent.id
				left join grid as g on g.id = gw.grid_id
				left join widget as w on w.id = wcontent.widget_id
				left join widget_cat as wcat on wcat.id = w.widget_cat_id
				where g.id = #{id}
				order by gw.`order` asc, gw.id asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteByFilter(GridVo $filter) {
		try {
			$query = "delete from `grid`";
			$queryBuilder = new QueryBuilder( $filter, "" );
			$queryBuilder
				->appendCondition ( "`container_id`", "containerId");
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, GridVo::class, $queryBuilder->getSql() );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}