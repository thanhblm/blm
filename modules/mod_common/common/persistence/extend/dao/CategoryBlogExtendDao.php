<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CategoryBlogBaseDao;
use common\persistence\extend\mapping\CategoryBlogExtendMapping;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use core\database\SqlMapClient;

class CategoryBlogExtendDao extends CategoryBlogBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getByFilter(CategoryBlogExtendVo $filter = null){
		$result = $this->executeSelectList(CategoryBlogExtendMapping::class, 'getByFilter', $filter);
		return $result;
	}

	public function getCountByFilter(CategoryBlogExtendVo $filter = null){
		$result = $this->executeCount(CategoryBlogExtendMapping::class, 'getCountByFilter', $filter);
		return $result;
	}
}

