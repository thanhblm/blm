<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class SeoInfoLangExtendMapping{
	public function getSeoInfoLangsByKey(SeoInfoLangExtendVo $filter){
		try {
			$query = "select l.code, l.name, l.flag, r.* from language l 
					left join
						(select * from seo_info_lang
					    where item_id = #{itemId} and `type`= #{type} 
					    ) r on r.language_code = l.code
					order by l.name asc";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, SeoInfoLangExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function deleteByFilter(SeoInfoLangVo $filter){
		try {
			$query = "delete from `seo_info_lang`";
			$queryBuilder = new QueryBuilder($filter, "");
			$queryBuilder
				->appendCondition("`item_id`", "itemId")
				->appendCondition("`type`", "type")
				->appendCondition("`language_code`", "languageCode");
			return new SqlStatementInfo (SqlStatementInfo::DELETE, null, $query, SeoInfoLangVo::class, $queryBuilder->getSql());
		} catch (\Exception $e) {
		}
	}

	public function getSeoInfoLangByCategory(SeoInfoLangVo $filter){
		try {
			$query = "
				select c.id, #{languageCode} as language_code, ifnull(si.url,'') as url from category c
				left join seo_info_lang si on si.item_id = c.id and si.type = 'category' and si.language_code = #{languageCode}
				where c.id = #{itemId}";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, SeoInfoLangVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getSeoInfoLangByCategoryBlog(SeoInfoLangVo $filter){
		try {
			$query = "
				select c.id, #{languageCode} as language_code, ifnull(si.url,'') as url from category c
				left join seo_info_lang si on si.item_id = c.id and si.type = 'category_blog' and si.language_code = #{languageCode}
				where c.id = #{itemId}";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, SeoInfoLangVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getSeoInfoLangByProduct(SeoInfoLangVo $filter){
		try {
			$query = "
				select p.id, #{languageCode} as language_code, ifnull(si.url,'') as url from product p
				left join seo_info_lang si on si.item_id = p.id and si.type = 'product' and si.language_code = #{languageCode}
				where p.id = #{itemId}";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, SeoInfoLangVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getSeoInfoLangByBlog(SeoInfoLangVo $filter){
		try {
			$query = "
				select b.id, si.language_code, ifnull(si.url,'') as url, si.title, si.keywords, si.description from blog b
				left join seo_info_lang si on si.item_id = b.id and si.type = 'blog' and si.language_code = #{languageCode}
				where b.id = #{itemId}";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, SeoInfoLangVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}