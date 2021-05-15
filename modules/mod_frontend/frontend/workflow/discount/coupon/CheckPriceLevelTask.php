<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\DiscountHelper;

class CheckPriceLevelTask implements Task {
	public function execute(ContextBase &$context) {
		// Check price level of the customer
		// If the customer not is Retail (Price Level Id = 0) so it cannot apply to this customer.
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$customerId = $shoppingCart->order->customerId;
		try {
			$priceLevelVo = $this->getPriceLevel ( $customerId );
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		if (! is_null ( $priceLevelVo ) && $priceLevelVo->id > 0) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "You aren't retail customer so it is not possible to apply the coupon" );
			return false;
		}
	}
	private function getPriceLevel($customerId) {
		return DiscountHelper::getPriceLevel ( $customerId );
	}
}