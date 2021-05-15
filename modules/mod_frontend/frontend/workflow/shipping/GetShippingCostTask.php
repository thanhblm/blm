<?php

namespace frontend\workflow\shipping;

use common\config\Attributes;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetShippingCostTask implements Task {
	public function execute(ContextBase &$context) {
		$shippingMethodId = $context->get ( Attributes::SHIPPING_METHOD_ID );
		$shippingMethodInfo = $context->get ( Attributes::SHIPPING_METHOD_INFO );
		$shippingCost = $this->getShippingCost ( $shippingMethodId, $shippingMethodInfo );
		$context->set ( Attributes::SHIPPING_COST, $shippingCost );
	}
	private function getShippingCost($shippingMethodId, $shippingMethodInfo) {
		// Shipping cost is zero if has no region shipping method settings.
		if (AppUtil::isEmptyString ( $shippingMethodInfo )) {
			return 0;
		}
		// Shipping cost is zero if has no region shipping method settings.
		$shippingMethodObject = JsonUtil::decode ( $shoppingCart->order->shippingMethodInfo );
		if (is_null ( $shippingMethodObject )) {
			return 0;
		}
		// Get shipping cost.
		$shippingCost = 0;
		switch ($shippingMethodId) {
			case 1 : // Zone Table.
				$shippingCost = $shippingMethodObject->cost;
				break;
			case 2 : // Flat Rate.
				$shippingCost = $shippingMethodObject->cost;
				break;
			default :
				// No process
				break;
		}
		return $shippingCost;
	}
}