<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\BlogRegionBaseDao;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\mapping\BlogRegionExtendMapping;
use core\database\SqlMapClient;


class BlogRegionExtendDao extends BlogRegionBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectBlogRegionByBlogId(BlogVo $blog){
		return $this->executeSelectList(BlogRegionExtendMapping::class, 'selectBlogRegionByBlogId',$blog);
	}
	
	public function deleteBlogRegionByBlog(BlogVo $blog){
		$result = $this->executeDelete ( BlogRegionExtendMapping::class, 'deleteBlogRegionByBlog', $blog );
		return $result;
	}
}