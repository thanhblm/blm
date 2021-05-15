<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\LanguageVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class LanguageMapping {
	final public function selectByKey(LanguageVo $languageVo) {
		try {
			$query = "select * from `language` where (`code` = #{code}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(LanguageVo $languageVo = null) {
		try {
			$query = "select * from `language`";
			$queryBuilder = new QueryBuilder ( $languageVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(LanguageVo $languageVo) {
		try {
			$query = "select * from `language`";
			$queryBuilder = new QueryBuilder ( $languageVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`locale_name`", "localeName")
				->appendCondition ( "`flag`", "flag")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(LanguageVo $languageVo = null) {
		try {
			$query = "select count(*) from `language`";
			$queryBuilder = new QueryBuilder ( $languageVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`locale_name`", "localeName")
				->appendCondition ( "`flag`", "flag")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(LanguageVo $languageVo) {
		try {
			$query = "insert into `language`";
			$queryBuilder = new InsertBuilder ( $languageVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`locale_name`", "localeName")
				->appendField("`flag`", "flag")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`language`", $queryBuilder->getSql (), LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(LanguageVo $languageVo) {
		try {
			$query = "insert into `language`";
			$queryBuilder = new InsertBuilder ( $languageVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`locale_name`", "localeName")
				->appendField("`flag`", "flag")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`language`", $queryBuilder->getSql (), LanguageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(LanguageVo $languageVo) {
		try {
			$query = "update `language`";
			$queryBuilder = new UpdateBuilder ( $languageVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`locale_name`", "localeName")
				->appendField("`flag`", "flag")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`language`", $queryBuilder->getSql (), LanguageVo::class, "where (`code` = #{code})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(LanguageVo $languageVo) {
		try {
			$query = "delete from `language`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`language`", $query, LanguageVo::class, "where (`code` = #{code})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}