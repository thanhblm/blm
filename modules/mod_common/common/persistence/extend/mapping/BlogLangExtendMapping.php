<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlogLangVo;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\vo\BlogLangExtendVo;
use core\database\SqlStatementInfo;

class BlogLangExtendMapping {
	public function selectByBlogId(BlogVo $blog) {
		try {
			$query = "select pl.blog_id, l.code as language_code, l.name as language_name, l.flag, pl.name, pl.description, pl.composition from `language` as l 
				left join
					(select * from blog_lang 
					where blog_id = #{id}
					) as pl on l.code = pl.language_code 
				order by l.name";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteBlogLangByBlog(BlogVo $blog) {
		try {
			$query = "delete from `blog_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_lang`", $query, BlogLangVo::class, "where (`blog_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}