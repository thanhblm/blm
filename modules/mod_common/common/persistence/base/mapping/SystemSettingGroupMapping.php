<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SystemSettingGroupVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SystemSettingGroupMapping {
	final public function selectByKey(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "select * from `system_setting_group` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SystemSettingGroupVo $systemSettingGroupVo = null) {
		try {
			$query = "select * from `system_setting_group`";
			$queryBuilder = new QueryBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "select * from `system_setting_group`";
			$queryBuilder = new QueryBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SystemSettingGroupVo $systemSettingGroupVo = null) {
		try {
			$query = "select count(*) from `system_setting_group`";
			$queryBuilder = new QueryBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "insert into `system_setting_group`";
			$queryBuilder = new InsertBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`system_setting_group`", $queryBuilder->getSql (), SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "insert into `system_setting_group`";
			$queryBuilder = new InsertBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`system_setting_group`", $queryBuilder->getSql (), SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "update `system_setting_group`";
			$queryBuilder = new UpdateBuilder ( $systemSettingGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`system_setting_group`", $queryBuilder->getSql (), SystemSettingGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "delete from `system_setting_group`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`system_setting_group`", $query, SystemSettingGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}