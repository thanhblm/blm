<?php

namespace frontend\workflow\tax\rate;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\DynamicTaxRateHelper;

class GetProductTaxPercentTask implements Task {
	public function execute(ContextBase &$context) {
		$shippingAddress = $context->get ( Attributes::SHIPPING_ADDRESS );
		$billingAddress = $context->get ( Attributes::BILLING_ADDRESS );
		$taxRates = $context->get ( Attributes::PRODUCT_TAX_LIST );
		if (empty ( $taxRates )) {
			$context->set ( Attributes::PRODUCT_TAX_PERCENT, 0 );
			return true;
		}
		$taxPercent = 0;
		foreach ( $taxRates as $taxRate ) {
			if ("static" === $taxRate->type) {
				$taxPercent += $taxRate->rate;
			}
			if ("dynamic" === $taxRate->type) {
				if ("shipping" === $taxRate->zoneMatch) {
					$taxPercent += DynamicTaxRateHelper::getTaxRateByType ( $taxRate->dynamicRate, $shippingAddress );
				}
				if ("billing" === $taxRate->zoneMatch) {
					$taxPercent += DynamicTaxRateHelper::getTaxRateByType ( $taxRate->dynamicRate, $billingAddress );
				}
			}
		}
		$context->set ( Attributes::PRODUCT_TAX_PERCENT, $taxPercent );
	}
}