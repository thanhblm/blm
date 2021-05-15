<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderStatusBaseDao;
use common\persistence\extend\mapping\OrderStatusExtendMapping;
use core\database\SqlMapClient;

class OrderStatusExtendDao extends OrderStatusBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getSortedOrderStatuses() {
		$result = $this->executeSelectList ( OrderStatusExtendMapping::class, 'getSortedOrderStatuses', null );
		return $result;
	}
}