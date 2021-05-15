<?php
namespace common\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\vo\BlogVo;
use common\persistence\base\dao\BlogLangBaseDao;
use common\persistence\extend\mapping\BlogLangExtendMapping;

class BlogLangExtendDao extends BlogLangBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByBlogId(BlogVo $blogVo){
		return $this->executeSelectList(BlogLangExtendMapping::class, 'selectByBlogId',$blogVo);
	}
	
	public function deleteBlogLangByBlog(BlogVo $blog){
		$result = $this->executeDelete ( BlogLangExtendMapping::class, 'deleteBlogLangByBlog', $blog );
		return $result;
	}
}