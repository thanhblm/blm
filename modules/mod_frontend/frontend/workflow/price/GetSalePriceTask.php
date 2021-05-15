<?php

namespace frontend\workflow\price;

use common\config\Attributes;
use core\workflow\Task;
use core\workflow\ContextBase;

class GetSalePriceTask implements Task {
	public function execute(ContextBase &$context) {
		$basePrice = $context->get ( Attributes::PRODUCT_BASE_PRICE );
		$discountAmount = $context->get ( Attributes::DISCOUNT_AMOUNT );
		$salePrice = $basePrice - $discountAmount;
		$context->set ( Attributes::SALE_PRICE, $salePrice );
	}
}