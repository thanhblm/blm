<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\vo\DiscountCouponVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckValidFromTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		if (! is_null ( $discountCouponVo->validFrom )) {
			$today = date ( 'Y-m-d H:i:s' );
			if (strtotime ( $today ) < strtotime ( $discountCouponVo->validFrom )) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "This discount coupon has expired" );
				return false;
			}
		}
	}
}