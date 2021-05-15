<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\CategoryBlogLangExtendVo;
use core\database\SqlStatementInfo;

class CategoryBlogLangExtendMapping {
	public function getLangsByCategoryBlogId(CategoryBlogLangExtendVo $filter) {
		try {
			$query = "select l.code, l.name as language_name, l.flag, r.* from language l 
					left join
						(select * from category_blog_lang
					    where category_blog_id = #{categoryBlogId}
					    ) r on r.language_code = l.code
					order by l.name asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CategoryBlogLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}