<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PageVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PageMapping {
	final public function selectByKey(PageVo $pageVo) {
		try {
			$query = "select * from `page` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PageVo $pageVo = null) {
		try {
			$query = "select * from `page`";
			$queryBuilder = new QueryBuilder ( $pageVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PageVo $pageVo) {
		try {
			$query = "select * from `page`";
			$queryBuilder = new QueryBuilder ( $pageVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`template_id`", "templateId")
				->appendCondition ( "`action`", "action")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cache_enable`", "cacheEnable")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PageVo $pageVo = null) {
		try {
			$query = "select count(*) from `page`";
			$queryBuilder = new QueryBuilder ( $pageVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`template_id`", "templateId")
				->appendCondition ( "`action`", "action")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cache_enable`", "cacheEnable")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PageVo $pageVo) {
		try {
			$query = "insert into `page`";
			$queryBuilder = new InsertBuilder ( $pageVo, $query );
			$queryBuilder
				->appendField("`template_id`", "templateId")
				->appendField("`action`", "action")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`cache_enable`", "cacheEnable")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page`", $queryBuilder->getSql (), PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PageVo $pageVo) {
		try {
			$query = "insert into `page`";
			$queryBuilder = new InsertBuilder ( $pageVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`template_id`", "templateId")
				->appendField("`action`", "action")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`cache_enable`", "cacheEnable")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`page`", $queryBuilder->getSql (), PageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PageVo $pageVo) {
		try {
			$query = "update `page`";
			$queryBuilder = new UpdateBuilder ( $pageVo, $query );
			$queryBuilder
				->appendField("`template_id`", "templateId")
				->appendField("`action`", "action")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`cache_enable`", "cacheEnable")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`page`", $queryBuilder->getSql (), PageVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PageVo $pageVo) {
		try {
			$query = "delete from `page`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`page`", $query, PageVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}