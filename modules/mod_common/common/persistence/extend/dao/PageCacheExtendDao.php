<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\PageCacheBaseDao;
use common\persistence\base\vo\PageCacheVo;
use common\persistence\extend\mapping\PageCacheExtendMapping;
use core\database\SqlMapClient;

class PageCacheExtendDao extends PageCacheBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function deleteByPageId(PageCacheVo $filter = null) {
		$result = $this->executeDelete ( PageCacheExtendMapping::class, 'deleteByPageId', $filter );
		return $result;
	}
}