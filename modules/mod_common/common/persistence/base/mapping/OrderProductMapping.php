<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderProductVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderProductMapping {
	final public function selectByKey(OrderProductVo $orderProductVo) {
		try {
			$query = "select * from `order_product` where (`order_id` = #{orderId}) and (`product_id` = #{productId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderProductVo $orderProductVo = null) {
		try {
			$query = "select * from `order_product`";
			$queryBuilder = new QueryBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderProductVo $orderProductVo) {
		try {
			$query = "select * from `order_product`";
			$queryBuilder = new QueryBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`product_attribute_id`", "productAttributeId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`quantity`", "quantity")
				->appendCondition ( "`base_price`", "basePrice")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`tax`", "tax")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderProductVo $orderProductVo = null) {
		try {
			$query = "select count(*) from `order_product`";
			$queryBuilder = new QueryBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`product_attribute_id`", "productAttributeId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`quantity`", "quantity")
				->appendCondition ( "`base_price`", "basePrice")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`tax`", "tax");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderProductVo $orderProductVo) {
		try {
			$query = "insert into `order_product`";
			$queryBuilder = new InsertBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`product_id`", "productId")
				->appendField("`product_attribute_id`", "productAttributeId")
				->appendField("`name`", "name")
				->appendField("`quantity`", "quantity")
				->appendField("`base_price`", "basePrice")
				->appendField("`price`", "price")
				->appendField("`discount`", "discount")
				->appendField("`tax`", "tax");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_product`", $queryBuilder->getSql (), OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderProductVo $orderProductVo) {
		try {
			$query = "insert into `order_product`";
			$queryBuilder = new InsertBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`product_id`", "productId")
				->appendField("`product_attribute_id`", "productAttributeId")
				->appendField("`name`", "name")
				->appendField("`quantity`", "quantity")
				->appendField("`base_price`", "basePrice")
				->appendField("`price`", "price")
				->appendField("`discount`", "discount")
				->appendField("`tax`", "tax");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_product`", $queryBuilder->getSql (), OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderProductVo $orderProductVo) {
		try {
			$query = "update `order_product`";
			$queryBuilder = new UpdateBuilder ( $orderProductVo, $query );
			$queryBuilder
				->appendField("`product_attribute_id`", "productAttributeId")
				->appendField("`name`", "name")
				->appendField("`quantity`", "quantity")
				->appendField("`base_price`", "basePrice")
				->appendField("`price`", "price")
				->appendField("`discount`", "discount")
				->appendField("`tax`", "tax");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_product`", $queryBuilder->getSql (), OrderProductVo::class, "where (`order_id` = #{orderId}) and (`product_id` = #{productId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderProductVo $orderProductVo) {
		try {
			$query = "delete from `order_product`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_product`", $query, OrderProductVo::class, "where (`order_id` = #{orderId}) and (`product_id` = #{productId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}