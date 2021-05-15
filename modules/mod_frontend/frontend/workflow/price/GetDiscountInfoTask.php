<?php

namespace frontend\workflow\price;

use common\config\Attributes;
use core\workflow\Task;
use core\workflow\ContextBase;

class GetDiscountInfoTask implements Task {
	public function execute(ContextBase &$context) {
		$basePrice = $context->get ( Attributes::PRODUCT_BASE_PRICE );
		$priceLevelInfo = $context->get ( Attributes::PRICE_LEVEL_INFO );
		$bulkDiscountInfo = $context->get ( Attributes::BULK_DISCOUNT_INFO );
		// Get price level value.
		if (is_null ( $priceLevelInfo )) {
			$priceLevel = 0;
		} else {
			$priceLevel = $priceLevelInfo->value;
		}
		// Get bulk discount value.
		if (is_null ( $bulkDiscountInfo )) {
			$bulkDiscount = 0;
		} else {
			$bulkDiscount = $bulkDiscountInfo->discount;
		}
		$discountPercent = max ( array (
				$priceLevel,
				$bulkDiscount 
		) );
		$discountAmount = $basePrice * $discountPercent / 100;
		$context->set ( Attributes::DISCOUNT_PERCENT, $discountPercent );
		$context->set ( Attributes::DISCOUNT_AMOUNT, $discountAmount );
	}
}