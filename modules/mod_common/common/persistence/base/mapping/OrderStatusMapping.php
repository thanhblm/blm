<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderStatusVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderStatusMapping {
	final public function selectByKey(OrderStatusVo $orderStatusVo) {
		try {
			$query = "select * from `order_status` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderStatusVo $orderStatusVo = null) {
		try {
			$query = "select * from `order_status`";
			$queryBuilder = new QueryBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderStatusVo $orderStatusVo) {
		try {
			$query = "select * from `order_status`";
			$queryBuilder = new QueryBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderStatusVo $orderStatusVo = null) {
		try {
			$query = "select count(*) from `order_status`";
			$queryBuilder = new QueryBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderStatusVo $orderStatusVo) {
		try {
			$query = "insert into `order_status`";
			$queryBuilder = new InsertBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_status`", $queryBuilder->getSql (), OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderStatusVo $orderStatusVo) {
		try {
			$query = "insert into `order_status`";
			$queryBuilder = new InsertBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_status`", $queryBuilder->getSql (), OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderStatusVo $orderStatusVo) {
		try {
			$query = "update `order_status`";
			$queryBuilder = new UpdateBuilder ( $orderStatusVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_status`", $queryBuilder->getSql (), OrderStatusVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderStatusVo $orderStatusVo) {
		try {
			$query = "delete from `order_status`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_status`", $query, OrderStatusVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}