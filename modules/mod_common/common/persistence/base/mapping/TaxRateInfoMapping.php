<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\TaxRateInfoVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class TaxRateInfoMapping {
	final public function selectByKey(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "select * from `tax_rate_info` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(TaxRateInfoVo $taxRateInfoVo = null) {
		try {
			$query = "select * from `tax_rate_info`";
			$queryBuilder = new QueryBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "select * from `tax_rate_info`";
			$queryBuilder = new QueryBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`tax_rate_id`", "taxRateId")
				->appendCondition ( "`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`zone_match`", "zoneMatch")
				->appendCondition ( "`rate`", "rate")
				->appendCondition ( "`dynamic_rate`", "dynamicRate")
				->appendCondition ( "`priority`", "priority")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(TaxRateInfoVo $taxRateInfoVo = null) {
		try {
			$query = "select count(*) from `tax_rate_info`";
			$queryBuilder = new QueryBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`tax_rate_id`", "taxRateId")
				->appendCondition ( "`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`zone_match`", "zoneMatch")
				->appendCondition ( "`rate`", "rate")
				->appendCondition ( "`dynamic_rate`", "dynamicRate")
				->appendCondition ( "`priority`", "priority");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "insert into `tax_rate_info`";
			$queryBuilder = new InsertBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendField("`type`", "type")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`name`", "name")
				->appendField("`zone_match`", "zoneMatch")
				->appendField("`rate`", "rate")
				->appendField("`dynamic_rate`", "dynamicRate")
				->appendField("`priority`", "priority");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_rate_info`", $queryBuilder->getSql (), TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "insert into `tax_rate_info`";
			$queryBuilder = new InsertBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`type`", "type")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`name`", "name")
				->appendField("`zone_match`", "zoneMatch")
				->appendField("`rate`", "rate")
				->appendField("`dynamic_rate`", "dynamicRate")
				->appendField("`priority`", "priority");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_rate_info`", $queryBuilder->getSql (), TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "update `tax_rate_info`";
			$queryBuilder = new UpdateBuilder ( $taxRateInfoVo, $query );
			$queryBuilder
				->appendField("`type`", "type")
				->appendField("`tax_rate_id`", "taxRateId")
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`name`", "name")
				->appendField("`zone_match`", "zoneMatch")
				->appendField("`rate`", "rate")
				->appendField("`dynamic_rate`", "dynamicRate")
				->appendField("`priority`", "priority");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`tax_rate_info`", $queryBuilder->getSql (), TaxRateInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(TaxRateInfoVo $taxRateInfoVo) {
		try {
			$query = "delete from `tax_rate_info`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`tax_rate_info`", $query, TaxRateInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}