<?php

namespace frontend\service;

use common\config\Attributes;
use common\persistence\base\vo\OrderTotalVo;
use core\workflow\ContextBase;

class OrderTotalHelper {
	public static function addOrderTotal(ContextBase &$context, $type, $title, $subTitle, $value) {
		// Create new order total.
		$orderTotal = new OrderTotalVo ();
		$orderTotal->type = $type;
		$orderTotal->title = $title;
		$orderTotal->subtitle = $subTitle;
		$orderTotal->value = $value;
		// Get order totals.
		$orderTotals = $context->get ( Attributes::ORDER_TOTALS );
		// Add order total.
		$orderTotals->add ( $orderTotal );
	}
	public static function getSubTotal(ContextBase $context) {
		$orderTotals = $context->get ( Attributes::ORDER_TOTALS );
		$subTotal = 0;
		foreach ( $orderTotals as $orderTotal ) {
			if ("subtotal" === $orderTotal->type) {
				$subTotal += $orderTotal->value;
			}
		}
		return $subTotal;
	}
}