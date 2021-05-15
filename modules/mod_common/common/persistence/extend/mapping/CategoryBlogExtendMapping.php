<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\persistence\extend\vo\CategoryBlogHomeExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class CategoryBlogExtendMapping {
	public function getByFilterFull(CategoryBlogHomeExtendVo $categoryBlogExtendVo) {
		try {
			$query = "
				select 
					c.*, 
				    cu.user_name as cr_by_name,
				    mu.user_name as md_by_name,
				    sil.url as seo_url,
					sil.language_code,
					sil.title as seo_title,
					sil.keywords as seo_keywords,
					sil.description as seo_description
				from `category_blog` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by
				left join seo_info_lang sil on sil.type = 'category_blog' and sil.language_code = #{languageCode} and sil.item_id = c.id";
			$queryBuilder = new QueryBuilder( $categoryBlogExtendVo, $query );
			$queryBuilder
				->appendCondition ( "c.id", "id")
				->appendCondition ( "c.code", "code")
				->appendCondition ( "c.name", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.status", "status")
				->appendCondition ( "c.featured", "featured")
				->appendCondition ( "c.cr_date", "crDateFrom", ">=")
				->appendCondition ( "c.cr_date", "crDateTo", "<=")
				->appendCondition ( "c.md_date", "mdDateFrom", ">=")
				->appendCondition ( "c.md_date", "mdDateTo", "<=")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryBlogHomeExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}


	public function getByFilter(CategoryBlogExtendVo $categoryBlogExtendVo) {
		try {
			$query = "
				select 
					c.*, 
				    cu.user_name as cr_by_name,
				    mu.user_name as md_by_name
				from `category_blog` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $categoryBlogExtendVo, $query );
			$queryBuilder
			->appendCondition ( "c.id", "id")
			->appendCondition ( "c.code", "code")
			->appendCondition ( "c.name", "name", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "c.status", "status")
			->appendCondition ( "c.featured", "featured")
			->appendCondition ( "c.cr_date", "crDateFrom", ">=")
			->appendCondition ( "c.cr_date", "crDateTo", "<=")
			->appendCondition ( "c.md_date", "mdDateFrom", ">=")
			->appendCondition ( "c.md_date", "mdDateTo", "<=")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryBlogExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(CategoryBlogExtendVo $categoryBlogExtendVo = null) {
		try {
			$query = "
				select 
					count(*)
				from `category_blog` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $categoryBlogExtendVo, $query );
				$queryBuilder
				->appendCondition ( "c.id", "id")
				->appendCondition ( "c.code", "code")
				->appendCondition ( "c.name", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.status", "status")
				->appendCondition ( "c.featured", "featured")
				->appendCondition ( "c.cr_date", "crDateFrom", ">=")
				->appendCondition ( "c.cr_date", "crDateTo", "<=")
				->appendCondition ( "c.md_date", "mdDateFrom", ">=")
				->appendCondition ( "c.md_date", "mdDateTo", "<=");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryBlogExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}