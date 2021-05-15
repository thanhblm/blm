<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ShippingMethodVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ShippingMethodMapping {
	final public function selectByKey(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "select * from `shipping_method` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ShippingMethodVo $shippingMethodVo = null) {
		try {
			$query = "select * from `shipping_method`";
			$queryBuilder = new QueryBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "select * from `shipping_method`";
			$queryBuilder = new QueryBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ShippingMethodVo $shippingMethodVo = null) {
		try {
			$query = "select count(*) from `shipping_method`";
			$queryBuilder = new QueryBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "insert into `shipping_method`";
			$queryBuilder = new InsertBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`shipping_method`", $queryBuilder->getSql (), ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "insert into `shipping_method`";
			$queryBuilder = new InsertBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`shipping_method`", $queryBuilder->getSql (), ShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "update `shipping_method`";
			$queryBuilder = new UpdateBuilder ( $shippingMethodVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`shipping_method`", $queryBuilder->getSql (), ShippingMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ShippingMethodVo $shippingMethodVo) {
		try {
			$query = "delete from `shipping_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`shipping_method`", $query, ShippingMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}