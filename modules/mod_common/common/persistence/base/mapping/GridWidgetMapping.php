<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\GridWidgetVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class GridWidgetMapping {
	final public function selectByKey(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "select * from `grid_widget` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(GridWidgetVo $gridWidgetVo = null) {
		try {
			$query = "select * from `grid_widget`";
			$queryBuilder = new QueryBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "select * from `grid_widget`";
			$queryBuilder = new QueryBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`grid_id`", "gridId")
				->appendCondition ( "`widget_content_id`", "widgetContentId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order`", "order")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(GridWidgetVo $gridWidgetVo = null) {
		try {
			$query = "select count(*) from `grid_widget`";
			$queryBuilder = new QueryBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`grid_id`", "gridId")
				->appendCondition ( "`widget_content_id`", "widgetContentId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "insert into `grid_widget`";
			$queryBuilder = new InsertBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendField("`grid_id`", "gridId")
				->appendField("`widget_content_id`", "widgetContentId")
				->appendField("`status`", "status")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`grid_widget`", $queryBuilder->getSql (), GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "insert into `grid_widget`";
			$queryBuilder = new InsertBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`grid_id`", "gridId")
				->appendField("`widget_content_id`", "widgetContentId")
				->appendField("`status`", "status")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`grid_widget`", $queryBuilder->getSql (), GridWidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "update `grid_widget`";
			$queryBuilder = new UpdateBuilder ( $gridWidgetVo, $query );
			$queryBuilder
				->appendField("`grid_id`", "gridId")
				->appendField("`widget_content_id`", "widgetContentId")
				->appendField("`status`", "status")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`grid_widget`", $queryBuilder->getSql (), GridWidgetVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(GridWidgetVo $gridWidgetVo) {
		try {
			$query = "delete from `grid_widget`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`grid_widget`", $query, GridWidgetVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}