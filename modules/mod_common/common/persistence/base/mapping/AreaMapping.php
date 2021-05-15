<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AreaVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AreaMapping {
	final public function selectByKey(AreaVo $areaVo) {
		try {
			$query = "select * from `area` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AreaVo $areaVo = null) {
		try {
			$query = "select * from `area`";
			$queryBuilder = new QueryBuilder ( $areaVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AreaVo $areaVo) {
		try {
			$query = "select * from `area`";
			$queryBuilder = new QueryBuilder ( $areaVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AreaVo $areaVo = null) {
		try {
			$query = "select count(*) from `area`";
			$queryBuilder = new QueryBuilder ( $areaVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AreaVo $areaVo) {
		try {
			$query = "insert into `area`";
			$queryBuilder = new InsertBuilder ( $areaVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`area`", $queryBuilder->getSql (), AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AreaVo $areaVo) {
		try {
			$query = "insert into `area`";
			$queryBuilder = new InsertBuilder ( $areaVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`area`", $queryBuilder->getSql (), AreaVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AreaVo $areaVo) {
		try {
			$query = "update `area`";
			$queryBuilder = new UpdateBuilder ( $areaVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`area`", $queryBuilder->getSql (), AreaVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AreaVo $areaVo) {
		try {
			$query = "delete from `area`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`area`", $query, AreaVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}