<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductRegionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductRegionMapping {
	final public function selectByKey(ProductRegionVo $productRegionVo) {
		try {
			$query = "select * from `product_region` where (`product_id` = #{productId}) and (`region_id` = #{regionId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductRegionVo $productRegionVo = null) {
		try {
			$query = "select * from `product_region`";
			$queryBuilder = new QueryBuilder ( $productRegionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductRegionVo $productRegionVo) {
		try {
			$query = "select * from `product_region`";
			$queryBuilder = new QueryBuilder ( $productRegionVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`region_id`", "regionId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductRegionVo $productRegionVo = null) {
		try {
			$query = "select count(*) from `product_region`";
			$queryBuilder = new QueryBuilder ( $productRegionVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductRegionVo $productRegionVo) {
		try {
			$query = "insert into `product_region`";
			$queryBuilder = new InsertBuilder ( $productRegionVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_region`", $queryBuilder->getSql (), ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductRegionVo $productRegionVo) {
		try {
			$query = "insert into `product_region`";
			$queryBuilder = new InsertBuilder ( $productRegionVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_region`", $queryBuilder->getSql (), ProductRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductRegionVo $productRegionVo) {
		try {
			$query = "update `product_region`";
			$queryBuilder = new UpdateBuilder ( $productRegionVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product_region`", $queryBuilder->getSql (), ProductRegionVo::class, "where (`product_id` = #{productId}) and (`region_id` = #{regionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductRegionVo $productRegionVo) {
		try {
			$query = "delete from `product_region`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_region`", $query, ProductRegionVo::class, "where (`product_id` = #{productId}) and (`region_id` = #{regionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}