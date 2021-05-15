<?php

namespace common\persistence\extend\mapping;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\GridWidgetVo;
use core\database\QueryBuilder;

class GridWidgetExtendMapping {
	public function deleteByFilter(GridWidgetVo $filter) {
		try {
			$query = "delete from `grid_widget`";
			$queryBuilder = new QueryBuilder( $filter, "" );
			$queryBuilder
				->appendCondition ( "`grid_id`", "gridId")
				->appendCondition ( "`widget_content_id`", "widgetContentId");
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, GridWidgetVo::class, $queryBuilder->getSql() );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}