<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\AccountTypeBaseDao;
use common\persistence\extend\mapping\AccountTypeExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\vo\AccountTypeVo;

class AccountTypeExtendDao extends AccountTypeBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(AccountTypeVo $accountTypeVo) {
		$result = $this->executeSelectList ( AccountTypeExtendMapping::class, 'search', $accountTypeVo);
		return $result;
	}
	
	public function searchCount(AccountTypeVo $accountTypeVo) {
		$result = $this->executeCount( AccountTypeExtendMapping::class, 'searchCount', $accountTypeVo);
		return $result;
	}
	
}