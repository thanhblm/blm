<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PaymentMethodVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PaymentMethodMapping {
	final public function selectByKey(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "select * from `payment_method` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PaymentMethodVo $paymentMethodVo = null) {
		try {
			$query = "select * from `payment_method`";
			$queryBuilder = new QueryBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "select * from `payment_method`";
			$queryBuilder = new QueryBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PaymentMethodVo $paymentMethodVo = null) {
		try {
			$query = "select count(*) from `payment_method`";
			$queryBuilder = new QueryBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "insert into `payment_method`";
			$queryBuilder = new InsertBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`payment_method`", $queryBuilder->getSql (), PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "insert into `payment_method`";
			$queryBuilder = new InsertBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`payment_method`", $queryBuilder->getSql (), PaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "update `payment_method`";
			$queryBuilder = new UpdateBuilder ( $paymentMethodVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`payment_method`", $queryBuilder->getSql (), PaymentMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PaymentMethodVo $paymentMethodVo) {
		try {
			$query = "delete from `payment_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`payment_method`", $query, PaymentMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}