<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\WidgetContentLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class WidgetContentLangMapping {
	final public function selectByKey(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "select * from `widget_content_lang` where (`widget_content_id` = #{widgetContentId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(WidgetContentLangVo $widgetContentLangVo = null) {
		try {
			$query = "select * from `widget_content_lang`";
			$queryBuilder = new QueryBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "select * from `widget_content_lang`";
			$queryBuilder = new QueryBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendCondition ( "`widget_content_id`", "widgetContentId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`setting`", "setting")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(WidgetContentLangVo $widgetContentLangVo = null) {
		try {
			$query = "select count(*) from `widget_content_lang`";
			$queryBuilder = new QueryBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendCondition ( "`widget_content_id`", "widgetContentId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`setting`", "setting");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "insert into `widget_content_lang`";
			$queryBuilder = new InsertBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendField("`widget_content_id`", "widgetContentId")
				->appendField("`language_code`", "languageCode")
				->appendField("`setting`", "setting");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_content_lang`", $queryBuilder->getSql (), WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "insert into `widget_content_lang`";
			$queryBuilder = new InsertBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendField("`widget_content_id`", "widgetContentId")
				->appendField("`language_code`", "languageCode")
				->appendField("`setting`", "setting");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`widget_content_lang`", $queryBuilder->getSql (), WidgetContentLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "update `widget_content_lang`";
			$queryBuilder = new UpdateBuilder ( $widgetContentLangVo, $query );
			$queryBuilder
				->appendField("`setting`", "setting");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`widget_content_lang`", $queryBuilder->getSql (), WidgetContentLangVo::class, "where (`widget_content_id` = #{widgetContentId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(WidgetContentLangVo $widgetContentLangVo) {
		try {
			$query = "delete from `widget_content_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`widget_content_lang`", $query, WidgetContentLangVo::class, "where (`widget_content_id` = #{widgetContentId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}