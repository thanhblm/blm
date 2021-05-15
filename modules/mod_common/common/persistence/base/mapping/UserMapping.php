<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\UserVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class UserMapping {
	final public function selectByKey(UserVo $userVo) {
		try {
			$query = "select * from `user` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(UserVo $userVo = null) {
		try {
			$query = "select * from `user`";
			$queryBuilder = new QueryBuilder ( $userVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(UserVo $userVo) {
		try {
			$query = "select * from `user`";
			$queryBuilder = new QueryBuilder ( $userVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_name`", "userName")
				->appendCondition ( "`password`", "password")
				->appendCondition ( "`user_type`", "userType")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`full_name`", "fullName")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`user_group_id`", "userGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(UserVo $userVo = null) {
		try {
			$query = "select count(*) from `user`";
			$queryBuilder = new QueryBuilder ( $userVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_name`", "userName")
				->appendCondition ( "`password`", "password")
				->appendCondition ( "`user_type`", "userType")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`full_name`", "fullName")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`user_group_id`", "userGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(UserVo $userVo) {
		try {
			$query = "insert into `user`";
			$queryBuilder = new InsertBuilder ( $userVo, $query );
			$queryBuilder
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`user_type`", "userType")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`full_name`", "fullName")
				->appendField("`status`", "status")
				->appendField("`user_group_id`", "userGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user`", $queryBuilder->getSql (), UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(UserVo $userVo) {
		try {
			$query = "insert into `user`";
			$queryBuilder = new InsertBuilder ( $userVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`user_type`", "userType")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`full_name`", "fullName")
				->appendField("`status`", "status")
				->appendField("`user_group_id`", "userGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user`", $queryBuilder->getSql (), UserVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(UserVo $userVo) {
		try {
			$query = "update `user`";
			$queryBuilder = new UpdateBuilder ( $userVo, $query );
			$queryBuilder
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`user_type`", "userType")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`full_name`", "fullName")
				->appendField("`status`", "status")
				->appendField("`user_group_id`", "userGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`user`", $queryBuilder->getSql (), UserVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(UserVo $userVo) {
		try {
			$query = "delete from `user`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`user`", $query, UserVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}