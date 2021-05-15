<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\LanguageValueVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class LanguageValueMapping {
	final public function selectByKey(LanguageValueVo $languageValueVo) {
		try {
			$query = "select * from `language_value` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(LanguageValueVo $languageValueVo = null) {
		try {
			$query = "select * from `language_value`";
			$queryBuilder = new QueryBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(LanguageValueVo $languageValueVo) {
		try {
			$query = "select * from `language_value`";
			$queryBuilder = new QueryBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`key`", "key")
				->appendCondition ( "`original`", "original")
				->appendCondition ( "`destination`", "destination")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(LanguageValueVo $languageValueVo = null) {
		try {
			$query = "select count(*) from `language_value`";
			$queryBuilder = new QueryBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`key`", "key")
				->appendCondition ( "`original`", "original")
				->appendCondition ( "`destination`", "destination")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(LanguageValueVo $languageValueVo) {
		try {
			$query = "insert into `language_value`";
			$queryBuilder = new InsertBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendField("`key`", "key")
				->appendField("`original`", "original")
				->appendField("`destination`", "destination")
				->appendField("`language_code`", "languageCode")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`language_value`", $queryBuilder->getSql (), LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(LanguageValueVo $languageValueVo) {
		try {
			$query = "insert into `language_value`";
			$queryBuilder = new InsertBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`key`", "key")
				->appendField("`original`", "original")
				->appendField("`destination`", "destination")
				->appendField("`language_code`", "languageCode")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`language_value`", $queryBuilder->getSql (), LanguageValueVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(LanguageValueVo $languageValueVo) {
		try {
			$query = "update `language_value`";
			$queryBuilder = new UpdateBuilder ( $languageValueVo, $query );
			$queryBuilder
				->appendField("`key`", "key")
				->appendField("`original`", "original")
				->appendField("`destination`", "destination")
				->appendField("`language_code`", "languageCode")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`language_value`", $queryBuilder->getSql (), LanguageValueVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(LanguageValueVo $languageValueVo) {
		try {
			$query = "delete from `language_value`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`language_value`", $query, LanguageValueVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}