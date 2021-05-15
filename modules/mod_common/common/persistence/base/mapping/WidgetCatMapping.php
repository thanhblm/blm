<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\WidgetCatVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class WidgetCatMapping {
	final public function selectByKey(WidgetCatVo $widgetCatVo) {
		try {
			$query = "select * from `widget_cat` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(WidgetCatVo $widgetCatVo = null) {
		try {
			$query = "select * from `widget_cat`";
			$queryBuilder = new QueryBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(WidgetCatVo $widgetCatVo) {
		try {
			$query = "select * from `widget_cat`";
			$queryBuilder = new QueryBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(WidgetCatVo $widgetCatVo = null) {
		try {
			$query = "select count(*) from `widget_cat`";
			$queryBuilder = new QueryBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(WidgetCatVo $widgetCatVo) {
		try {
			$query = "insert into `widget_cat`";
			$queryBuilder = new InsertBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_cat`", $queryBuilder->getSql (), WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(WidgetCatVo $widgetCatVo) {
		try {
			$query = "insert into `widget_cat`";
			$queryBuilder = new InsertBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_cat`", $queryBuilder->getSql (), WidgetCatVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(WidgetCatVo $widgetCatVo) {
		try {
			$query = "update `widget_cat`";
			$queryBuilder = new UpdateBuilder ( $widgetCatVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`widget_cat`", $queryBuilder->getSql (), WidgetCatVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(WidgetCatVo $widgetCatVo) {
		try {
			$query = "delete from `widget_cat`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`widget_cat`", $query, WidgetCatVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}