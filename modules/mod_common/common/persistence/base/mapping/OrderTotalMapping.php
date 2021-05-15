<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderTotalVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderTotalMapping {
	final public function selectByKey(OrderTotalVo $orderTotalVo) {
		try {
			$query = "select * from `order_total` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderTotalVo $orderTotalVo = null) {
		try {
			$query = "select * from `order_total`";
			$queryBuilder = new QueryBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderTotalVo $orderTotalVo) {
		try {
			$query = "select * from `order_total`";
			$queryBuilder = new QueryBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`subtitle`", "subtitle")
				->appendCondition ( "`value`", "value")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderTotalVo $orderTotalVo = null) {
		try {
			$query = "select count(*) from `order_total`";
			$queryBuilder = new QueryBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`subtitle`", "subtitle")
				->appendCondition ( "`value`", "value");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderTotalVo $orderTotalVo) {
		try {
			$query = "insert into `order_total`";
			$queryBuilder = new InsertBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`type`", "type")
				->appendField("`title`", "title")
				->appendField("`subtitle`", "subtitle")
				->appendField("`value`", "value");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_total`", $queryBuilder->getSql (), OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderTotalVo $orderTotalVo) {
		try {
			$query = "insert into `order_total`";
			$queryBuilder = new InsertBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`order_id`", "orderId")
				->appendField("`type`", "type")
				->appendField("`title`", "title")
				->appendField("`subtitle`", "subtitle")
				->appendField("`value`", "value");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_total`", $queryBuilder->getSql (), OrderTotalVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderTotalVo $orderTotalVo) {
		try {
			$query = "update `order_total`";
			$queryBuilder = new UpdateBuilder ( $orderTotalVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`type`", "type")
				->appendField("`title`", "title")
				->appendField("`subtitle`", "subtitle")
				->appendField("`value`", "value");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_total`", $queryBuilder->getSql (), OrderTotalVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderTotalVo $orderTotalVo) {
		try {
			$query = "delete from `order_total`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_total`", $query, OrderTotalVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}