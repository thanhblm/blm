<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\persistence\base\dao\DiscountCouponProductBaseDao;
use common\persistence\base\vo\DiscountCouponProductVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetApplicableItemsTask implements Task {
	public function execute(ContextBase &$context) {
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		// Get applicable products/categories.
		$filter = new DiscountCouponProductVo ();
		$filter->discountCouponId = $discountCouponVo->id;
		$discountCouponProductDao = new DiscountCouponProductBaseDao ();
		$applicableItems = $discountCouponProductDao->selectByFilter ( $filter );
		$context->set ( Attributes::DISCOUNT_COUPON_APPLICABLE_ITEMS, $applicableItems );
	}
}