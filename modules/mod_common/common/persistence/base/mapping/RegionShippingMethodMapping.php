<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\RegionShippingMethodVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class RegionShippingMethodMapping {
	final public function selectByKey(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "select * from `region_shipping_method` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(RegionShippingMethodVo $regionShippingMethodVo = null) {
		try {
			$query = "select * from `region_shipping_method`";
			$queryBuilder = new QueryBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "select * from `region_shipping_method`";
			$queryBuilder = new QueryBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`shipping_method_id`", "shippingMethodId")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`setting_info`", "settingInfo")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(RegionShippingMethodVo $regionShippingMethodVo = null) {
		try {
			$query = "select count(*) from `region_shipping_method`";
			$queryBuilder = new QueryBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`shipping_method_id`", "shippingMethodId")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "insert into `region_shipping_method`";
			$queryBuilder = new InsertBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendField("`shipping_method_id`", "shippingMethodId")
				->appendField("`region_id`", "regionId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_shipping_method`", $queryBuilder->getSql (), RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "insert into `region_shipping_method`";
			$queryBuilder = new InsertBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`shipping_method_id`", "shippingMethodId")
				->appendField("`region_id`", "regionId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_shipping_method`", $queryBuilder->getSql (), RegionShippingMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "update `region_shipping_method`";
			$queryBuilder = new UpdateBuilder ( $regionShippingMethodVo, $query );
			$queryBuilder
				->appendField("`shipping_method_id`", "shippingMethodId")
				->appendField("`region_id`", "regionId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`region_shipping_method`", $queryBuilder->getSql (), RegionShippingMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(RegionShippingMethodVo $regionShippingMethodVo) {
		try {
			$query = "delete from `region_shipping_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`region_shipping_method`", $query, RegionShippingMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}