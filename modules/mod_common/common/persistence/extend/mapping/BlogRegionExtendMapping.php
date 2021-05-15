<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlogRegionVo;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\vo\BlogRegionExtendVo;
use core\database\SqlStatementInfo;

class BlogRegionExtendMapping {
	public function selectBlogRegionByBlogId(BlogVo $blog) {
		try {
			$query = "select r.id as region_id, r.name, pr.blog_id from region as r 
				left join
					(select * from blog_region 
					where blog_id = #{id}) as pr on r.id = pr.region_id";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogRegionExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteBlogRegionByBlog(BlogVo $blog) {
		try {
			$query = "delete from `blog_region`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_region`", $query, BlogRegionVo::class, "where (`blog_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}