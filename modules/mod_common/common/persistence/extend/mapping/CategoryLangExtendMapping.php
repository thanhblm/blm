<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\CategoryLangExtendVo;
use core\database\SqlStatementInfo;

class CategoryLangExtendMapping {
	public function getLangsByCategoryId(CategoryLangExtendVo $filter) {
		try {
			$query = "select l.code, l.name as language_name, l.flag, r.* from language l 
					left join
						(select * from category_lang
					    where category_id = #{categoryId}
					    ) r on r.language_code = l.code
					order by l.name asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}