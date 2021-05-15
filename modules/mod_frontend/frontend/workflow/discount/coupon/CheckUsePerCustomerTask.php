<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\base\vo\OrderVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckUsePerCustomerTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$customerId = $shoppingCart->order->customerId;
		// If customer id is null (is guest) or use per customer is 0 (infinite)
		// then ignore validate.
		if (is_null ( $customerId ) || empty ( $discountCouponVo->usePerCustomer )) {
			return true;
		}
		// Check the number of use of this discount coupon of this customer.
		$totalUseByCustomer = $this->getDiscountCouponCustomerUse ( $customerId, $discountCouponVo->code );
		if ($totalUseByCustomer >= $discountCouponVo->usePerCustomer) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "This discount coupon has exceeded the number of uses for you" );
			return false;
		}
	}
	private function getDiscountCouponCustomerUse($customerId, $couponCode) {
		$orderVo = new OrderVo ();
		$orderVo->customerId = $customerId;
		$orderVo->couponCode = $couponCode;
		$orderBaseDao = new OrderBaseDao ();
		$orderVos = $orderBaseDao->selectByFilter ( $orderVo );
		return count ( $orderVos );
	}
}