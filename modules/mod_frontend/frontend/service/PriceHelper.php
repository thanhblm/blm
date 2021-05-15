<?php

namespace frontend\service;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;

class PriceHelper {
	public static function getSalePrice($customerId, $productId, $quantity, $currencyCode) {
		$context = new ContextBase ();
		$context->set ( Attributes::CUSTOMER_ID, $customerId );
		$context->set ( Attributes::PRODUCT_ID, $productId );
		$context->set ( Attributes::PRODUCT_QUANTITY, $quantity );
		$context->set ( Attributes::CURRENCE_CODE, $currencyCode );
		WorkflowManager::Instance ()->execute ( "wfp_get_sale_price", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when sale price of the product" );
		$result = array (
				Attributes::PRODUCT_BASE_PRICE => $context->get ( Attributes::PRODUCT_BASE_PRICE ),
				Attributes::PRICE_LEVEL_INFO => $context->get ( Attributes::PRICE_LEVEL_INFO ),
				Attributes::BULK_DISCOUNT_INFO => $context->get ( Attributes::BULK_DISCOUNT_INFO ),
				Attributes::DISCOUNT_PERCENT => $context->get ( Attributes::DISCOUNT_PERCENT ),
				Attributes::DISCOUNT_AMOUNT => $context->get ( Attributes::DISCOUNT_AMOUNT ),
				Attributes::SALE_PRICE => $context->get ( Attributes::SALE_PRICE ) 
		);
		return $result;
	}
	public static function getShippingCost($shippingMethodId, $shippingMethodInfo) {
		$context = new ContextBase ();
		$context->set ( Attributes::SHIPPING_METHOD_ID, $shippingMethodId );
		$context->set ( Attributes::SHIPPING_METHOD_INFO, $shippingMethodInfo );
		WorkflowManager::Instance ()->execute ( "wfp_get_shipping_cost", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get shipping cost" );
		return $context->get ( Attributes::SHIPPING_COST );
	}
}