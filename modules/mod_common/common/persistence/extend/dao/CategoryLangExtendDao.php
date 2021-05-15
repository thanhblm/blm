<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CategoryLangBaseDao;
use common\persistence\extend\mapping\CategoryLangExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\CategoryLangExtendVo;

class CategoryLangExtendDao extends CategoryLangBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getLangsByCategoryId(CategoryLangExtendVo $filter = null) {
		$result = $this->executeSelectList ( CategoryLangExtendMapping::class, 'getLangsByCategoryId', $filter );
		return $result;
	}
}

