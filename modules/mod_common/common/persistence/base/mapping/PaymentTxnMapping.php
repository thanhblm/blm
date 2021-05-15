<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PaymentTxnVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PaymentTxnMapping {
	final public function selectByKey(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "select * from `payment_txn` where (`cart_info_id` = #{cartInfoId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PaymentTxnVo $paymentTxnVo = null) {
		try {
			$query = "select * from `payment_txn`";
			$queryBuilder = new QueryBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "select * from `payment_txn`";
			$queryBuilder = new QueryBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendCondition ( "`cart_info_id`", "cartInfoId")
				->appendCondition ( "`txn_id`", "txnId")
				->appendCondition ( "`payment_method_id`", "paymentMethodId")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`remark`", "remark")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PaymentTxnVo $paymentTxnVo = null) {
		try {
			$query = "select count(*) from `payment_txn`";
			$queryBuilder = new QueryBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendCondition ( "`cart_info_id`", "cartInfoId")
				->appendCondition ( "`txn_id`", "txnId")
				->appendCondition ( "`payment_method_id`", "paymentMethodId")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`remark`", "remark")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "insert into `payment_txn`";
			$queryBuilder = new InsertBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendField("`cart_info_id`", "cartInfoId")
				->appendField("`txn_id`", "txnId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`amount`", "amount")
				->appendField("`remark`", "remark")
				->appendField("`description`", "description")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`payment_txn`", $queryBuilder->getSql (), PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "insert into `payment_txn`";
			$queryBuilder = new InsertBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendField("`cart_info_id`", "cartInfoId")
				->appendField("`txn_id`", "txnId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`amount`", "amount")
				->appendField("`remark`", "remark")
				->appendField("`description`", "description")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`payment_txn`", $queryBuilder->getSql (), PaymentTxnVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "update `payment_txn`";
			$queryBuilder = new UpdateBuilder ( $paymentTxnVo, $query );
			$queryBuilder
				->appendField("`txn_id`", "txnId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`amount`", "amount")
				->appendField("`remark`", "remark")
				->appendField("`description`", "description")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`md_date`", "mdDate");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`payment_txn`", $queryBuilder->getSql (), PaymentTxnVo::class, "where (`cart_info_id` = #{cartInfoId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PaymentTxnVo $paymentTxnVo) {
		try {
			$query = "delete from `payment_txn`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`payment_txn`", $query, PaymentTxnVo::class, "where (`cart_info_id` = #{cartInfoId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}