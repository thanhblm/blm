<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\RegionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class RegionMapping {
	final public function selectByKey(RegionVo $regionVo) {
		try {
			$query = "select * from `region` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(RegionVo $regionVo = null) {
		try {
			$query = "select * from `region`";
			$queryBuilder = new QueryBuilder ( $regionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(RegionVo $regionVo) {
		try {
			$query = "select * from `region`";
			$queryBuilder = new QueryBuilder ( $regionVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`contact_email`", "contactEmail")
				->appendCondition ( "`invoice_logo`", "invoiceLogo")
				->appendCondition ( "`invoice_header`", "invoiceHeader")
				->appendCondition ( "`invoice_comment`", "invoiceComment")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`fallback_region`", "fallbackRegion")
				->appendCondition ( "`free_shipping_amount`", "freeShippingAmount")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(RegionVo $regionVo = null) {
		try {
			$query = "select count(*) from `region`";
			$queryBuilder = new QueryBuilder ( $regionVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`contact_email`", "contactEmail")
				->appendCondition ( "`invoice_logo`", "invoiceLogo")
				->appendCondition ( "`invoice_header`", "invoiceHeader")
				->appendCondition ( "`invoice_comment`", "invoiceComment")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`fallback_region`", "fallbackRegion")
				->appendCondition ( "`free_shipping_amount`", "freeShippingAmount")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(RegionVo $regionVo) {
		try {
			$query = "insert into `region`";
			$queryBuilder = new InsertBuilder ( $regionVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`contact_email`", "contactEmail")
				->appendField("`invoice_logo`", "invoiceLogo")
				->appendField("`invoice_header`", "invoiceHeader")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`status`", "status")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`fallback_region`", "fallbackRegion")
				->appendField("`free_shipping_amount`", "freeShippingAmount")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region`", $queryBuilder->getSql (), RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(RegionVo $regionVo) {
		try {
			$query = "insert into `region`";
			$queryBuilder = new InsertBuilder ( $regionVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`contact_email`", "contactEmail")
				->appendField("`invoice_logo`", "invoiceLogo")
				->appendField("`invoice_header`", "invoiceHeader")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`status`", "status")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`fallback_region`", "fallbackRegion")
				->appendField("`free_shipping_amount`", "freeShippingAmount")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region`", $queryBuilder->getSql (), RegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(RegionVo $regionVo) {
		try {
			$query = "update `region`";
			$queryBuilder = new UpdateBuilder ( $regionVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`contact_email`", "contactEmail")
				->appendField("`invoice_logo`", "invoiceLogo")
				->appendField("`invoice_header`", "invoiceHeader")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`status`", "status")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`fallback_region`", "fallbackRegion")
				->appendField("`free_shipping_amount`", "freeShippingAmount")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`region`", $queryBuilder->getSql (), RegionVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(RegionVo $regionVo) {
		try {
			$query = "delete from `region`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`region`", $query, RegionVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}