<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\StateVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class StateMapping {
	final public function selectByKey(StateVo $stateVo) {
		try {
			$query = "select * from `state` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(StateVo $stateVo = null) {
		try {
			$query = "select * from `state`";
			$queryBuilder = new QueryBuilder ( $stateVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(StateVo $stateVo) {
		try {
			$query = "select * from `state`";
			$queryBuilder = new QueryBuilder ( $stateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`iso2`", "iso2")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`name_local`", "nameLocal")
				->appendCondition ( "`country`", "country")
				->appendCondition ( "`country_iso`", "countryIso")
				->appendCondition ( "`lat`", "lat")
				->appendCondition ( "`lng`", "lng")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(StateVo $stateVo = null) {
		try {
			$query = "select count(*) from `state`";
			$queryBuilder = new QueryBuilder ( $stateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`iso2`", "iso2")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`name_local`", "nameLocal")
				->appendCondition ( "`country`", "country")
				->appendCondition ( "`country_iso`", "countryIso")
				->appendCondition ( "`lat`", "lat")
				->appendCondition ( "`lng`", "lng");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(StateVo $stateVo) {
		try {
			$query = "insert into `state`";
			$queryBuilder = new InsertBuilder ( $stateVo, $query );
			$queryBuilder
				->appendField("`iso2`", "iso2")
				->appendField("`name`", "name")
				->appendField("`name_local`", "nameLocal")
				->appendField("`country`", "country")
				->appendField("`country_iso`", "countryIso")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`state`", $queryBuilder->getSql (), StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(StateVo $stateVo) {
		try {
			$query = "insert into `state`";
			$queryBuilder = new InsertBuilder ( $stateVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`iso2`", "iso2")
				->appendField("`name`", "name")
				->appendField("`name_local`", "nameLocal")
				->appendField("`country`", "country")
				->appendField("`country_iso`", "countryIso")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`state`", $queryBuilder->getSql (), StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(StateVo $stateVo) {
		try {
			$query = "update `state`";
			$queryBuilder = new UpdateBuilder ( $stateVo, $query );
			$queryBuilder
				->appendField("`iso2`", "iso2")
				->appendField("`name`", "name")
				->appendField("`name_local`", "nameLocal")
				->appendField("`country`", "country")
				->appendField("`country_iso`", "countryIso")
				->appendField("`lat`", "lat")
				->appendField("`lng`", "lng");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`state`", $queryBuilder->getSql (), StateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(StateVo $stateVo) {
		try {
			$query = "delete from `state`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`state`", $query, StateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}