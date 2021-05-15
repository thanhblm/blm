<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\GridVo;
use common\persistence\base\vo\PageLangVo;
use common\persistence\base\vo\PageVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\base\vo\WidgetVo;
use common\persistence\extend\vo\PageExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class PageExtendMapping {
	public function getGridListOfPage(PageVo $pageVo){
		try {
			$query = "
				SELECT g.* FROM `grid` AS g
				LEFT JOIN container AS c ON c.id = g.container_id
				LEFT JOIN `page` AS p ON p.id = c.page_id
				WHERE p.id = #{id}
				ORDER BY g.`order` ASC, g.`id` ASC";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, GridVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getWidgetListOfPage(PageVo $pageVo){
		try {
			$query = "
				SELECT DISTINCT w.* FROM widget AS w
				LEFT JOIN widget_content AS wc ON wc.widget_id = w.id
				LEFT JOIN grid_widget AS gw ON gw.widget_content_id = wc.id
				LEFT JOIN grid AS g ON g.id = gw.grid_id
				LEFT JOIN container AS c ON c.id = g.container_id
				LEFT JOIN `page` AS p ON p.id = c.page_id
				WHERE p.id = #{id}";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, WidgetVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * ***************************
	 * FILTER
	 * ***************************
	 */
	public function getPageByFilter(PageExtendVo $pageVo){
		try {
			$query = "SELECT * FROM `page`";
			$queryBuilder = new QueryBuilder($pageVo, $query);
			$queryBuilder
				->appendCondition("`id`", "id")
				->appendCondition("`action`", "action")
				->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`description`", "description", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`is_temp`", "isTemp")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), PageExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountByFilter(PageExtendVo $pageVo = null){
		try {
			$query = "SELECT count(*) FROM `page`";
			$queryBuilder = new QueryBuilder($pageVo, $query);
			$queryBuilder
				->appendCondition("`id`", "id")
				->appendCondition("`action`", "action")
				->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`description`", "description", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition("`is_temp`", "isTemp");
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), PageVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function deletePageLang(PageLangVo $filter){
		try {
			$query = "DELETE FROM page_lang";
			return new SqlStatementInfo (SqlStatementInfo::DELETE, null, $query, PageLangVo::class, "where page_id = #{pageId}");
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getPageInfoBySeoUrl(SeoInfoLangVo $filter){
		try {
			$query = "SELECT
						p.*
					FROM seo_info_lang AS s
						LEFT JOIN 
						page AS p ON p.id = s.item_id
					WHERE type = 'page' AND s.url = #{url}
						GROUP BY p.name";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, PageVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}