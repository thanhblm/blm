<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CategoryBlogLangBaseDao;
use common\persistence\extend\mapping\CategoryBlogLangExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\CategoryBlogLangExtendVo;

class CategoryBlogLangExtendDao extends CategoryBlogLangBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getLangsByCategoryBlogId(CategoryBlogLangExtendVo $filter = null) {
		$result = $this->executeSelectList ( CategoryBlogLangExtendMapping::class, 'getLangsByCategoryBlogId', $filter );
		return $result;
	}
}

