<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductRelationVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductRelationMapping {
	final public function selectByKey(ProductRelationVo $productRelationVo) {
		try {
			$query = "select * from `product_relation` where (`product_id` = #{productId}) and (`relate_product_id` = #{relateProductId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductRelationVo $productRelationVo = null) {
		try {
			$query = "select * from `product_relation`";
			$queryBuilder = new QueryBuilder ( $productRelationVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductRelationVo $productRelationVo) {
		try {
			$query = "select * from `product_relation`";
			$queryBuilder = new QueryBuilder ( $productRelationVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`relate_product_id`", "relateProductId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductRelationVo $productRelationVo = null) {
		try {
			$query = "select count(*) from `product_relation`";
			$queryBuilder = new QueryBuilder ( $productRelationVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`relate_product_id`", "relateProductId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductRelationVo $productRelationVo) {
		try {
			$query = "insert into `product_relation`";
			$queryBuilder = new InsertBuilder ( $productRelationVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`relate_product_id`", "relateProductId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_relation`", $queryBuilder->getSql (), ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductRelationVo $productRelationVo) {
		try {
			$query = "insert into `product_relation`";
			$queryBuilder = new InsertBuilder ( $productRelationVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`relate_product_id`", "relateProductId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_relation`", $queryBuilder->getSql (), ProductRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductRelationVo $productRelationVo) {
		try {
			$query = "update `product_relation`";
			$queryBuilder = new UpdateBuilder ( $productRelationVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product_relation`", $queryBuilder->getSql (), ProductRelationVo::class, "where (`product_id` = #{productId}) and (`relate_product_id` = #{relateProductId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductRelationVo $productRelationVo) {
		try {
			$query = "delete from `product_relation`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_relation`", $query, ProductRelationVo::class, "where (`product_id` = #{productId}) and (`relate_product_id` = #{relateProductId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}