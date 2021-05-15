<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\vo\DiscountCouponVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckMinOrderTotalTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		if (! is_null ( $discountCouponVo->minOrderTotal )) {
			// Check empty shopping cart.
			$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
			if (is_null ( $shoppingCart )) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "No shopping cart info" );
				return false;
			}
			// Check sub total of the shopping cart.
			$subTotal = $shoppingCart->subTotal;
			if ($subTotal <= $discountCouponVo->minOrderTotal) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "Your order is not eligible for this coupon" );
				return false;
			}
		}
	}
}