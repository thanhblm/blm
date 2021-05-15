<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\PriceHelper;
use frontend\service\TaxHelper;

class UpdateShippingTaxTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$shippingAddress = $context->get ( Attributes::SHIPPING_ADDRESS );
		$billingAddress = $context->get ( Attributes::BILLING_ADDRESS );
		// Get shipping cost.
		try {
			$shippingCost = PriceHelper::getShippingCost ( $shoppingCart->shippingMethodId, $shoppingCart->shippingMethodInfo );
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		// Get shipping tax percent.
		try {
			$shippingTaxInfo = TaxHelper::getShippingTax ( $shippingAddress, $billingAddress );
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		$shippingTaxPercent = $shippingTaxInfo [Attributes::SHIPPING_TAX_PERCENT];
		$shippingTaxAmount = $shippingCost * $shippingTaxPercent / 100;
		$shippingAmount = $shippingCost + $shippingTaxAmount;
		$shoppingCart->shipping = $shippingAmount;
	}
}