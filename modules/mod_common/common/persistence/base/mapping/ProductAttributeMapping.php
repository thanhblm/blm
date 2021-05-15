<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductAttributeVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductAttributeMapping {
	final public function selectByKey(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "select * from `product_attribute` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductAttributeVo $productAttributeVo = null) {
		try {
			$query = "select * from `product_attribute`";
			$queryBuilder = new QueryBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "select * from `product_attribute`";
			$queryBuilder = new QueryBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`attribute_id`", "attributeId")
				->appendCondition ( "`quantity`", "quantity")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`type`", "type")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductAttributeVo $productAttributeVo = null) {
		try {
			$query = "select count(*) from `product_attribute`";
			$queryBuilder = new QueryBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`attribute_id`", "attributeId")
				->appendCondition ( "`quantity`", "quantity")
				->appendCondition ( "`price`", "price")
				->appendCondition ( "`type`", "type");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "insert into `product_attribute`";
			$queryBuilder = new InsertBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`attribute_id`", "attributeId")
				->appendField("`quantity`", "quantity")
				->appendField("`price`", "price")
				->appendField("`type`", "type");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_attribute`", $queryBuilder->getSql (), ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "insert into `product_attribute`";
			$queryBuilder = new InsertBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`product_id`", "productId")
				->appendField("`attribute_id`", "attributeId")
				->appendField("`quantity`", "quantity")
				->appendField("`price`", "price")
				->appendField("`type`", "type");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_attribute`", $queryBuilder->getSql (), ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "update `product_attribute`";
			$queryBuilder = new UpdateBuilder ( $productAttributeVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`attribute_id`", "attributeId")
				->appendField("`quantity`", "quantity")
				->appendField("`price`", "price")
				->appendField("`type`", "type");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product_attribute`", $queryBuilder->getSql (), ProductAttributeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductAttributeVo $productAttributeVo) {
		try {
			$query = "delete from `product_attribute`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_attribute`", $query, ProductAttributeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}