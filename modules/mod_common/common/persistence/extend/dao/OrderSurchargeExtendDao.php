<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderSurchargeBaseDao;
use common\persistence\extend\mapping\OrderSurchargeExtendMapping;
use common\persistence\extend\vo\CustomerSurchargeVo;
use core\database\SqlMapClient;

class OrderSurchargeExtendDao extends OrderSurchargeBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getDiscountCouponUseByCustomer(CustomerSurchargeVo $customerSurchargeVo) {
		return $this->executeSelectList ( OrderSurchargeExtendMapping::class, 'getDiscountCouponUseByCustomer', $customerSurchargeVo );
	}
}