<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\OrderSurchargeVo;
use common\persistence\extend\vo\CustomerSurchargeVo;
use core\database\SqlStatementInfo;

class OrderSurchargeExtendMapping {
	public function getDiscountCouponUseByCustomer(CustomerSurchargeVo $customerSurchargeVo) {
		try {
			$query = "
				select os.* from `order_surcharge` os
				inner join `order` o on o.id = os.order_id
				where o.customer_id = #{customerId} and os.surcharge_id = #{surchargeId} and os.surcharge_type = 'coupon'";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderSurchargeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}