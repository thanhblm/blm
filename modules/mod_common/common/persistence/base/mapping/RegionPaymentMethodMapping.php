<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\RegionPaymentMethodVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class RegionPaymentMethodMapping {
	final public function selectByKey(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "select * from `region_payment_method` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		try {
			$query = "select * from `region_payment_method`";
			$queryBuilder = new QueryBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "select * from `region_payment_method`";
			$queryBuilder = new QueryBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`payment_method_id`", "paymentMethodId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`setting_info`", "settingInfo")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		try {
			$query = "select count(*) from `region_payment_method`";
			$queryBuilder = new QueryBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`payment_method_id`", "paymentMethodId")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "insert into `region_payment_method`";
			$queryBuilder = new InsertBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendField("`region_id`", "regionId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_payment_method`", $queryBuilder->getSql (), RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "insert into `region_payment_method`";
			$queryBuilder = new InsertBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`region_id`", "regionId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_payment_method`", $queryBuilder->getSql (), RegionPaymentMethodVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "update `region_payment_method`";
			$queryBuilder = new UpdateBuilder ( $regionPaymentMethodVo, $query );
			$queryBuilder
				->appendField("`region_id`", "regionId")
				->appendField("`payment_method_id`", "paymentMethodId")
				->appendField("`status`", "status")
				->appendField("`setting_info`", "settingInfo");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`region_payment_method`", $queryBuilder->getSql (), RegionPaymentMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(RegionPaymentMethodVo $regionPaymentMethodVo) {
		try {
			$query = "delete from `region_payment_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`region_payment_method`", $query, RegionPaymentMethodVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}