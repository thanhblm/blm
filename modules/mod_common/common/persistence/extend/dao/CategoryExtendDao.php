<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CategoryBaseDao;
use common\persistence\extend\mapping\CategoryExtendMapping;
use common\persistence\extend\vo\CategoryExtendVo;
use core\database\SqlMapClient;

class CategoryExtendDao extends CategoryBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(CategoryExtendVo $filter = null) {
		$result = $this->executeSelectList ( CategoryExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(CategoryExtendVo $filter = null) {
		$result = $this->executeCount ( CategoryExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}

