<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CustomerChangePasswordVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CustomerChangePasswordMapping {
	final public function selectByKey(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "select * from `customer_change_password` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		try {
			$query = "select * from `customer_change_password`";
			$queryBuilder = new QueryBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "select * from `customer_change_password`";
			$queryBuilder = new QueryBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`customer_id`", "customerId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CustomerChangePasswordVo $customerChangePasswordVo = null) {
		try {
			$query = "select count(*) from `customer_change_password`";
			$queryBuilder = new QueryBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`customer_id`", "customerId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "insert into `customer_change_password`";
			$queryBuilder = new InsertBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`customer_id`", "customerId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer_change_password`", $queryBuilder->getSql (), CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "insert into `customer_change_password`";
			$queryBuilder = new InsertBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`code`", "code")
				->appendField("`customer_id`", "customerId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer_change_password`", $queryBuilder->getSql (), CustomerChangePasswordVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "update `customer_change_password`";
			$queryBuilder = new UpdateBuilder ( $customerChangePasswordVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`customer_id`", "customerId");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`customer_change_password`", $queryBuilder->getSql (), CustomerChangePasswordVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CustomerChangePasswordVo $customerChangePasswordVo) {
		try {
			$query = "delete from `customer_change_password`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`customer_change_password`", $query, CustomerChangePasswordVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}