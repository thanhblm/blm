<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlogVo;
use common\persistence\extend\vo\BlogExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class BlogExtendMapping{
	public function getBlogByFilter(BlogVo $blogVo){
		try {
			$query = "
					select 
					c.*,
				    cu.user_name as cr_by_name,
				    mu.user_name as md_by_name
				from `blog` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder($blogVo, $query);
			$queryBuilder
				->appendCondition("c.`id`", "id")
				->appendCondition("c.`category_blog_id`", "categoryBlogId")
				->appendCondition("c.`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("c.`featured`", "featured")
				->appendCondition("c.`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function countBlogByFilter(BlogVo $blogVo = null){
		try {
			$query = "select count(*) from blog";
			$queryBuilder = new QueryBuilder($blogVo, $query);
			$queryBuilder
				->appendCondition("`id`", "id")
				->appendCondition("`code`", "code")
				->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`featured`", "featured")
				->appendCondition("`status`", "status");
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function countBlogByParentCatId(BlogVo $blogVo = null){
		try {
			$query = "select count(*) from blog";
			$queryBuilder = new QueryBuilder($blogVo, $query);
			$queryBuilder
				->appendCondition("`id`", "id")
				->appendCondition("`code`", "code")
				->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`featured`", "featured")
				->appendCondition("`status`", "status");
			$query = $queryBuilder->getSql();
			if (!is_null($blogVo->categoryBlogId)) {
				if (strpos($query, 'where') !== false) {
					$query .= " and category_blog_id in " . $blogVo->categoryBlogId;
				} else {
					$query .= " where category_blog_id in " . $blogVo->categoryBlogId;
				}

			}

			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $query, BlogVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getBlogByParentCatId(BlogVo $blogVo){
		try {
			$query = "select b.*, cb.name as category_name from blog b
					inner join category_blog cb on cb.id = b.category_blog_id
				";
			$queryBuilder = new QueryBuilder($blogVo, $query);
			$queryBuilder
				->appendCondition("b.`id`", "id")
				->appendCondition("b.`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("b.`featured`", "featured")
				->appendCondition("b.`status`", "status");

			$query = $queryBuilder->getSql();
			if (!is_null($blogVo->categoryBlogId)) {
				if (strpos($query, 'where') !== false) {
					$query .= " and cb.status='active' and category_blog_id in " . $blogVo->categoryBlogId;
				} else {
					$query .= " where cb.status='active' and category_blog_id in " . $blogVo->categoryBlogId;
				}
			}

			$queryBuilder = new QueryBuilder($blogVo, $query);
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}