<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CustomerTypeVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CustomerTypeMapping {
	final public function selectByKey(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "select * from `customer_type` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CustomerTypeVo $customerTypeVo = null) {
		try {
			$query = "select * from `customer_type`";
			$queryBuilder = new QueryBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "select * from `customer_type`";
			$queryBuilder = new QueryBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CustomerTypeVo $customerTypeVo = null) {
		try {
			$query = "select count(*) from `customer_type`";
			$queryBuilder = new QueryBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "insert into `customer_type`";
			$queryBuilder = new InsertBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer_type`", $queryBuilder->getSql (), CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "insert into `customer_type`";
			$queryBuilder = new InsertBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer_type`", $queryBuilder->getSql (), CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "update `customer_type`";
			$queryBuilder = new UpdateBuilder ( $customerTypeVo, $query );
			$queryBuilder
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`customer_type`", $queryBuilder->getSql (), CustomerTypeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "delete from `customer_type`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`customer_type`", $query, CustomerTypeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}