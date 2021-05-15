<?php

namespace common\persistence\extend\dao;

use common\filter\shipping\ShippingFilter;
use common\persistence\base\dao\ShippingMethodBaseDao;
use common\persistence\extend\mapping\ShippingMethodExtendMapping;
use core\database\SqlMapClient;

class ShippingMethodExtendDao extends ShippingMethodBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(ShippingFilter $filter) {
		$result = $this->executeSelectList ( ShippingMethodExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(ShippingFilter $filter) {
		$result = $this->executeCount( ShippingMethodExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}