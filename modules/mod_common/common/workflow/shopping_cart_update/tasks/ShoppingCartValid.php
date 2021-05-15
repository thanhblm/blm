<?php

namespace common\workflow\shopping_cart_update\tasks;

use common\helper\LocalizationHelper;
use common\services\product\ProductHomeService;
use core\Lang;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class ShoppingCartValid implements Task {
	
	/**
	 * Tast1:
	 * - Valid input shopping cart :
	 * 1.
	 * Valid Product id,
	 * 2. Valid quantity,
	 * 3. Valid isCustomerRetail.
	 *
	 * {@inheritDoc}
	 *
	 * @see \core\workflow\Task::execute() $context params : ProductHomeExtendVo product->id, quantity;
	 *      SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) LoginUserInfoMo
	 *      If not valid -- count($actionErrors) > 0 -- Result $context : actionErrors : array();
	 *      If valid Result $context : update product with detail;
	 */
	public function execute(ContextBase &$context) {
		$product = $context->get ( "product" );
		$quantity = $context->get ( "quantity" );
		$actionErrors = array ();
		$fieldErrors = array ();
		$context->set ( "actionErrors", $actionErrors );
		$context->set ( "fieldErrors", $fieldErrors );
		if (AppUtil::isEmptyString ( $quantity )) {
			return true;
		}
		
		/**
		 * Valid Product Id
		 * If passed: set context ::: product $context->set("product", $products[0]);
		 */
		
		if (AppUtil::isEmptyString ( $product->id )) {
			$actionErrors [] = Lang::get ( "Product ID can't empty!" );
		} else {
			$productSv = new ProductHomeService ();
			$product->status = "active";
			$product->languageCode = LocalizationHelper::getLangCode ();
			$product->currencyCode = LocalizationHelper::getCurrencyCode ();
			$product->regionId = LocalizationHelper::getRegionId ();
			$product = $productSv->getProductHomeById( $product );
			if (is_null ( $product)) {
				$actionErrors [] = Lang::getWithFormat ( "Not found product with ID {0}", $product->id );
			} else {
				// Valid Product Passed
				$context->set ( "product", $product);
			}
		}
		/**
		 * Valid Quantity
		 * If passed: set content ::: $context->set("quantity", intval($quantity));
		 */
		if (AppUtil::isEmptyString ( $quantity )) {
			$actionErrors [] = Lang::get ( "Product Quantity cannot empty!" );
			$context->set ( "actionErrors", $actionErrors );
		} elseif (! is_numeric ( $quantity )) {
			$actionErrors [] = Lang::get ( "Product Quantity required numeric!" );
		}
		
		$context->set ( "actionErrors", $actionErrors );
		$context->set ( "fieldErrors", $fieldErrors );
		// Valid task has Errors
		if (count ( $actionErrors ) > 0) {
			return false;
		}
	}
}