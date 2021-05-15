<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\RegionCountryVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class RegionCountryMapping {
	final public function selectByKey(RegionCountryVo $regionCountryVo) {
		try {
			$query = "select * from `region_country` where (`region_id` = #{regionId}) and (`country_id` = #{countryId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(RegionCountryVo $regionCountryVo = null) {
		try {
			$query = "select * from `region_country`";
			$queryBuilder = new QueryBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(RegionCountryVo $regionCountryVo) {
		try {
			$query = "select * from `region_country`";
			$queryBuilder = new QueryBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`country_id`", "countryId")
				->appendCondition ( "`state_id`", "stateId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(RegionCountryVo $regionCountryVo = null) {
		try {
			$query = "select count(*) from `region_country`";
			$queryBuilder = new QueryBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`country_id`", "countryId")
				->appendCondition ( "`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(RegionCountryVo $regionCountryVo) {
		try {
			$query = "insert into `region_country`";
			$queryBuilder = new InsertBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendField("`region_id`", "regionId")
				->appendField("`country_id`", "countryId")
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_country`", $queryBuilder->getSql (), RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(RegionCountryVo $regionCountryVo) {
		try {
			$query = "insert into `region_country`";
			$queryBuilder = new InsertBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendField("`region_id`", "regionId")
				->appendField("`country_id`", "countryId")
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`region_country`", $queryBuilder->getSql (), RegionCountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(RegionCountryVo $regionCountryVo) {
		try {
			$query = "update `region_country`";
			$queryBuilder = new UpdateBuilder ( $regionCountryVo, $query );
			$queryBuilder
				->appendField("`state_id`", "stateId");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`region_country`", $queryBuilder->getSql (), RegionCountryVo::class, "where (`region_id` = #{regionId}) and (`country_id` = #{countryId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(RegionCountryVo $regionCountryVo) {
		try {
			$query = "delete from `region_country`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`region_country`", $query, RegionCountryVo::class, "where (`region_id` = #{regionId}) and (`country_id` = #{countryId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}