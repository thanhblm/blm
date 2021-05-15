<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\TemplateVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class TemplateMapping {
	final public function selectByKey(TemplateVo $templateVo) {
		try {
			$query = "select * from `template` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(TemplateVo $templateVo = null) {
		try {
			$query = "select * from `template`";
			$queryBuilder = new QueryBuilder ( $templateVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(TemplateVo $templateVo) {
		try {
			$query = "select * from `template`";
			$queryBuilder = new QueryBuilder ( $templateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`header_id`", "headerId")
				->appendCondition ( "`footer_id`", "footerId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(TemplateVo $templateVo = null) {
		try {
			$query = "select count(*) from `template`";
			$queryBuilder = new QueryBuilder ( $templateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`header_id`", "headerId")
				->appendCondition ( "`footer_id`", "footerId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(TemplateVo $templateVo) {
		try {
			$query = "insert into `template`";
			$queryBuilder = new InsertBuilder ( $templateVo, $query );
			$queryBuilder
				->appendField("`header_id`", "headerId")
				->appendField("`footer_id`", "footerId")
				->appendField("`name`", "name")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`template`", $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(TemplateVo $templateVo) {
		try {
			$query = "insert into `template`";
			$queryBuilder = new InsertBuilder ( $templateVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`header_id`", "headerId")
				->appendField("`footer_id`", "footerId")
				->appendField("`name`", "name")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`template`", $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(TemplateVo $templateVo) {
		try {
			$query = "update `template`";
			$queryBuilder = new UpdateBuilder ( $templateVo, $query );
			$queryBuilder
				->appendField("`header_id`", "headerId")
				->appendField("`footer_id`", "footerId")
				->appendField("`name`", "name")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`template`", $queryBuilder->getSql (), TemplateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(TemplateVo $templateVo) {
		try {
			$query = "delete from `template`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`template`", $query, TemplateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}