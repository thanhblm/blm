<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CurrencyBaseDao;
use common\persistence\extend\mapping\CurrencyExtendMapping;
use common\persistence\extend\vo\CurrencyExtendVo;
use core\database\SqlMapClient;

class CurrencyExtendDao extends CurrencyBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getByFilter(CurrencyExtendVo $currencyVo = null) {
		$result = $this->executeSelectList ( CurrencyExtendMapping::class, 'getByFilter', $currencyVo );
		return $result;
	}
	final public function getCountByFilter(CurrencyExtendVo $currencyVo = null) {
		$result = $this->executeCount ( CurrencyExtendMapping::class, 'getCountByFilter', $currencyVo );
		return $result;
	}
}

