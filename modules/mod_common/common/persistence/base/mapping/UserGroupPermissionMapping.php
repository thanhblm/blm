<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\UserGroupPermissionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class UserGroupPermissionMapping {
	final public function selectByKey(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "select * from `user_group_permission` where (`user_group_id` = #{userGroupId}) and (`permission_action_code` = #{permissionActionCode}) and (`permission_type` = #{permissionType}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(UserGroupPermissionVo $userGroupPermissionVo = null) {
		try {
			$query = "select * from `user_group_permission`";
			$queryBuilder = new QueryBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "select * from `user_group_permission`";
			$queryBuilder = new QueryBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder
				->appendCondition ( "`user_group_id`", "userGroupId")
				->appendCondition ( "`permission_action_code`", "permissionActionCode")
				->appendCondition ( "`permission_type`", "permissionType")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(UserGroupPermissionVo $userGroupPermissionVo = null) {
		try {
			$query = "select count(*) from `user_group_permission`";
			$queryBuilder = new QueryBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder
				->appendCondition ( "`user_group_id`", "userGroupId")
				->appendCondition ( "`permission_action_code`", "permissionActionCode")
				->appendCondition ( "`permission_type`", "permissionType");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "insert into `user_group_permission`";
			$queryBuilder = new InsertBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder
				->appendField("`user_group_id`", "userGroupId")
				->appendField("`permission_action_code`", "permissionActionCode")
				->appendField("`permission_type`", "permissionType");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_group_permission`", $queryBuilder->getSql (), UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "insert into `user_group_permission`";
			$queryBuilder = new InsertBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder
				->appendField("`user_group_id`", "userGroupId")
				->appendField("`permission_action_code`", "permissionActionCode")
				->appendField("`permission_type`", "permissionType");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_group_permission`", $queryBuilder->getSql (), UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "update `user_group_permission`";
			$queryBuilder = new UpdateBuilder ( $userGroupPermissionVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`user_group_permission`", $queryBuilder->getSql (), UserGroupPermissionVo::class, "where (`user_group_id` = #{userGroupId}) and (`permission_action_code` = #{permissionActionCode}) and (`permission_type` = #{permissionType})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "delete from `user_group_permission`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`user_group_permission`", $query, UserGroupPermissionVo::class, "where (`user_group_id` = #{userGroupId}) and (`permission_action_code` = #{permissionActionCode}) and (`permission_type` = #{permissionType})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}