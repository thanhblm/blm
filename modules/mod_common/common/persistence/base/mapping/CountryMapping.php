<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CountryVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CountryMapping {
	final public function selectByKey(CountryVo $countryVo) {
		try {
			$query = "select * from `country` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CountryVo $countryVo = null) {
		try {
			$query = "select * from `country`";
			$queryBuilder = new QueryBuilder ( $countryVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CountryVo $countryVo) {
		try {
			$query = "select * from `country`";
			$queryBuilder = new QueryBuilder ( $countryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`iso2`", "iso2")
				->appendCondition ( "`iso3`", "iso3")
				->appendCondition ( "`ison`", "ison")
				->appendCondition ( "`isor1`", "isor1")
				->appendCondition ( "`isor2`", "isor2")
				->appendCondition ( "`name_local`", "nameLocal")
				->appendCondition ( "`continent`", "continent")
				->appendCondition ( "`lat`", "lat")
				->appendCondition ( "`lng`", "lng")
				->appendCondition ( "`phone_prefix`", "phonePrefix")
				->appendCondition ( "`languages`", "languages")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CountryVo $countryVo = null) {
		try {
			$query = "select count(*) from `country`";
			$queryBuilder = new QueryBuilder ( $countryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`iso2`", "iso2")
				->appendCondition ( "`iso3`", "iso3")
				->appendCondition ( "`ison`", "ison")
				->appendCondition ( "`isor1`", "isor1")
				->appendCondition ( "`isor2`", "isor2")
				->appendCondition ( "`name_local`", "nameLocal")
				->appendCondition ( "`continent`", "continent")
				->appendCondition ( "`lat`", "lat")
				->appendCondition ( "`lng`", "lng")
				->appendCondition ( "`phone_prefix`", "phonePrefix")
				->appendCondition ( "`languages`", "languages");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CountryVo $countryVo) {
		try {
			$query = "insert into `country`";
			$queryBuilder = new InsertBuilder ( $countryVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`iso2`", "iso2")
				->appendField("`iso3`", "iso3")
				->appendField("`ison`", "ison")
				->appendField("`isor1`", "isor1")
				->appendField("`isor2`", "isor2")
				->appendField("`name_local`", "nameLocal")
				->appendField("`continent`", "continent")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng")
				->appendField("`phone_prefix`", "phonePrefix")
				->appendField("`languages`", "languages");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`country`", $queryBuilder->getSql (), CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CountryVo $countryVo) {
		try {
			$query = "insert into `country`";
			$queryBuilder = new InsertBuilder ( $countryVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`iso2`", "iso2")
				->appendField("`iso3`", "iso3")
				->appendField("`ison`", "ison")
				->appendField("`isor1`", "isor1")
				->appendField("`isor2`", "isor2")
				->appendField("`name_local`", "nameLocal")
				->appendField("`continent`", "continent")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng")
				->appendField("`phone_prefix`", "phonePrefix")
				->appendField("`languages`", "languages");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`country`", $queryBuilder->getSql (), CountryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CountryVo $countryVo) {
		try {
			$query = "update `country`";
			$queryBuilder = new UpdateBuilder ( $countryVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`iso2`", "iso2")
				->appendField("`iso3`", "iso3")
				->appendField("`ison`", "ison")
				->appendField("`isor1`", "isor1")
				->appendField("`isor2`", "isor2")
				->appendField("`name_local`", "nameLocal")
				->appendField("`continent`", "continent")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng")
				->appendField("`phone_prefix`", "phonePrefix")
				->appendField("`languages`", "languages");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`country`", $queryBuilder->getSql (), CountryVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CountryVo $countryVo) {
		try {
			$query = "delete from `country`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`country`", $query, CountryVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}