<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PageLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PageLangMapping {
	final public function selectByKey(PageLangVo $pageLangVo) {
		try {
			$query = "select * from `page_lang` where (`page_id` = #{pageId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PageLangVo $pageLangVo = null) {
		try {
			$query = "select * from `page_lang`";
			$queryBuilder = new QueryBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PageLangVo $pageLangVo) {
		try {
			$query = "select * from `page_lang`";
			$queryBuilder = new QueryBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PageLangVo $pageLangVo = null) {
		try {
			$query = "select count(*) from `page_lang`";
			$queryBuilder = new QueryBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PageLangVo $pageLangVo) {
		try {
			$query = "insert into `page_lang`";
			$queryBuilder = new InsertBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page_lang`", $queryBuilder->getSql (), PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PageLangVo $pageLangVo) {
		try {
			$query = "insert into `page_lang`";
			$queryBuilder = new InsertBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page_lang`", $queryBuilder->getSql (), PageLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PageLangVo $pageLangVo) {
		try {
			$query = "update `page_lang`";
			$queryBuilder = new UpdateBuilder ( $pageLangVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`page_lang`", $queryBuilder->getSql (), PageLangVo::class, "where (`page_id` = #{pageId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PageLangVo $pageLangVo) {
		try {
			$query = "delete from `page_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`page_lang`", $query, PageLangVo::class, "where (`page_id` = #{pageId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}