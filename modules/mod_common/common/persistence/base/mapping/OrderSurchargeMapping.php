<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderSurchargeVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderSurchargeMapping {
	final public function selectByKey(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "select * from `order_surcharge` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderSurchargeVo $orderSurchargeVo = null) {
		try {
			$query = "select * from `order_surcharge`";
			$queryBuilder = new QueryBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "select * from `order_surcharge`";
			$queryBuilder = new QueryBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`surcharge_id`", "surchargeId")
				->appendCondition ( "`surcharge_type`", "surchargeType")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`data`", "data")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderSurchargeVo $orderSurchargeVo = null) {
		try {
			$query = "select count(*) from `order_surcharge`";
			$queryBuilder = new QueryBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`surcharge_id`", "surchargeId")
				->appendCondition ( "`surcharge_type`", "surchargeType")
				->appendCondition ( "`amount`", "amount")
				->appendCondition ( "`data`", "data");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "insert into `order_surcharge`";
			$queryBuilder = new InsertBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`surcharge_id`", "surchargeId")
				->appendField("`surcharge_type`", "surchargeType")
				->appendField("`amount`", "amount")
				->appendField("`data`", "data");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_surcharge`", $queryBuilder->getSql (), OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "insert into `order_surcharge`";
			$queryBuilder = new InsertBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`order_id`", "orderId")
				->appendField("`surcharge_id`", "surchargeId")
				->appendField("`surcharge_type`", "surchargeType")
				->appendField("`amount`", "amount")
				->appendField("`data`", "data");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_surcharge`", $queryBuilder->getSql (), OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "update `order_surcharge`";
			$queryBuilder = new UpdateBuilder ( $orderSurchargeVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`surcharge_id`", "surchargeId")
				->appendField("`surcharge_type`", "surchargeType")
				->appendField("`amount`", "amount")
				->appendField("`data`", "data");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_surcharge`", $queryBuilder->getSql (), OrderSurchargeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderSurchargeVo $orderSurchargeVo) {
		try {
			$query = "delete from `order_surcharge`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_surcharge`", $query, OrderSurchargeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}