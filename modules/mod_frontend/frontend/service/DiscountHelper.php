<?php

namespace frontend\service;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\model\ShoppingCartModel;

class DiscountHelper {
	public static function getPriceLevel($customerId) {
		$context = new ContextBase ();
		$context->set ( Attributes::CUSTOMER_ID, $customerId );
		WorkflowManager::Instance ()->execute ( "wfp_get_price_level", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get price level of the customer" );
		return $context->get ( Attributes::PRICE_LEVEL_INFO );
	}
	public static function getBulkDiscount($productId, $quantity) {
		$context = new ContextBase ();
		$context->set ( Attributes::PRODUCT_ID, $productId );
		$context->set ( Attributes::PRODUCT_QUANTITY, $quantity );
		WorkflowManager::Instance ()->execute ( "wfp_get_bulk_discount", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get bulk discount of the product" );
		return $context->get ( Attributes::BULK_DISCOUNT_INFO );
	}
	public static function getDiscountCoupon(ShoppingCartModel $shoppingCart) {
		$context = new ContextBase ();
		$context->set ( Attributes::SHOPPING_CART, $shoppingCart );
		WorkflowManager::Instance ()->execute ( "wfp_get_discount_coupon", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get discount coupon info" );
		$result = array (
				Attributes::DISCOUNT_COUPON_INFO => $context->get ( Attributes::DISCOUNT_COUPON_INFO ),
				Attributes::DISCOUNT_COUPON_AMOUNT => $context->get ( Attributes::DISCOUNT_COUPON_AMOUNT ) 
		);
		return $result;
	}
}