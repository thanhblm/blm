<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\vo\DiscountCouponVo;
use core\utils\DateTimeUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckValidToTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		if (! is_null ( $discountCouponVo->validTo )) {
			$today = date ( 'Y-m-d H:i:s' );
			$validTo = DateTimeUtil::mySqlStringDate2Date ( $discountCouponVo->validTo );
			if (strtotime ( $today ) > strtotime ( $discountCouponVo->validTo )) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "This discount coupon has expired" );
				return false;
			}
		}
	}
}