<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderHistoryBaseDao;
use common\persistence\extend\vo\OrderHistoryExtendVo;
use common\persistence\extend\mapping\OrderHistoryExtendMapping;

class OrderHistoryExtendDao extends OrderHistoryBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(OrderHistoryExtendVo $orderHistoryExtendVo = null) {
		$result = $this->executeSelectList ( OrderHistoryExtendMapping::class, 'getByFilter', $orderHistoryExtendVo );
		return $result;
	}
	
}