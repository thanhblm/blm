<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\UserGroupVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class UserGroupMapping {
	final public function selectByKey(UserGroupVo $userGroupVo) {
		try {
			$query = "select * from `user_group` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(UserGroupVo $userGroupVo = null) {
		try {
			$query = "select * from `user_group`";
			$queryBuilder = new QueryBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(UserGroupVo $userGroupVo) {
		try {
			$query = "select * from `user_group`";
			$queryBuilder = new QueryBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(UserGroupVo $userGroupVo = null) {
		try {
			$query = "select count(*) from `user_group`";
			$queryBuilder = new QueryBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(UserGroupVo $userGroupVo) {
		try {
			$query = "insert into `user_group`";
			$queryBuilder = new InsertBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_group`", $queryBuilder->getSql (), UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(UserGroupVo $userGroupVo) {
		try {
			$query = "insert into `user_group`";
			$queryBuilder = new InsertBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_group`", $queryBuilder->getSql (), UserGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(UserGroupVo $userGroupVo) {
		try {
			$query = "update `user_group`";
			$queryBuilder = new UpdateBuilder ( $userGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`user_group`", $queryBuilder->getSql (), UserGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(UserGroupVo $userGroupVo) {
		try {
			$query = "delete from `user_group`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`user_group`", $query, UserGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}