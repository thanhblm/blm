<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SeoInfoLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SeoInfoLangMapping {
	final public function selectByKey(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "select * from `seo_info_lang` where (`item_id` = #{itemId}) and (`type` = #{type}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SeoInfoLangVo $seoInfoLangVo = null) {
		try {
			$query = "select * from `seo_info_lang`";
			$queryBuilder = new QueryBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "select * from `seo_info_lang`";
			$queryBuilder = new QueryBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendCondition ( "`item_id`", "itemId")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`url`", "url")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`keywords`", "keywords")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SeoInfoLangVo $seoInfoLangVo = null) {
		try {
			$query = "select count(*) from `seo_info_lang`";
			$queryBuilder = new QueryBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendCondition ( "`item_id`", "itemId")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`url`", "url")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`keywords`", "keywords")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "insert into `seo_info_lang`";
			$queryBuilder = new InsertBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendField("`item_id`", "itemId")
				->appendField("`type`", "type")
				->appendField("`language_code`", "languageCode")
				->appendField("`url`", "url")
				->appendField("`title`", "title")
				->appendField("`keywords`", "keywords")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`seo_info_lang`", $queryBuilder->getSql (), SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "insert into `seo_info_lang`";
			$queryBuilder = new InsertBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendField("`item_id`", "itemId")
				->appendField("`type`", "type")
				->appendField("`language_code`", "languageCode")
				->appendField("`url`", "url")
				->appendField("`title`", "title")
				->appendField("`keywords`", "keywords")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`seo_info_lang`", $queryBuilder->getSql (), SeoInfoLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "update `seo_info_lang`";
			$queryBuilder = new UpdateBuilder ( $seoInfoLangVo, $query );
			$queryBuilder
				->appendField("`url`", "url")
				->appendField("`title`", "title")
				->appendField("`keywords`", "keywords")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`seo_info_lang`", $queryBuilder->getSql (), SeoInfoLangVo::class, "where (`item_id` = #{itemId}) and (`type` = #{type}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SeoInfoLangVo $seoInfoLangVo) {
		try {
			$query = "delete from `seo_info_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`seo_info_lang`", $query, SeoInfoLangVo::class, "where (`item_id` = #{itemId}) and (`type` = #{type}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}