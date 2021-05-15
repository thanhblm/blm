<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CategoryBlogLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CategoryBlogLangMapping {
	final public function selectByKey(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "select * from `category_blog_lang` where (`category_blog_id` = #{categoryBlogId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CategoryBlogLangVo $categoryBlogLangVo = null) {
		try {
			$query = "select * from `category_blog_lang`";
			$queryBuilder = new QueryBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "select * from `category_blog_lang`";
			$queryBuilder = new QueryBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendCondition ( "`category_blog_id`", "categoryBlogId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CategoryBlogLangVo $categoryBlogLangVo = null) {
		try {
			$query = "select count(*) from `category_blog_lang`";
			$queryBuilder = new QueryBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendCondition ( "`category_blog_id`", "categoryBlogId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "insert into `category_blog_lang`";
			$queryBuilder = new InsertBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendField("`category_blog_id`", "categoryBlogId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_blog_lang`", $queryBuilder->getSql (), CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "insert into `category_blog_lang`";
			$queryBuilder = new InsertBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendField("`category_blog_id`", "categoryBlogId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_blog_lang`", $queryBuilder->getSql (), CategoryBlogLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "update `category_blog_lang`";
			$queryBuilder = new UpdateBuilder ( $categoryBlogLangVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`category_blog_lang`", $queryBuilder->getSql (), CategoryBlogLangVo::class, "where (`category_blog_id` = #{categoryBlogId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CategoryBlogLangVo $categoryBlogLangVo) {
		try {
			$query = "delete from `category_blog_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`category_blog_lang`", $query, CategoryBlogLangVo::class, "where (`category_blog_id` = #{categoryBlogId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}