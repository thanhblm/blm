<?php
namespace common\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\mapping\BlogRelationExtendMapping;
use common\persistence\base\dao\BlogRelationBaseDao;


class BlogRelationExtendDao extends BlogRelationBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectBlogRelationByBlogId(BlogVo $blog){
		return $this->executeSelectList(BlogRelationExtendMapping::class, 'selectBlogRelationByBlogId',$blog);
	}
	
	public function deleteBlogRelationByBlog(BlogVo $blog){
		$result = $this->executeDelete ( BlogRelationExtendMapping::class, 'deleteBlogRelationByBlog', $blog );
		return $result;
	}
}