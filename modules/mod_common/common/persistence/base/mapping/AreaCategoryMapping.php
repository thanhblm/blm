<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AreaCategoryVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AreaCategoryMapping {
	final public function selectByKey(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "select * from `area_category` where (`area_id` = #{areaId}) and (`category_id` = #{categoryId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AreaCategoryVo $areaCategoryVo = null) {
		try {
			$query = "select * from `area_category`";
			$queryBuilder = new QueryBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "select * from `area_category`";
			$queryBuilder = new QueryBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendCondition ( "`area_id`", "areaId")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AreaCategoryVo $areaCategoryVo = null) {
		try {
			$query = "select count(*) from `area_category`";
			$queryBuilder = new QueryBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendCondition ( "`area_id`", "areaId")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "insert into `area_category`";
			$queryBuilder = new InsertBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendField("`area_id`", "areaId")
				->appendField("`category_id`", "categoryId")
				->appendField("`description`", "description")
				->appendField("`image`", "image")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`area_category`", $queryBuilder->getSql (), AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "insert into `area_category`";
			$queryBuilder = new InsertBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendField("`area_id`", "areaId")
				->appendField("`category_id`", "categoryId")
				->appendField("`description`", "description")
				->appendField("`image`", "image")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`area_category`", $queryBuilder->getSql (), AreaCategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "update `area_category`";
			$queryBuilder = new UpdateBuilder ( $areaCategoryVo, $query );
			$queryBuilder
				->appendField("`description`", "description")
				->appendField("`image`", "image")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`area_category`", $queryBuilder->getSql (), AreaCategoryVo::class, "where (`area_id` = #{areaId}) and (`category_id` = #{categoryId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AreaCategoryVo $areaCategoryVo) {
		try {
			$query = "delete from `area_category`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`area_category`", $query, AreaCategoryVo::class, "where (`area_id` = #{areaId}) and (`category_id` = #{categoryId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}