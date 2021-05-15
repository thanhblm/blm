<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use common\helper\SettingHelper;
use common\persistence\base\vo\OrderTotalVo;
use core\BaseArray;
use core\Lang;
use core\workflow\ContextBase;
use core\workflow\Task;

class UpdateOrderTotalsTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$orderTotals = new BaseArray ( OrderTotalVo::class );
		$this->addOrderTotal ( $orderTotals, "subtotal", Lang::get ( "Subtotal" ), "", $shoppingCart->subTotal );
		$this->addOrderTotal ( $orderTotals, "taxtotal", Lang::get ( "Tax" ), "", $shoppingCart->taxTotal );
		$this->addOrderTotal ( $orderTotals, "discount", Lang::get ( "Cart Discount" ), "", $shoppingCart->discount );
		// Update shipping amount.
		$freeShippingTotalSetting = SettingHelper::getSettingValue ( "Free Shipping Total" );
		$freeShippingTotal = is_null ( $freeShippingTotalSetting ) ? 0 : $freeShippingTotalSetting;
		if ($shoppingCart->subTotal >= $freeShippingTotal) {
			$shoppingCart->shipping = 0;
			$this->addOrderTotal ( $orderTotals, "shipping", Lang::get ( "Free Shipping" ), Lang::get ( "Free Shipping" ), $shoppingCart->shipping );
		} else {
			$this->addOrderTotal ( $orderTotals, "shipping", Lang::get ( "Shipping" ), Lang::get ( "Flat rate" ), $shoppingCart->shipping );
		}
		$this->addOrderTotal ( $orderTotals, "coupon", Lang::get ( "Discount Coupon" ), "imported", $shoppingCart->coupon );
		$this->addOrderTotal ( $orderTotals, "total", Lang::get ( "Total" ), "", $shoppingCart->subTotal );
		$shoppingCart->orderTotals = $orderTotals;
	}
	private function addOrderTotal(BaseArray &$array, $type, $title, $subTitle, $value) {
		// Create new order total.
		$orderTotal = new OrderTotalVo ();
		$orderTotal->type = $type;
		$orderTotal->title = $title;
		$orderTotal->subtitle = $subTitle;
		$orderTotal->value = $value;
		// Add order total.
		$array->add ( $orderTotal );
	}
}