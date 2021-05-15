<?php

namespace common\persistence\extend\dao;

use common\filter\payment\PaymentFilter;
use common\persistence\base\dao\PaymentMethodBaseDao;
use common\persistence\extend\mapping\PaymentMethodExtendMapping;
use core\database\SqlMapClient;

class PaymentMethodExtendDao extends PaymentMethodBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(PaymentFilter $filter) {
		$result = $this->executeSelectList ( PaymentMethodExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(PaymentFilter $filter) {
		$result = $this->executeCount( PaymentMethodExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}