<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderShipingInfoVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderShipingInfoMapping {
	final public function selectByKey(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "select * from `order_shiping_info` where (`order_id` = #{orderId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderShipingInfoVo $orderShipingInfoVo = null) {
		try {
			$query = "select * from `order_shiping_info`";
			$queryBuilder = new QueryBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "select * from `order_shiping_info`";
			$queryBuilder = new QueryBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`ship_by`", "shipBy")
				->appendCondition ( "`ship_date`", "shipDate")
				->appendCondition ( "`tracking_code`", "trackingCode")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderShipingInfoVo $orderShipingInfoVo = null) {
		try {
			$query = "select count(*) from `order_shiping_info`";
			$queryBuilder = new QueryBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`ship_by`", "shipBy")
				->appendCondition ( "`ship_date`", "shipDate")
				->appendCondition ( "`tracking_code`", "trackingCode");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "insert into `order_shiping_info`";
			$queryBuilder = new InsertBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`ship_by`", "shipBy")
				->appendField("`ship_date`", "shipDate")
				->appendField("`tracking_code`", "trackingCode");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_shiping_info`", $queryBuilder->getSql (), OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "insert into `order_shiping_info`";
			$queryBuilder = new InsertBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`ship_by`", "shipBy")
				->appendField("`ship_date`", "shipDate")
				->appendField("`tracking_code`", "trackingCode");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_shiping_info`", $queryBuilder->getSql (), OrderShipingInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "update `order_shiping_info`";
			$queryBuilder = new UpdateBuilder ( $orderShipingInfoVo, $query );
			$queryBuilder
				->appendField("`ship_by`", "shipBy")
				->appendField("`ship_date`", "shipDate")
				->appendField("`tracking_code`", "trackingCode");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_shiping_info`", $queryBuilder->getSql (), OrderShipingInfoVo::class, "where (`order_id` = #{orderId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderShipingInfoVo $orderShipingInfoVo) {
		try {
			$query = "delete from `order_shiping_info`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_shiping_info`", $query, OrderShipingInfoVo::class, "where (`order_id` = #{orderId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}