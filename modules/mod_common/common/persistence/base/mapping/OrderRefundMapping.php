<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderRefundVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderRefundMapping {
	final public function selectByKey(OrderRefundVo $orderRefundVo) {
		try {
			$query = "select * from `order_refund` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderRefundVo $orderRefundVo = null) {
		try {
			$query = "select * from `order_refund`";
			$queryBuilder = new QueryBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderRefundVo $orderRefundVo) {
		try {
			$query = "select * from `order_refund`";
			$queryBuilder = new QueryBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`order_history_id`", "orderHistoryId")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`cr_date`", "crDate")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderRefundVo $orderRefundVo = null) {
		try {
			$query = "select count(*) from `order_refund`";
			$queryBuilder = new QueryBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`order_history_id`", "orderHistoryId")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`cr_date`", "crDate");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderRefundVo $orderRefundVo) {
		try {
			$query = "insert into `order_refund`";
			$queryBuilder = new InsertBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`order_history_id`", "orderHistoryId")
				->appendField("`amount`", "amount")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_refund`", $queryBuilder->getSql (), OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderRefundVo $orderRefundVo) {
		try {
			$query = "insert into `order_refund`";
			$queryBuilder = new InsertBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`order_id`", "orderId")
				->appendField("`order_history_id`", "orderHistoryId")
				->appendField("`amount`", "amount")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_refund`", $queryBuilder->getSql (), OrderRefundVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderRefundVo $orderRefundVo) {
		try {
			$query = "update `order_refund`";
			$queryBuilder = new UpdateBuilder ( $orderRefundVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`order_history_id`", "orderHistoryId")
				->appendField("`amount`", "amount")
				->appendField("`cr_by`", "crBy")
				->appendField("`cr_date`", "crDate");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_refund`", $queryBuilder->getSql (), OrderRefundVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderRefundVo $orderRefundVo) {
		try {
			$query = "delete from `order_refund`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_refund`", $query, OrderRefundVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}