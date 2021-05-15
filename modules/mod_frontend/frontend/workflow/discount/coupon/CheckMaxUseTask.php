<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\base\vo\OrderVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckMaxUseTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		if (! is_null ( $discountCouponVo->maxUse )) {
			// Get total use of the discount coupon.
			$totalUse = $this->getDiscountCouponTotalMaxUse ( $discountCouponVo->code );
			if ($totalUse > 0 && $totalUse >= $discountCouponVo->maxUse) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "This discount coupon has exceeded the number of uses" );
				return false;
			}
		}
	}
	private function getDiscountCouponTotalMaxUse($discountCouponCode) {
		$orderVo = new OrderVo ();
		$orderVo->couponCode = $discountCouponCode;
		$orderBaseDao = new OrderBaseDao ();
		$orderVos = $orderBaseDao->selectByFilter ( $orderVo );
		return count ( $orderVos );
	}
}