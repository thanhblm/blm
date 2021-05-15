<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BulkDiscountVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BulkDiscountMapping {
	final public function selectByKey(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "select * from `bulk_discount` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BulkDiscountVo $bulkDiscountVo = null) {
		try {
			$query = "select * from `bulk_discount`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "select * from `bulk_discount`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`valid_from`", "validFrom")
				->appendCondition ( "`valid_to`", "validTo")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BulkDiscountVo $bulkDiscountVo = null) {
		try {
			$query = "select count(*) from `bulk_discount`";
			$queryBuilder = new QueryBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`valid_from`", "validFrom")
				->appendCondition ( "`valid_to`", "validTo")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "insert into `bulk_discount`";
			$queryBuilder = new InsertBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`discount`", "discount")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`bulk_discount`", $queryBuilder->getSql (), BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "insert into `bulk_discount`";
			$queryBuilder = new InsertBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`discount`", "discount")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`bulk_discount`", $queryBuilder->getSql (), BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "update `bulk_discount`";
			$queryBuilder = new UpdateBuilder ( $bulkDiscountVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`discount`", "discount")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`bulk_discount`", $queryBuilder->getSql (), BulkDiscountVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BulkDiscountVo $bulkDiscountVo) {
		try {
			$query = "delete from `bulk_discount`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`bulk_discount`", $query, BulkDiscountVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}