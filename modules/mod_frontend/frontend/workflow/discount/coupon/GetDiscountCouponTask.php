<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\vo\DiscountCouponVo;
use common\services\discount_coupon\DiscountCouponService;
use core\utils\AppUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetDiscountCouponTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		if (is_null ( $shoppingCart )) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "No shopping cart info" );
			return false;
		}
		// Ignore if shopping cart don't have coupon code.
		if (AppUtil::isEmptyString ( $shoppingCart->order->couponCode )) {
			$context->set ( Attributes::DISCOUNT_COUPON_AMOUNT, 0 );
			return false;
		}
		$filter = new DiscountCouponVo ();
		$filter->code = $shoppingCart->order->couponCode;
		$discountCouponService = new DiscountCouponService ();
		$discountCouponVo = $discountCouponService->getByCode ( $filter );
		if (is_null ( $discountCouponVo ) || ! "active" === $discountCouponVo->status) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "Discount coupon code is invalid" );
			return false;
		}
		$context->set ( Attributes::DISCOUNT_COUPON_INFO, $discountCouponVo );
	}
}