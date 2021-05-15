<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\BlogBaseDao;
use common\persistence\base\vo\BlogVo;
use common\persistence\extend\mapping\BlogExtendMapping;
use core\database\SqlMapClient;

class BlogExtendDao extends BlogBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getBlogByFilter(BlogVo $blogVo){
		$result = $this->executeSelectList(BlogExtendMapping::class, 'getBlogByFilter', $blogVo);
		return $result;
	}

	public function countBlogByFilter(BlogVo $blogVo = null){
		$result = $this->executeCount(BlogExtendMapping::class, 'countBlogByFilter', $blogVo);
		return $result;
	}

	public function countBlogByParentCatId(BlogVo $blogVo = null){
		$result = $this->executeCount(BlogExtendMapping::class, 'countBlogByParentCatId', $blogVo);
		return $result;
	}

	public function getBlogByParentCatId(BlogVo $blogVo = null){
		$result = $this->executeSelectList(BlogExtendMapping::class, 'getBlogByParentCatId', $blogVo);
		return $result;
	}
}