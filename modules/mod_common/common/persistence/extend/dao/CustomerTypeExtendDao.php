<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CustomerTypeBaseDao;
use common\persistence\extend\mapping\CustomerTypeExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\vo\CustomerTypeVo;

class CustomerTypeExtendDao extends CustomerTypeBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(CustomerTypeVo $accountTypeVo) {
		$result = $this->executeSelectList ( CustomerTypeExtendMapping::class, 'search', $accountTypeVo);
		return $result;
	}
	
	public function searchCount(CustomerTypeVo $accountTypeVo) {
		$result = $this->executeCount( CustomerTypeExtendMapping::class, 'searchCount', $accountTypeVo);
		return $result;
	}
	
}