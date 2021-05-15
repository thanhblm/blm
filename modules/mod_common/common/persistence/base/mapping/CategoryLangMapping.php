<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CategoryLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CategoryLangMapping {
	final public function selectByKey(CategoryLangVo $categoryLangVo) {
		try {
			$query = "select * from `category_lang` where (`category_id` = #{categoryId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CategoryLangVo $categoryLangVo = null) {
		try {
			$query = "select * from `category_lang`";
			$queryBuilder = new QueryBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CategoryLangVo $categoryLangVo) {
		try {
			$query = "select * from `category_lang`";
			$queryBuilder = new QueryBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CategoryLangVo $categoryLangVo = null) {
		try {
			$query = "select count(*) from `category_lang`";
			$queryBuilder = new QueryBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CategoryLangVo $categoryLangVo) {
		try {
			$query = "insert into `category_lang`";
			$queryBuilder = new InsertBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendField("`category_id`", "categoryId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_lang`", $queryBuilder->getSql (), CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CategoryLangVo $categoryLangVo) {
		try {
			$query = "insert into `category_lang`";
			$queryBuilder = new InsertBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendField("`category_id`", "categoryId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_lang`", $queryBuilder->getSql (), CategoryLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CategoryLangVo $categoryLangVo) {
		try {
			$query = "update `category_lang`";
			$queryBuilder = new UpdateBuilder ( $categoryLangVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`category_lang`", $queryBuilder->getSql (), CategoryLangVo::class, "where (`category_id` = #{categoryId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CategoryLangVo $categoryLangVo) {
		try {
			$query = "delete from `category_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`category_lang`", $query, CategoryLangVo::class, "where (`category_id` = #{categoryId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}