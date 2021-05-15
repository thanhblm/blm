<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\PageLangExtendVo;
use core\database\SqlStatementInfo;

class PageLangExtendMapping {
	public function getLangsByPageId(PageLangExtendVo $filter) {
		try {
			$query = "
				select l.code, l.name as language_name, l.flag, r.* from language l
				left join
					(select * from page_lang
				    where page_id = #{pageId}
				    ) r on r.language_code = l.code
				order by l.name asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PageLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}