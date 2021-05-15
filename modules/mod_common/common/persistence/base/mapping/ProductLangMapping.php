<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductLangMapping {
	final public function selectByKey(ProductLangVo $productLangVo) {
		try {
			$query = "select * from `product_lang` where (`product_id` = #{productId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductLangVo $productLangVo = null) {
		try {
			$query = "select * from `product_lang`";
			$queryBuilder = new QueryBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductLangVo $productLangVo) {
		try {
			$query = "select * from `product_lang`";
			$queryBuilder = new QueryBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductLangVo $productLangVo = null) {
		try {
			$query = "select count(*) from `product_lang`";
			$queryBuilder = new QueryBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductLangVo $productLangVo) {
		try {
			$query = "insert into `product_lang`";
			$queryBuilder = new InsertBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_lang`", $queryBuilder->getSql (), ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductLangVo $productLangVo) {
		try {
			$query = "insert into `product_lang`";
			$queryBuilder = new InsertBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendField("`product_id`", "productId")
				->appendField("`language_code`", "languageCode")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product_lang`", $queryBuilder->getSql (), ProductLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductLangVo $productLangVo) {
		try {
			$query = "update `product_lang`";
			$queryBuilder = new UpdateBuilder ( $productLangVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product_lang`", $queryBuilder->getSql (), ProductLangVo::class, "where (`product_id` = #{productId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductLangVo $productLangVo) {
		try {
			$query = "delete from `product_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_lang`", $query, ProductLangVo::class, "where (`product_id` = #{productId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}