<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\TaxShippingZoneInfoVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class TaxShippingZoneInfoMapping {
	final public function selectByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "select * from `tax_shipping_zone_info` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		try {
			$query = "select * from `tax_shipping_zone_info`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "select * from `tax_shipping_zone_info`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendCondition ( "`country_id`", "countryId")
				->appendCondition ( "`state_id`", "stateId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(TaxShippingZoneInfoVo $taxShippingZoneInfoVo = null) {
		try {
			$query = "select count(*) from `tax_shipping_zone_info`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendCondition ( "`country_id`", "countryId")
				->appendCondition ( "`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "insert into `tax_shipping_zone_info`";
			$queryBuilder = new InsertBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`country_id`", "countryId")
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_shipping_zone_info`", $queryBuilder->getSql (), TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "insert into `tax_shipping_zone_info`";
			$queryBuilder = new InsertBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`country_id`", "countryId")
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_shipping_zone_info`", $queryBuilder->getSql (), TaxShippingZoneInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "update `tax_shipping_zone_info`";
			$queryBuilder = new UpdateBuilder ( $taxShippingZoneInfoVo, $query );
			$queryBuilder
				->appendField("`tax_shipping_zone_id`", "taxShippingZoneId")
				->appendField("`country_id`", "countryId")
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`tax_shipping_zone_info`", $queryBuilder->getSql (), TaxShippingZoneInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(TaxShippingZoneInfoVo $taxShippingZoneInfoVo) {
		try {
			$query = "delete from `tax_shipping_zone_info`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`tax_shipping_zone_info`", $query, TaxShippingZoneInfoVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}