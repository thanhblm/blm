<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\PageLangBaseDao;
use common\persistence\extend\mapping\PageLangExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\PageLangExtendVo;

class PageLangExtendDao extends PageLangBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getLangsByPageId(PageLangExtendVo $filter = null) {
		$result = $this->executeSelectList ( PageLangExtendMapping::class, 'getLangsByPageId', $filter );
		return $result;
	}
}

