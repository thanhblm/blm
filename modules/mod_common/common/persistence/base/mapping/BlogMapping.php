<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BlogVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BlogMapping {
	final public function selectByKey(BlogVo $blogVo) {
		try {
			$query = "select * from `blog` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BlogVo $blogVo = null) {
		try {
			$query = "select * from `blog`";
			$queryBuilder = new QueryBuilder ( $blogVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BlogVo $blogVo) {
		try {
			$query = "select * from `blog`";
			$queryBuilder = new QueryBuilder ( $blogVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`category_blog_id`", "categoryBlogId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`images`", "images")
				->appendCondition ( "`is_seo`", "isSeo")
				->appendCondition ( "`tag`", "tag")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BlogVo $blogVo = null) {
		try {
			$query = "select count(*) from `blog`";
			$queryBuilder = new QueryBuilder ( $blogVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`category_blog_id`", "categoryBlogId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`composition`", "composition")
				->appendCondition ( "`featured`", "featured")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`images`", "images")
				->appendCondition ( "`is_seo`", "isSeo")
				->appendCondition ( "`tag`", "tag")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BlogVo $blogVo) {
		try {
			$query = "insert into `blog`";
			$queryBuilder = new InsertBuilder ( $blogVo, $query );
			$queryBuilder
				->appendField("`category_blog_id`", "categoryBlogId")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`is_seo`", "isSeo")
				->appendField("`tag`", "tag")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog`", $queryBuilder->getSql (), BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BlogVo $blogVo) {
		try {
			$query = "insert into `blog`";
			$queryBuilder = new InsertBuilder ( $blogVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`category_blog_id`", "categoryBlogId")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`is_seo`", "isSeo")
				->appendField("`tag`", "tag")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog`", $queryBuilder->getSql (), BlogVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BlogVo $blogVo) {
		try {
			$query = "update `blog`";
			$queryBuilder = new UpdateBuilder ( $blogVo, $query );
			$queryBuilder
				->appendField("`category_blog_id`", "categoryBlogId")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`description`", "description")
				->appendField("`composition`", "composition")
				->appendField("`featured`", "featured")
				->appendField("`page_id`", "pageId")
				->appendField("`images`", "images")
				->appendField("`is_seo`", "isSeo")
				->appendField("`tag`", "tag")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`blog`", $queryBuilder->getSql (), BlogVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BlogVo $blogVo) {
		try {
			$query = "delete from `blog`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog`", $query, BlogVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}