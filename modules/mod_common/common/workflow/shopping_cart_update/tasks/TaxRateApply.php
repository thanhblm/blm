<?php

namespace common\workflow\shopping_cart_update\tasks;

use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class TaxRateApply implements Task {
	
	/**
	 * Task3 Valid Discount Coupon from Sessions orderSurcharge
	 *
	 * {@inheritdoc}
	 *
	 * @see \core\workflow\Task::execute() $context params : ProductHomeExtendVo product->id, quantity
	 *      1. Sessions: BaseArray(OrderSurchargeExtendVo::class) orderSurcharge ,
	 *      2. Sessions: OrderChargeInfoVo orderChargeInfo ,
	 *      3. Sessions: BaseArray(OrderProductExtendVo::class) listOrderProduct,
	 *      4. Sessions: LoginUserInfoMo get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )
	 *      Result if pass: $context->set("discount", $discountCoupon);
	 */
	public function execute(ContextBase &$context) {
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$orderChargeInfo = SessionUtil::get ( "orderChargeInfo" );
		$taxAmount = 0;
		$shippingTax = 0;
		$orderChargeInfo->grandTotalAmount = ($orderChargeInfo->grandTotalAmount - AppUtil::defaultIfEmpty($context->get("taxAmountOld"),0));
		foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
			if ("tax_rate" == $orderSurcharge->surchargeType) {
				$taxAmount = $taxAmount + $orderSurcharge->amount;
			}
			if ("shipping" == $orderSurcharge->surchargeType) {
				$shippingTax = $shippingTax+ $orderSurcharge->amount;
			}
		}
		$orderChargeInfo->taxAmount = $taxAmount;
		$orderChargeInfo->shippingAmount = ($shippingTax + AppUtil::defaultIfEmpty($context->get("shippingCost")));
		SessionUtil::set ( "orderChargeInfo", $orderChargeInfo );
	}
}