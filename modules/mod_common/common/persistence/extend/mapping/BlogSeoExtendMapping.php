<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlogVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\BlogSeoExtendVo;
use core\database\SqlStatementInfo;

class BlogSeoExtendMapping {
	public function selectByBlogId(BlogVo $blog) {
		try {
			$query = "select sl.item_id, l.code as language_code, l.name as language_name, l.flag, sl.url, sl.title, sl.keywords, sl.description from `language` as l 
			left join
				(select * from seo_info_lang where type = 'blog' and item_id = #{id}
				) as sl on l.code = sl.language_code 
			order by l.name";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogSeoExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteBlogSeoByBlog(BlogVo $blog) {
		try {
			$query = "delete from `seo_info_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_lang`", $query, SeoInfoLangVo::class, "where type='blog' and (`item_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}