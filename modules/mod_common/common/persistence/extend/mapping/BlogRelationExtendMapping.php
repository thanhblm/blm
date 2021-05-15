<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlogRelateVo;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\vo\BlogRelationExtendVo;
use core\database\SqlStatementInfo;

class BlogRelationExtendMapping {
	public function selectBlogRelationByBlogId(BlogVo $blog) {
		try {
			$query = "select pr.*, p.name from blog_relation as pr 
				inner join blog as p on pr.relate_blog_id = p.id 
				where blog_id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlogRelationExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteBlogRelationByBlog(BlogVo $blog) {
		try {
			$query = "delete from `blog_relation`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`blog_relate`", $query, BlogRelateVo::class, "where (`blog_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}