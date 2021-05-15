<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PermissionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PermissionMapping {
	final public function selectByKey(PermissionVo $permissionVo) {
		try {
			$query = "select * from `permission` where (`permission_action_code` = #{permissionActionCode}) and (`type` = #{type}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PermissionVo $permissionVo = null) {
		try {
			$query = "select * from `permission`";
			$queryBuilder = new QueryBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PermissionVo $permissionVo) {
		try {
			$query = "select * from `permission`";
			$queryBuilder = new QueryBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendCondition ( "`permission_action_code`", "permissionActionCode")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PermissionVo $permissionVo = null) {
		try {
			$query = "select count(*) from `permission`";
			$queryBuilder = new QueryBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendCondition ( "`permission_action_code`", "permissionActionCode")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PermissionVo $permissionVo) {
		try {
			$query = "insert into `permission`";
			$queryBuilder = new InsertBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendField("`permission_action_code`", "permissionActionCode")
				->appendField("`type`", "type")
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`permission`", $queryBuilder->getSql (), PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PermissionVo $permissionVo) {
		try {
			$query = "insert into `permission`";
			$queryBuilder = new InsertBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendField("`permission_action_code`", "permissionActionCode")
				->appendField("`type`", "type")
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`permission`", $queryBuilder->getSql (), PermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PermissionVo $permissionVo) {
		try {
			$query = "update `permission`";
			$queryBuilder = new UpdateBuilder ( $permissionVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`permission`", $queryBuilder->getSql (), PermissionVo::class, "where (`permission_action_code` = #{permissionActionCode}) and (`type` = #{type})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PermissionVo $permissionVo) {
		try {
			$query = "delete from `permission`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`permission`", $query, PermissionVo::class, "where (`permission_action_code` = #{permissionActionCode}) and (`type` = #{type})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}