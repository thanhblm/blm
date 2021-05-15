<?php

namespace frontend\workflow\tax\shipping;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\DynamicTaxRateHelper;

class GetShippingTaxPercentTask implements Task {
	public function execute(ContextBase &$context) {
		$shippingAddress = $context->get ( Attributes::SHIPPING_ADDRESS );
		$billingAddress = $context->get ( Attributes::BILLING_ADDRESS );
		$taxRates = $context->get ( Attributes::SHIPPING_TAX_LIST );
		if (empty ( $taxRates )) {
			$context->set ( Attributes::SHIPPING_TAX_PERCENT, 0 );
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
		$context->set ( Attributes::SHIPPING_TAX_PERCENT, $taxPercent );
	}
}