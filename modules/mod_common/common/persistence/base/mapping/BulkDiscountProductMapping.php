<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BulkDiscountProductVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BulkDiscountProductMapping {
	final public function selectByKey(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "select * from `bulk_discount_product` where (`bulk_discount_id` = #{bulkDiscountId}) and (`product_id` = #{productId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		try {
			$query = "select * from `bulk_discount_product`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "select * from `bulk_discount_product`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendCondition ( "`bulk_discount_id`", "bulkDiscountId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`quantity`", "quantity")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BulkDiscountProductVo $bulkDiscountProductVo = null) {
		try {
			$query = "select count(*) from `bulk_discount_product`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendCondition ( "`bulk_discount_id`", "bulkDiscountId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`quantity`", "quantity");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "insert into `bulk_discount_product`";
			$queryBuilder = new InsertBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendField("`bulk_discount_id`", "bulkDiscountId")
				->appendField("`product_id`", "productId")
				->appendField("`quantity`", "quantity");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`bulk_discount_product`", $queryBuilder->getSql (), BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "insert into `bulk_discount_product`";
			$queryBuilder = new InsertBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendField("`bulk_discount_id`", "bulkDiscountId")
				->appendField("`product_id`", "productId")
				->appendField("`quantity`", "quantity");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`bulk_discount_product`", $queryBuilder->getSql (), BulkDiscountProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "update `bulk_discount_product`";
			$queryBuilder = new UpdateBuilder ( $bulkDiscountProductVo, $query );
			$queryBuilder
				->appendField("`quantity`", "quantity");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`bulk_discount_product`", $queryBuilder->getSql (), BulkDiscountProductVo::class, "where (`bulk_discount_id` = #{bulkDiscountId}) and (`product_id` = #{productId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BulkDiscountProductVo $bulkDiscountProductVo) {
		try {
			$query = "delete from `bulk_discount_product`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`bulk_discount_product`", $query, BulkDiscountProductVo::class, "where (`bulk_discount_id` = #{bulkDiscountId}) and (`product_id` = #{productId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}