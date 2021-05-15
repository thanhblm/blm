<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SystemSettingVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SystemSettingMapping {
	final public function selectByKey(SystemSettingVo $systemSettingVo) {
		try {
			$query = "select * from `system_setting` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SystemSettingVo $systemSettingVo = null) {
		try {
			$query = "select * from `system_setting`";
			$queryBuilder = new QueryBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SystemSettingVo $systemSettingVo) {
		try {
			$query = "select * from `system_setting`";
			$queryBuilder = new QueryBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`system_setting_group_id`", "systemSettingGroupId")
				->appendCondition ( "`value`", "value")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`value_list`", "valueList")
				->appendCondition ( "`allow_null`", "allowNull")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SystemSettingVo $systemSettingVo = null) {
		try {
			$query = "select count(*) from `system_setting`";
			$queryBuilder = new QueryBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`system_setting_group_id`", "systemSettingGroupId")
				->appendCondition ( "`value`", "value")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`value_list`", "valueList")
				->appendCondition ( "`allow_null`", "allowNull")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SystemSettingVo $systemSettingVo) {
		try {
			$query = "insert into `system_setting`";
			$queryBuilder = new InsertBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`system_setting_group_id`", "systemSettingGroupId")
				->appendField("`value`", "value")
				->appendField("`type`", "type")
				->appendField("`description`", "description")
				->appendField("`value_list`", "valueList")
				->appendField("`allow_null`", "allowNull")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`system_setting`", $queryBuilder->getSql (), SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SystemSettingVo $systemSettingVo) {
		try {
			$query = "insert into `system_setting`";
			$queryBuilder = new InsertBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`system_setting_group_id`", "systemSettingGroupId")
				->appendField("`value`", "value")
				->appendField("`type`", "type")
				->appendField("`description`", "description")
				->appendField("`value_list`", "valueList")
				->appendField("`allow_null`", "allowNull")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`system_setting`", $queryBuilder->getSql (), SystemSettingVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SystemSettingVo $systemSettingVo) {
		try {
			$query = "update `system_setting`";
			$queryBuilder = new UpdateBuilder ( $systemSettingVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`system_setting_group_id`", "systemSettingGroupId")
				->appendField("`value`", "value")
				->appendField("`type`", "type")
				->appendField("`description`", "description")
				->appendField("`value_list`", "valueList")
				->appendField("`allow_null`", "allowNull")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`system_setting`", $queryBuilder->getSql (), SystemSettingVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SystemSettingVo $systemSettingVo) {
		try {
			$query = "delete from `system_setting`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`system_setting`", $query, SystemSettingVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}