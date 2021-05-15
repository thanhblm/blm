<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AccountTypeVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AccountTypeMapping {
	final public function selectByKey(AccountTypeVo $accountTypeVo) {
		try {
			$query = "select * from `account_type` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AccountTypeVo $accountTypeVo = null) {
		try {
			$query = "select * from `account_type`";
			$queryBuilder = new QueryBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AccountTypeVo $accountTypeVo) {
		try {
			$query = "select * from `account_type`";
			$queryBuilder = new QueryBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AccountTypeVo $accountTypeVo = null) {
		try {
			$query = "select count(*) from `account_type`";
			$queryBuilder = new QueryBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AccountTypeVo $accountTypeVo) {
		try {
			$query = "insert into `account_type`";
			$queryBuilder = new InsertBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`account_type`", $queryBuilder->getSql (), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AccountTypeVo $accountTypeVo) {
		try {
			$query = "insert into `account_type`";
			$queryBuilder = new InsertBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`account_type`", $queryBuilder->getSql (), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AccountTypeVo $accountTypeVo) {
		try {
			$query = "update `account_type`";
			$queryBuilder = new UpdateBuilder ( $accountTypeVo, $query );
			$queryBuilder
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`account_type`", $queryBuilder->getSql (), AccountTypeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AccountTypeVo $accountTypeVo) {
		try {
			$query = "delete from `account_type`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`account_type`", $query, AccountTypeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}