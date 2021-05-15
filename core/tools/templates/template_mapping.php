<?php

namespace __MODULE_NAME__\persistence\base\mapping;

use __MODULE_NAME__\persistence\base\vo\__CLASS_NAME__Vo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class __CLASS_NAME__Mapping {
	final public function selectByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "select * from __TABLE_NAME__ where __KEY_CONDITION__ limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		try {
			$query = "select * from __TABLE_NAME__";
			$queryBuilder = new QueryBuilder ( $__PARAM_NAME__Vo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "select * from __TABLE_NAME__";
			$queryBuilder = new QueryBuilder ( $__PARAM_NAME__Vo, $query );
			__SELECT_CONDITION__;
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		try {
			$query = "select count(*) from __TABLE_NAME__";
			$queryBuilder = new QueryBuilder ( $__PARAM_NAME__Vo, $query );
			__COUNT_CONDITION__;
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "insert into __TABLE_NAME__";
			$queryBuilder = new InsertBuilder ( $__PARAM_NAME__Vo, $query );
			__INSERT_CLAUSE__;
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "__TABLE_NAME__", $queryBuilder->getSql (), __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "insert into __TABLE_NAME__";
			$queryBuilder = new InsertBuilder ( $__PARAM_NAME__Vo, $query );
			__INSERT_CLAUSE_WITH_ID__;
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "__TABLE_NAME__", $queryBuilder->getSql (), __CLASS_NAME__Vo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "update __TABLE_NAME__";
			$queryBuilder = new UpdateBuilder ( $__PARAM_NAME__Vo, $query );
			__UPDATE_CLAUSE__;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "__TABLE_NAME__", $queryBuilder->getSql (), __CLASS_NAME__Vo::class, "where __KEY_CONDITION__" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo) {
		try {
			$query = "delete from __TABLE_NAME__";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "__TABLE_NAME__", $query, __CLASS_NAME__Vo::class, "where __KEY_CONDITION__" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}