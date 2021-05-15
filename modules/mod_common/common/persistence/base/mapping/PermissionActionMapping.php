<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PermissionActionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PermissionActionMapping {
	final public function selectByKey(PermissionActionVo $permissionActionVo) {
		try {
			$query = "select * from `permission_action` where (`code` = #{code}) and (`action_type` = #{actionType}) and (`action` = #{action}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PermissionActionVo $permissionActionVo = null) {
		try {
			$query = "select * from `permission_action`";
			$queryBuilder = new QueryBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PermissionActionVo $permissionActionVo) {
		try {
			$query = "select * from `permission_action`";
			$queryBuilder = new QueryBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`action_type`", "actionType")
				->appendCondition ( "`action`", "action")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PermissionActionVo $permissionActionVo = null) {
		try {
			$query = "select count(*) from `permission_action`";
			$queryBuilder = new QueryBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`action_type`", "actionType")
				->appendCondition ( "`action`", "action");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PermissionActionVo $permissionActionVo) {
		try {
			$query = "insert into `permission_action`";
			$queryBuilder = new InsertBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`action_type`", "actionType")
				->appendField("`action`", "action");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`permission_action`", $queryBuilder->getSql (), PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PermissionActionVo $permissionActionVo) {
		try {
			$query = "insert into `permission_action`";
			$queryBuilder = new InsertBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`action_type`", "actionType")
				->appendField("`action`", "action");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`permission_action`", $queryBuilder->getSql (), PermissionActionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PermissionActionVo $permissionActionVo) {
		try {
			$query = "update `permission_action`";
			$queryBuilder = new UpdateBuilder ( $permissionActionVo, $query );
			$queryBuilder
				->appendField("`name`", "name");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`permission_action`", $queryBuilder->getSql (), PermissionActionVo::class, "where (`code` = #{code}) and (`action_type` = #{actionType}) and (`action` = #{action})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PermissionActionVo $permissionActionVo) {
		try {
			$query = "delete from `permission_action`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`permission_action`", $query, PermissionActionVo::class, "where (`code` = #{code}) and (`action_type` = #{actionType}) and (`action` = #{action})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}