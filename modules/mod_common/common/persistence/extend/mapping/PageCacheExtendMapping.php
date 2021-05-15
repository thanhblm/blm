<?php

namespace common\persistence\extend\mapping;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\PageCacheVo;
use core\database\QueryBuilder;

class PageCacheExtendMapping {
	public function deleteByPageId(PageCacheVo $filter) {
		try {
			$query = "delete from `page_cache`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, PageCacheVo::class, " where `page_id` = #{pageId}" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}