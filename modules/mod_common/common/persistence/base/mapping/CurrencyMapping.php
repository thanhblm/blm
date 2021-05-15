<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CurrencyVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CurrencyMapping {
	final public function selectByKey(CurrencyVo $currencyVo) {
		try {
			$query = "select * from `currency` where (`code` = #{code}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CurrencyVo $currencyVo = null) {
		try {
			$query = "select * from `currency`";
			$queryBuilder = new QueryBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CurrencyVo $currencyVo) {
		try {
			$query = "select * from `currency`";
			$queryBuilder = new QueryBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`symbol`", "symbol")
				->appendCondition ( "`placement`", "placement")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`decimal`", "decimal")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CurrencyVo $currencyVo = null) {
		try {
			$query = "select count(*) from `currency`";
			$queryBuilder = new QueryBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`symbol`", "symbol")
				->appendCondition ( "`placement`", "placement")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`decimal`", "decimal")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CurrencyVo $currencyVo) {
		try {
			$query = "insert into `currency`";
			$queryBuilder = new InsertBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`symbol`", "symbol")
				->appendField("`placement`", "placement")
				->appendField("`status`", "status")
				->appendField("`decimal`", "decimal")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`currency`", $queryBuilder->getSql (), CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CurrencyVo $currencyVo) {
		try {
			$query = "insert into `currency`";
			$queryBuilder = new InsertBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`symbol`", "symbol")
				->appendField("`placement`", "placement")
				->appendField("`status`", "status")
				->appendField("`decimal`", "decimal")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`currency`", $queryBuilder->getSql (), CurrencyVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CurrencyVo $currencyVo) {
		try {
			$query = "update `currency`";
			$queryBuilder = new UpdateBuilder ( $currencyVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`symbol`", "symbol")
				->appendField("`placement`", "placement")
				->appendField("`status`", "status")
				->appendField("`decimal`", "decimal")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`currency`", $queryBuilder->getSql (), CurrencyVo::class, "where (`code` = #{code})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CurrencyVo $currencyVo) {
		try {
			$query = "delete from `currency`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`currency`", $query, CurrencyVo::class, "where (`code` = #{code})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}