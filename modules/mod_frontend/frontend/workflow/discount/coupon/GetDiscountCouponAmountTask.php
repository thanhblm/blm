<?php

namespace frontend\workflow\discount\coupon;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\dao\ProductBaseDao;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\base\vo\ProductVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetDiscountCouponAmountTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$discountCouponVo = $context->get ( Attributes::DISCOUNT_COUPON_INFO );
		// Get order product list.
		$products = $shoppingCart->products->getArray ();
		// Check empty products.
		if (empty ( $products )) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "The product list is empty so it is not possible to apply the coupon" );
			return false;
		}
		// Get applicable products/categories to this discount coupon.
		$applicableItems = $context->get ( Attributes::DISCOUNT_COUPON_APPLICABLE_ITEMS );
		// Get list of products that was applied discount.
		$getDiscountProducts = array ();
		switch ($discountCouponVo->userPerProduct) {
			case "any_product" :
				$getDiscountProducts = $products;
				break;
			case "any_following" :
				$applied = false;
				foreach ( $products as $product ) {
					foreach ( $applicableItems as $item ) {
						if ("category" === $item->itemType && $item->itemId === $this->getCategoryId ( $product->productId )) {
							$applied = true;
							break;
						}
						if ("product" === $item->itemType && $item->itemId === $product->productId) {
							$applied = true;
							break;
						}
					}
				}
				if ($applied) {
					$getDiscountProducts = $products;
				}
				break;
			case "only_for_following" :
				$applied = false;
				foreach ( $products as $product ) {
					foreach ( $applicableItems as $item ) {
						if ("category" === $item->itemType && $item->itemId === $this->getCategoryId ( $product->productId )) {
							$getDiscountProducts [] = $product;
							$applied = true;
							break;
						}
						if ("product" === $item->itemType && $item->itemId === $product->productId) {
							$getDiscountProducts [] = $product;
							$applied = true;
							break;
						}
					}
				}
				if (! $applied) {
					$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
					$context->set ( Attributes::ATTR_ERROR_MESSAGE, "Your shopping cart has no product that applied this coupon" );
					return false;
				}
				break;
		}
		// Calculate discount coupon amount.
		$subTotal = 0;
		foreach ( $getDiscountProducts as $product ) {
			$subTotal += $product->price * $product->quantity;
		}
		$discountCouponAmount = $subTotal * $discountCouponVo->discount / 100;
		$context->set ( Attributes::DISCOUNT_COUPON_AMOUNT, $discountCouponAmount );
	}
	private function getCategoryId($productId) {
		$filter = new ProductVo ();
		$filter->id = $productId;
		$productDao = new ProductBaseDao ();
		$productVo = $productDao->selectByKey ( $filter );
		return is_null ( $productVo ) ? 0 : $productVo->categoryId;
	}
}