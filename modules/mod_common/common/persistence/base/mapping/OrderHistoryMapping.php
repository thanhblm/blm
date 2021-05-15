<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderHistoryVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderHistoryMapping {
	final public function selectByKey(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "select * from `order_history` where (`id` = #{id}) and (`cr_date` = #{crDate}) and (`cr_by` = #{crBy}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderHistoryVo $orderHistoryVo = null) {
		try {
			$query = "select * from `order_history`";
			$queryBuilder = new QueryBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "select * from `order_history`";
			$queryBuilder = new QueryBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cus_notified`", "cusNotified")
				->appendCondition ( "`detail`", "detail")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderHistoryVo $orderHistoryVo = null) {
		try {
			$query = "select count(*) from `order_history`";
			$queryBuilder = new QueryBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cus_notified`", "cusNotified")
				->appendCondition ( "`detail`", "detail")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "insert into `order_history`";
			$queryBuilder = new InsertBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`cus_notified`", "cusNotified")
				->appendField("`detail`", "detail")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_history`", $queryBuilder->getSql (), OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "insert into `order_history`";
			$queryBuilder = new InsertBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`cus_notified`", "cusNotified")
				->appendField("`detail`", "detail")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_history`", $queryBuilder->getSql (), OrderHistoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "update `order_history`";
			$queryBuilder = new UpdateBuilder ( $orderHistoryVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`cus_notified`", "cusNotified")
				->appendField("`detail`", "detail");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_history`", $queryBuilder->getSql (), OrderHistoryVo::class, "where (`id` = #{id}) and (`cr_date` = #{crDate}) and (`cr_by` = #{crBy})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderHistoryVo $orderHistoryVo) {
		try {
			$query = "delete from `order_history`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_history`", $query, OrderHistoryVo::class, "where (`id` = #{id}) and (`cr_date` = #{crDate}) and (`cr_by` = #{crBy})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}