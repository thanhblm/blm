<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use common\persistence\base\dao\ProductPriceBaseDao;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\base\vo\ProductPriceVo;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\service\DiscountHelper;
use frontend\service\TaxHelper;

class UpdateOrderValuesTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$shippingAddress = $context->get ( Attributes::SHIPPING_ADDRESS );
		$billingAddress = $context->get ( Attributes::BILLING_ADDRESS );
		// Get product tax percent.
		try {
			$productTaxInfo = TaxHelper::getProductTax ( $shippingAddress, $billingAddress );
			$productTaxPercent = $productTaxInfo [Attributes::PRODUCT_TAX_PERCENT];
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		// Get price level discount.
		try {
			$priceLevelInfo = DiscountHelper::getPriceLevel ( $shoppingCart->order->customerId );
		} catch ( \Exception $e ) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, $e->getMessage () );
			return false;
		}
		$subTotal = 0;
		$totalDiscountAmount = 0;
		foreach ( $shoppingCart->products->getArray () as $product ) {
			// Get bulk discount.
			$bulkDiscountInfo = DiscountHelper::getBulkDiscount ( $product->productId, $product->quantity );
			// Get discount percent.
			$discountPercent = $this->getDiscountPercent ( $priceLevelInfo, $bulkDiscountInfo );
			// Get product price.
			$productPrice = $this->getProductPrice ( $product->productId, $shoppingCart->order->currencyCode );
			if (is_null ( $productPrice )) {
				$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
				$context->set ( Attributes::ATTR_ERROR_MESSAGE, "No product with id = " . $product->productId );
				return false;
			}
			$product->basePrice = $productPrice->price;
			// Get discount amount.
			$discountAmount = $discountPercent * $product->basePrice / 100;
			$totalDiscountAmount += $discountAmount * $product->quantity;
			// Update product price.
			$product->price = $product->basePrice - $discountAmount;
			$product->discount = $discountPercent;
			$product->tax = $productTaxPercent;
			// $subTotal += $product->price * $product->quantity;
			$subTotal += $product->basePrice * $product->quantity;
		}
		// Update sub total.
		$shoppingCart->subTotal = $subTotal;
		// Update discount.
		$shoppingCart->discount = $totalDiscountAmount;
		// Update tax.
		$shoppingCart->taxTotal = $productTaxPercent * $subTotal / 100;
	}
	private function getProductPrice($productId, $currencyCode) {
		$filter = new ProductPriceVo ();
		$filter->productId = $productId;
		$filter->currencyCode = $currencyCode;
		$productDao = new ProductPriceBaseDao ();
		return $productDao->selectByKey ( $filter );
	}
	private function getDiscountPercent(PriceLevelVo $priceLevelVo = null, BulkDiscountVo $bulkDiscountVo = null) {
		$priceLevel = is_null ( $priceLevelVo ) ? 0 : $priceLevelVo->value;
		$bulkDiscount = is_null ( $bulkDiscountVo ) ? 0 : $bulkDiscountVo->discount;
		return max ( $priceLevel, $bulkDiscount );
	}
}