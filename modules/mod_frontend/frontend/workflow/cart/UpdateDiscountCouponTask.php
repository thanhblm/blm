<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use common\config\ErrorCodes;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\DiscountHelper;

class UpdateDiscountCouponTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		try {
			$discountCouponInfo = DiscountHelper::getDiscountCoupon ( $shoppingCart );
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		$shoppingCart->coupon = $discountCouponInfo [Attributes::DISCOUNT_COUPON_AMOUNT];
	}
}