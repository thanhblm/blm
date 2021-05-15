<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PageCacheVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PageCacheMapping {
	final public function selectByKey(PageCacheVo $pageCacheVo) {
		try {
			$query = "select * from `page_cache` where (`page_id` = #{pageId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PageCacheVo $pageCacheVo = null) {
		try {
			$query = "select * from `page_cache`";
			$queryBuilder = new QueryBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PageCacheVo $pageCacheVo) {
		try {
			$query = "select * from `page_cache`";
			$queryBuilder = new QueryBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`data`", "data")
				->appendCondition ( "`md_date`", "mdDate")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PageCacheVo $pageCacheVo = null) {
		try {
			$query = "select count(*) from `page_cache`";
			$queryBuilder = new QueryBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`data`", "data")
				->appendCondition ( "`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PageCacheVo $pageCacheVo) {
		try {
			$query = "insert into `page_cache`";
			$queryBuilder = new InsertBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`language_code`", "languageCode")
				->appendField("`data`", "data")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page_cache`", $queryBuilder->getSql (), PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PageCacheVo $pageCacheVo) {
		try {
			$query = "insert into `page_cache`";
			$queryBuilder = new InsertBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`language_code`", "languageCode")
				->appendField("`data`", "data")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page_cache`", $queryBuilder->getSql (), PageCacheVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PageCacheVo $pageCacheVo) {
		try {
			$query = "update `page_cache`";
			$queryBuilder = new UpdateBuilder ( $pageCacheVo, $query );
			$queryBuilder
				->appendField("`data`", "data")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`page_cache`", $queryBuilder->getSql (), PageCacheVo::class, "where (`page_id` = #{pageId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PageCacheVo $pageCacheVo) {
		try {
			$query = "delete from `page_cache`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`page_cache`", $query, PageCacheVo::class, "where (`page_id` = #{pageId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}