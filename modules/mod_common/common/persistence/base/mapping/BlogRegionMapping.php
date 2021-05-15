<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BlogRegionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BlogRegionMapping {
	final public function selectByKey(BlogRegionVo $blogRegionVo) {
		try {
			$query = "select * from `blog_region` where (`blog_id` = #{blogId}) and (`region_id` = #{regionId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BlogRegionVo $blogRegionVo = null) {
		try {
			$query = "select * from `blog_region`";
			$queryBuilder = new QueryBuilder ( $blogRegionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BlogRegionVo $blogRegionVo) {
		try {
			$query = "select * from `blog_region`";
			$queryBuilder = new QueryBuilder ( $blogRegionVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`region_id`", "regionId")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BlogRegionVo $blogRegionVo = null) {
		try {
			$query = "select count(*) from `blog_region`";
			$queryBuilder = new QueryBuilder ( $blogRegionVo, $query );
			$queryBuilder
				->appendCondition ( "`blog_id`", "blogId")
				->appendCondition ( "`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BlogRegionVo $blogRegionVo) {
		try {
			$query = "insert into `blog_region`";
			$queryBuilder = new InsertBuilder ( $blogRegionVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_region`", $queryBuilder->getSql (), BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BlogRegionVo $blogRegionVo) {
		try {
			$query = "insert into `blog_region`";
			$queryBuilder = new InsertBuilder ( $blogRegionVo, $query );
			$queryBuilder
				->appendField("`blog_id`", "blogId")
				->appendField("`region_id`", "regionId");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`blog_region`", $queryBuilder->getSql (), BlogRegionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BlogRegionVo $blogRegionVo) {
		try {
			$query = "update `blog_region`";
			$queryBuilder = new UpdateBuilder ( $blogRegionVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`blog_region`", $queryBuilder->getSql (), BlogRegionVo::class, "where (`blog_id` = #{blogId}) and (`region_id` = #{regionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BlogRegionVo $blogRegionVo) {
		try {
			$query = "delete from `blog_region`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_region`", $query, BlogRegionVo::class, "where (`blog_id` = #{blogId}) and (`region_id` = #{regionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}