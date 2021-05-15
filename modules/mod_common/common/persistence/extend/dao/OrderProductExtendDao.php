<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderProductBaseDao;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\extend\mapping\OrderProductExtendMapping;
use common\persistence\extend\vo\OrderProductExtendVo;

class OrderProductExtendDao extends OrderProductBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getOrderProductByKey(OrderProductVo $orderProductVo = null) {
		$result = $this->executeSelectList ( OrderProductExtendMapping::class, 'selectOrderProductByKey', $orderProductVo );
		return $result;
	}
	public function getOrderProductCustomerByKey(OrderProductExtendVo $orderProductVo) {
		$result = $this->executeSelectList ( OrderProductExtendMapping::class, 'selectOrderProductCustomerByKey', $orderProductVo );
		return $result;
	}
}