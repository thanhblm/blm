<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\UrlRedirectBaseDao;
use common\persistence\extend\mapping\UrlRedirectExtendMapping;
use common\persistence\extend\vo\UrlRedirectExtendVo;
use core\database\SqlMapClient;

class UrlRedirectExtendDao extends UrlRedirectBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getByFilter(UrlRedirectExtendVo $urlRedirectExtend = null) {
		$result = $this->executeSelectList ( UrlRedirectExtendMapping::class, 'getByFilter', $urlRedirectExtend );
		return $result;
	}
	final public function getCountByFilter(UrlRedirectExtendVo $urlRedirectExtend = null) {
		$result = $this->executeCount ( UrlRedirectExtendMapping::class, 'getCountByFilter', $urlRedirectExtend );
		return $result;
	}
}

