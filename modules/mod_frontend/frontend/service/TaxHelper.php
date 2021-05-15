<?php

namespace frontend\service;

use common\config\Attributes;
use common\persistence\base\vo\AddressVo;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;

class TaxHelper {
	public static function getProductTax(AddressVo $shippingAddress = null, AddressVo $billingAddress = null) {
		$context = new ContextBase ();
		$context->set ( Attributes::SHIPPING_ADDRESS, $shippingAddress );
		$context->set ( Attributes::BILLING_ADDRESS, $billingAddress );
		WorkflowManager::Instance ()->execute ( "wfp_get_product_tax", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get tax rates apply for products" );
		$result = array (
				Attributes::PRODUCT_TAX_LIST => $context->get ( Attributes::PRODUCT_TAX_LIST ),
				Attributes::PRODUCT_TAX_PERCENT => $context->get ( Attributes::PRODUCT_TAX_PERCENT ) 
		);
		return $result;
	}
	public static function getShippingTax(AddressVo $shippingAddress = null, AddressVo $billingAddress = null) {
		$context = new ContextBase ();
		$context->set ( Attributes::SHIPPING_ADDRESS, $shippingAddress );
		$context->set ( Attributes::BILLING_ADDRESS, $billingAddress );
		WorkflowManager::Instance ()->execute ( "wfp_get_product_tax", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when get tax rates apply when do ship" );
		$result = array (
				Attributes::SHIPPING_TAX_LIST => $context->get ( Attributes::SHIPPING_TAX_LIST ),
				Attributes::SHIPPING_TAX_PERCENT => $context->get ( Attributes::SHIPPING_TAX_PERCENT ) 
		);
		return $result;
	}
}