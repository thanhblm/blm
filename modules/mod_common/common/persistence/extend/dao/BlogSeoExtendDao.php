<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\mapping\BlogSeoExtendMapping;
use core\database\SqlMapClient;

class BlogSeoExtendDao extends SeoInfoLangBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByBlogId(BlogVo $blogVo){
		return $this->executeSelectList(BlogSeoExtendMapping::class, 'selectByBlogId',$blogVo);
	}
	
	public function deleteBlogSeoByBlog(BlogVo $blog){
		$result = $this->executeDelete ( BlogSeoExtendMapping::class, 'deleteBlogSeoByBlog', $blog );
		return $result;
	}
}