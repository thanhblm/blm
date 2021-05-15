<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CategoryBlogVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CategoryBlogMapping {
	final public function selectByKey(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "select * from `category_blog` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CategoryBlogVo $categoryBlogVo = null) {
		try {
			$query = "select * from `category_blog`";
			$queryBuilder = new QueryBuilder ( $categoryBlogVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "select * from `category_blog`";
			$queryBuilder = new QueryBuilder ( $categoryBlogVo, $query );
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
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CategoryBlogVo $categoryBlogVo = null) {
		try {
			$query = "select count(*) from `category_blog`";
			$queryBuilder = new QueryBuilder ( $categoryBlogVo, $query );
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
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "insert into `category_blog`";
			$queryBuilder = new InsertBuilder ( $categoryBlogVo, $query );
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
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_blog`", $queryBuilder->getSql (), CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "insert into `category_blog`";
			$queryBuilder = new InsertBuilder ( $categoryBlogVo, $query );
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
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`category_blog`", $queryBuilder->getSql (), CategoryBlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "update `category_blog`";
			$queryBuilder = new UpdateBuilder ( $categoryBlogVo, $query );
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
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`category_blog`", $queryBuilder->getSql (), CategoryBlogVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CategoryBlogVo $categoryBlogVo) {
		try {
			$query = "delete from `category_blog`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`category_blog`", $query, CategoryBlogVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}