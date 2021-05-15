<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ProductVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ProductMapping {
	final public function selectByKey(ProductVo $productVo) {
		try {
			$query = "select * from `product` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ProductVo $productVo = null) {
		try {
			$query = "select * from `product`";
			$queryBuilder = new QueryBuilder ( $productVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ProductVo $productVo) {
		try {
			$query = "select * from `product`";
			$queryBuilder = new QueryBuilder ( $productVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`item_code`", "itemCode")
				->appendCondition ( "`bar_code`", "barCode")
				->appendCondition ( "`weight`", "weight")
				->appendCondition ( "`weight_unit`", "weightUnit")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`cbd_amount`", "cbdAmount")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`images`", "images")
				->appendCondition ( "`user_type`", "userType")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`tax_rate_id`", "taxRateId")
				->appendCondition ( "`is_seo`", "isSeo")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ProductVo $productVo = null) {
		try {
			$query = "select count(*) from `product`";
			$queryBuilder = new QueryBuilder ( $productVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`item_code`", "itemCode")
				->appendCondition ( "`bar_code`", "barCode")
				->appendCondition ( "`weight`", "weight")
				->appendCondition ( "`weight_unit`", "weightUnit")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`cbd_amount`", "cbdAmount")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`images`", "images")
				->appendCondition ( "`user_type`", "userType")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`tax_rate_id`", "taxRateId")
				->appendCondition ( "`is_seo`", "isSeo")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ProductVo $productVo) {
		try {
			$query = "insert into `product`";
			$queryBuilder = new InsertBuilder ( $productVo, $query );
			$queryBuilder
				->appendField("`category_id`", "categoryId")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`item_code`", "itemCode")
				->appendField("`bar_code`", "barCode")
				->appendField("`weight`", "weight")
				->appendField("`weight_unit`", "weightUnit")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`cbd_amount`", "cbdAmount")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`user_type`", "userType")
				->appendField("`user_id`", "userId")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`is_seo`", "isSeo")
				->appendField("`type`", "type")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product`", $queryBuilder->getSql (), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ProductVo $productVo) {
		try {
			$query = "insert into `product`";
			$queryBuilder = new InsertBuilder ( $productVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`category_id`", "categoryId")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`item_code`", "itemCode")
				->appendField("`bar_code`", "barCode")
				->appendField("`weight`", "weight")
				->appendField("`weight_unit`", "weightUnit")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`cbd_amount`", "cbdAmount")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`user_type`", "userType")
				->appendField("`user_id`", "userId")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`is_seo`", "isSeo")
				->appendField("`type`", "type")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`product`", $queryBuilder->getSql (), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ProductVo $productVo) {
		try {
			$query = "update `product`";
			$queryBuilder = new UpdateBuilder ( $productVo, $query );
			$queryBuilder
				->appendField("`category_id`", "categoryId")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`item_code`", "itemCode")
				->appendField("`bar_code`", "barCode")
				->appendField("`weight`", "weight")
				->appendField("`weight_unit`", "weightUnit")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`cbd_amount`", "cbdAmount")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`user_type`", "userType")
				->appendField("`user_id`", "userId")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`is_seo`", "isSeo")
				->appendField("`type`", "type")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`product`", $queryBuilder->getSql (), ProductVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ProductVo $productVo) {
		try {
			$query = "delete from `product`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product`", $query, ProductVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}