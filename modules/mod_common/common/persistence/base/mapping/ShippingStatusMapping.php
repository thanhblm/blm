<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ShippingStatusVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ShippingStatusMapping {
	final public function selectByKey(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "select * from `shipping_status` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ShippingStatusVo $shippingStatusVo = null) {
		try {
			$query = "select * from `shipping_status`";
			$queryBuilder = new QueryBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "select * from `shipping_status`";
			$queryBuilder = new QueryBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ShippingStatusVo $shippingStatusVo = null) {
		try {
			$query = "select count(*) from `shipping_status`";
			$queryBuilder = new QueryBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "insert into `shipping_status`";
			$queryBuilder = new InsertBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`shipping_status`", $queryBuilder->getSql (), ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "insert into `shipping_status`";
			$queryBuilder = new InsertBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`shipping_status`", $queryBuilder->getSql (), ShippingStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "update `shipping_status`";
			$queryBuilder = new UpdateBuilder ( $shippingStatusVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`shipping_status`", $queryBuilder->getSql (), ShippingStatusVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ShippingStatusVo $shippingStatusVo) {
		try {
			$query = "delete from `shipping_status`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`shipping_status`", $query, ShippingStatusVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}