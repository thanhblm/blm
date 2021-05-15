<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BlogRelationVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BlogRelationMapping {
	final public function selectByKey(BlogRelationVo $blogRelationVo) {
		try {
			$query = "select * from `blog_relation` where (`blog_id` = #{blogId}) and (`relate_blog_id` = #{relateBlogId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BlogRelationVo $blogRelationVo = null) {
		try {
			$query = "select * from `blog_relation`";
			$queryBuilder = new QueryBuilder ( $blogRelationVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BlogRelationVo $blogRelationVo) {
		try {
			$query = "select * from `blog_relation`";
			$queryBuilder = new QueryBuilder ( $blogRelationVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`relate_blog_id`", "relateBlogId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BlogRelationVo $blogRelationVo = null) {
		try {
			$query = "select count(*) from `blog_relation`";
			$queryBuilder = new QueryBuilder ( $blogRelationVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`relate_blog_id`", "relateBlogId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BlogRelationVo $blogRelationVo) {
		try {
			$query = "insert into `blog_relation`";
			$queryBuilder = new InsertBuilder ( $blogRelationVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`relate_blog_id`", "relateBlogId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_relation`", $queryBuilder->getSql (), BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BlogRelationVo $blogRelationVo) {
		try {
			$query = "insert into `blog_relation`";
			$queryBuilder = new InsertBuilder ( $blogRelationVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`relate_blog_id`", "relateBlogId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_relation`", $queryBuilder->getSql (), BlogRelationVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BlogRelationVo $blogRelationVo) {
		try {
			$query = "update `blog_relation`";
			$queryBuilder = new UpdateBuilder ( $blogRelationVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`blog_relation`", $queryBuilder->getSql (), BlogRelationVo::class, "where (`blog_id` = #{blogId}) and (`relate_blog_id` = #{relateBlogId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BlogRelationVo $blogRelationVo) {
		try {
			$query = "delete from `blog_relation`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_relation`", $query, BlogRelationVo::class, "where (`blog_id` = #{blogId}) and (`relate_blog_id` = #{relateBlogId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}