<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductPriceVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductPriceMapping {
	final public function selectByKey(ProductPriceVo $productPriceVo) {
		try {
			$query = "select * from `product_price` where (`product_id` = #{productId}) and (`currency_code` = #{currencyCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductPriceVo $productPriceVo = null) {
		try {
			$query = "select * from `product_price`";
			$queryBuilder = new QueryBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductPriceVo $productPriceVo) {
		try {
			$query = "select * from `product_price`";
			$queryBuilder = new QueryBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`min_price`", "minPrice")
				->appendCondition ( "`max_price`", "maxPrice")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductPriceVo $productPriceVo = null) {
		try {
			$query = "select count(*) from `product_price`";
			$queryBuilder = new QueryBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`min_price`", "minPrice")
				->appendCondition ( "`max_price`", "maxPrice");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductPriceVo $productPriceVo) {
		try {
			$query = "insert into `product_price`";
			$queryBuilder = new InsertBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`price`", "price")
				->appendField("`min_price`", "minPrice")
				->appendField("`max_price`", "maxPrice");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_price`", $queryBuilder->getSql (), ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductPriceVo $productPriceVo) {
		try {
			$query = "insert into `product_price`";
			$queryBuilder = new InsertBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`price`", "price")
				->appendField("`min_price`", "minPrice")
				->appendField("`max_price`", "maxPrice");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_price`", $queryBuilder->getSql (), ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductPriceVo $productPriceVo) {
		try {
			$query = "update `product_price`";
			$queryBuilder = new UpdateBuilder ( $productPriceVo, $query );
			$queryBuilder
				->appendField("`price`", "price")
				->appendField("`min_price`", "minPrice")
				->appendField("`max_price`", "maxPrice");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product_price`", $queryBuilder->getSql (), ProductPriceVo::class, "where (`product_id` = #{productId}) and (`currency_code` = #{currencyCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductPriceVo $productPriceVo) {
		try {
			$query = "delete from `product_price`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_price`", $query, ProductPriceVo::class, "where (`product_id` = #{productId}) and (`currency_code` = #{currencyCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}