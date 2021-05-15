<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BlogLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BlogLangMapping {
	final public function selectByKey(BlogLangVo $blogLangVo) {
		try {
			$query = "select * from `blog_lang` where (`blog_id` = #{blogId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BlogLangVo $blogLangVo = null) {
		try {
			$query = "select * from `blog_lang`";
			$queryBuilder = new QueryBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BlogLangVo $blogLangVo) {
		try {
			$query = "select * from `blog_lang`";
			$queryBuilder = new QueryBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BlogLangVo $blogLangVo = null) {
		try {
			$query = "select count(*) from `blog_lang`";
			$queryBuilder = new QueryBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BlogLangVo $blogLangVo) {
		try {
			$query = "insert into `blog_lang`";
			$queryBuilder = new InsertBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_lang`", $queryBuilder->getSql (), BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BlogLangVo $blogLangVo) {
		try {
			$query = "insert into `blog_lang`";
			$queryBuilder = new InsertBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_lang`", $queryBuilder->getSql (), BlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BlogLangVo $blogLangVo) {
		try {
			$query = "update `blog_lang`";
			$queryBuilder = new UpdateBuilder ( $blogLangVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`blog_lang`", $queryBuilder->getSql (), BlogLangVo::class, "where (`blog_id` = #{blogId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BlogLangVo $blogLangVo) {
		try {
			$query = "delete from `blog_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_lang`", $query, BlogLangVo::class, "where (`blog_id` = #{blogId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}