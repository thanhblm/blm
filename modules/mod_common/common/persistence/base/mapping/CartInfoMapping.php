<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CartInfoVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CartInfoMapping {
	final public function selectByKey(CartInfoVo $cartInfoVo) {
		try {
			$query = "select * from `cart_info` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CartInfoVo $cartInfoVo = null) {
		try {
			$query = "select * from `cart_info`";
			$queryBuilder = new QueryBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CartInfoVo $cartInfoVo) {
		try {
			$query = "select * from `cart_info`";
			$queryBuilder = new QueryBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`session_id`", "sessionId")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`info`", "info")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CartInfoVo $cartInfoVo = null) {
		try {
			$query = "select count(*) from `cart_info`";
			$queryBuilder = new QueryBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`session_id`", "sessionId")
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`info`", "info")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CartInfoVo $cartInfoVo) {
		try {
			$query = "insert into `cart_info`";
			$queryBuilder = new InsertBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendField("`session_id`", "sessionId")
				->appendField("`order_id`", "orderId")
				->appendField("`info`", "info")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`cart_info`", $queryBuilder->getSql (), CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CartInfoVo $cartInfoVo) {
		try {
			$query = "insert into `cart_info`";
			$queryBuilder = new InsertBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`session_id`", "sessionId")
				->appendField("`order_id`", "orderId")
				->appendField("`info`", "info")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`cart_info`", $queryBuilder->getSql (), CartInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CartInfoVo $cartInfoVo) {
		try {
			$query = "update `cart_info`";
			$queryBuilder = new UpdateBuilder ( $cartInfoVo, $query );
			$queryBuilder
				->appendField("`session_id`", "sessionId")
				->appendField("`order_id`", "orderId")
				->appendField("`info`", "info")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`cart_info`", $queryBuilder->getSql (), CartInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CartInfoVo $cartInfoVo) {
		try {
			$query = "delete from `cart_info`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`cart_info`", $query, CartInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}