<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CategoryVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CategoryMapping {
	final public function selectByKey(CategoryVo $categoryVo) {
		try {
			$query = "select * from `category` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CategoryVo $categoryVo = null) {
		try {
			$query = "select * from `category`";
			$queryBuilder = new QueryBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CategoryVo $categoryVo) {
		try {
			$query = "select * from `category`";
			$queryBuilder = new QueryBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`level`", "level")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order_no`", "orderNo")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`bg_img`", "bgImg")
				->appendCondition ( "`small_icon`", "smallIcon")
				->appendCondition ( "`big_icon`", "bigIcon")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CategoryVo $categoryVo = null) {
		try {
			$query = "select count(*) from `category`";
			$queryBuilder = new QueryBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`level`", "level")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order_no`", "orderNo")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`bg_img`", "bgImg")
				->appendCondition ( "`small_icon`", "smallIcon")
				->appendCondition ( "`big_icon`", "bigIcon")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`introduction`", "introduction")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CategoryVo $categoryVo) {
		try {
			$query = "insert into `category`";
			$queryBuilder = new InsertBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendField("`parent_id`", "parentId")
				->appendField("`level`", "level")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`order_no`", "orderNo")
				->appendField("`featured`", "featured")
				->appendField("`bg_img`", "bgImg")
				->appendField("`small_icon`", "smallIcon")
				->appendField("`big_icon`", "bigIcon")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category`", $queryBuilder->getSql (), CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CategoryVo $categoryVo) {
		try {
			$query = "insert into `category`";
			$queryBuilder = new InsertBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`parent_id`", "parentId")
				->appendField("`level`", "level")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`order_no`", "orderNo")
				->appendField("`featured`", "featured")
				->appendField("`bg_img`", "bgImg")
				->appendField("`small_icon`", "smallIcon")
				->appendField("`big_icon`", "bigIcon")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category`", $queryBuilder->getSql (), CategoryVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CategoryVo $categoryVo) {
		try {
			$query = "update `category`";
			$queryBuilder = new UpdateBuilder ( $categoryVo, $query );
			$queryBuilder
				->appendField("`parent_id`", "parentId")
				->appendField("`level`", "level")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`order_no`", "orderNo")
				->appendField("`featured`", "featured")
				->appendField("`bg_img`", "bgImg")
				->appendField("`small_icon`", "smallIcon")
				->appendField("`big_icon`", "bigIcon")
				->appendField("`description`", "description")
				->appendField("`introduction`", "introduction")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`category`", $queryBuilder->getSql (), CategoryVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CategoryVo $categoryVo) {
		try {
			$query = "delete from `category`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`category`", $query, CategoryVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}