<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\WidgetContentVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class WidgetContentMapping {
	final public function selectByKey(WidgetContentVo $widgetContentVo) {
		try {
			$query = "select * from `widget_content` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(WidgetContentVo $widgetContentVo = null) {
		try {
			$query = "select * from `widget_content`";
			$queryBuilder = new QueryBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(WidgetContentVo $widgetContentVo) {
		try {
			$query = "select * from `widget_content`";
			$queryBuilder = new QueryBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`widget_id`", "widgetId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`style`", "style")
				->appendCondition ( "`setting`", "setting")
				->appendCondition ( "`public`", "public")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(WidgetContentVo $widgetContentVo = null) {
		try {
			$query = "select count(*) from `widget_content`";
			$queryBuilder = new QueryBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`widget_id`", "widgetId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`style`", "style")
				->appendCondition ( "`setting`", "setting")
				->appendCondition ( "`public`", "public");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(WidgetContentVo $widgetContentVo) {
		try {
			$query = "insert into `widget_content`";
			$queryBuilder = new InsertBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendField("`widget_id`", "widgetId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`setting`", "setting")
				->appendField("`public`", "public");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_content`", $queryBuilder->getSql (), WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(WidgetContentVo $widgetContentVo) {
		try {
			$query = "insert into `widget_content`";
			$queryBuilder = new InsertBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`widget_id`", "widgetId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`setting`", "setting")
				->appendField("`public`", "public");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_content`", $queryBuilder->getSql (), WidgetContentVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(WidgetContentVo $widgetContentVo) {
		try {
			$query = "update `widget_content`";
			$queryBuilder = new UpdateBuilder ( $widgetContentVo, $query );
			$queryBuilder
				->appendField("`widget_id`", "widgetId")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`setting`", "setting")
				->appendField("`public`", "public");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`widget_content`", $queryBuilder->getSql (), WidgetContentVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(WidgetContentVo $widgetContentVo) {
		try {
			$query = "delete from `widget_content`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`widget_content`", $query, WidgetContentVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}