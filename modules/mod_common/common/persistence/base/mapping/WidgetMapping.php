<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\WidgetVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class WidgetMapping {
	final public function selectByKey(WidgetVo $widgetVo) {
		try {
			$query = "select * from `widget` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(WidgetVo $widgetVo = null) {
		try {
			$query = "select * from `widget`";
			$queryBuilder = new QueryBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(WidgetVo $widgetVo) {
		try {
			$query = "select * from `widget`";
			$queryBuilder = new QueryBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`widget_cat_id`", "widgetCatId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`controller`", "controller")
				->appendCondition ( "`icon`", "icon")
				->appendCondition ( "`field_check`", "fieldCheck")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(WidgetVo $widgetVo = null) {
		try {
			$query = "select count(*) from `widget`";
			$queryBuilder = new QueryBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`widget_cat_id`", "widgetCatId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`controller`", "controller")
				->appendCondition ( "`icon`", "icon")
				->appendCondition ( "`field_check`", "fieldCheck");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(WidgetVo $widgetVo) {
		try {
			$query = "insert into `widget`";
			$queryBuilder = new InsertBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendField("`widget_cat_id`", "widgetCatId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`controller`", "controller")
				->appendField("`icon`", "icon")
				->appendField("`field_check`", "fieldCheck");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget`", $queryBuilder->getSql (), WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(WidgetVo $widgetVo) {
		try {
			$query = "insert into `widget`";
			$queryBuilder = new InsertBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`widget_cat_id`", "widgetCatId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`controller`", "controller")
				->appendField("`icon`", "icon")
				->appendField("`field_check`", "fieldCheck");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget`", $queryBuilder->getSql (), WidgetVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(WidgetVo $widgetVo) {
		try {
			$query = "update `widget`";
			$queryBuilder = new UpdateBuilder ( $widgetVo, $query );
			$queryBuilder
				->appendField("`widget_cat_id`", "widgetCatId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`controller`", "controller")
				->appendField("`icon`", "icon")
				->appendField("`field_check`", "fieldCheck");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`widget`", $queryBuilder->getSql (), WidgetVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(WidgetVo $widgetVo) {
		try {
			$query = "delete from `widget`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`widget`", $query, WidgetVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}