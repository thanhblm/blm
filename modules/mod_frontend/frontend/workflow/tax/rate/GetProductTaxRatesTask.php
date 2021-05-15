<?php

namespace frontend\workflow\tax\rate;

use common\config\Attributes;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\base\vo\TaxRateVo;
use common\services\tax\TaxRateService;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetProductTaxRatesTask implements Task {
	public function execute(ContextBase &$context) {
		$shippingAddress = $context->get ( Attributes::SHIPPING_ADDRESS );
		$billingAddress = $context->get ( Attributes::BILLING_ADDRESS );
		// Get all product tax rates.
		$filter = new TaxRateVo ();
		$filter->id = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "tax.rate.taxable.goods" ), 2 ); // Taxable Goods.
		$taxRateService = new TaxRateService ();
		$taxRates = $taxRateService->getTaxRateByClass ( $filter );
		// Get all apply tax rate on shipping/billing address.
		$shippingTaxRates = $this->getShippingTaxRates ( $taxRates, $shippingAddress );
		$billingTaxRates = $this->getBillingTaxRates ( $taxRates, $billingAddress );
		$applyTaxRates = array_merge ( $shippingTaxRates, $billingTaxRates );
		$context->set ( Attributes::PRODUCT_TAX_LIST, $applyTaxRates );
	}
	private function getShippingTaxRates(array $taxRates, AddressVo $shippingAddress = null) {
		$shippingTaxRates = array ();
		if (empty ( $taxRates ) || is_null ( $shippingAddress )) {
			return $shippingTaxRates;
		}
		foreach ( $taxRates as $taxRate ) {
			if ("shipping" === $taxRate->zoneMatch) {
				$match = $taxRate->countryId === $shippingAddress->country;
				$match = empty ( $taxRate->stateId ) ? $match : $match && $taxRate->stateId === $shippingAddress->state;
				if ($match && "no" === $taxRate->exclusive) {
					$taxRateInfo = new TaxRateInfoVo ();
					AppUtil::copyProperties ( $taxRate, $taxRateInfo );
					$shippingTaxRates [] = $taxRateInfo;
				}
				if (! $match && "yes" === $taxRate->exclusive) {
					$taxRateInfo = new TaxRateInfoVo ();
					AppUtil::copyProperties ( $taxRate, $taxRateInfo );
					$shippingTaxRates [] = $taxRateInfo;
				}
			}
		}
		return $shippingTaxRates;
	}
	private function getBillingTaxRates(array $taxRates, AddressVo $billingAddress = null) {
		$billingTaxRates = array ();
		if (empty ( $taxRates ) || is_null ( $billingAddress )) {
			return $billingTaxRates;
		}
		foreach ( $taxRates as $taxRate ) {
			if ("billing" === $taxRate->zoneMatch) {
				$match = $taxRate->countryId === $billingAddress->country;
				$match = empty ( $taxRate->stateId ) ? $match : $match && $taxRate->stateId === $billingAddress->state;
				if ($match && "no" === $taxRate->exclusive) {
					$taxRateInfo = new TaxRateInfoVo ();
					AppUtil::copyProperties ( $taxRate, $taxRateInfo );
					$shippingTaxRates [] = $taxRateInfo;
				}
				if (! $match && "yes" === $taxRate->exclusive) {
					$taxRateInfo = new TaxRateInfoVo ();
					AppUtil::copyProperties ( $taxRate, $taxRateInfo );
					$shippingTaxRates [] = $taxRateInfo;
				}
			}
		}
		return $billingTaxRates;
	}
}