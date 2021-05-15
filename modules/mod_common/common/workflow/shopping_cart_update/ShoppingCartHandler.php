<?php

namespace common\workflow\shopping_cart_update;

use core\workflow\ContextBase;
use core\workflow\Handler;
use core\utils\SessionUtil;

class ShoppingCartHandler extends Handler {
	public function handle(ContextBase &$context, \Exception $exception = null) {
		$actionErrors = $context->get("actionErrors");
		$fieldErrors = $context->get("fieldErrors");
		$actionErrors[] = $exception;
		$context->set("actionErrors", $actionErrors);
		//if hasError discountCode: remove discountCode in orderSurcharge and reCalculate prices
		if(isset($fieldErrors["discountCode"]) && count($fieldErrors["discountCode"]) > 0){
			$discountAmount = 0;
			$orderSurcharges = SessionUtil::get("orderSurcharge");
			$orderChargeInfo = SessionUtil::get("orderChargeInfo");
			foreach ($orderSurcharges->getArray() as $orderSurcharge){
				if("coupon" == $orderSurcharge->surchargeType){
					$discountAmount = $orderSurcharge->amount;
					$orderChargeInfo->discountAmount = $orderChargeInfo->discountAmount - $discountAmount;
					$orderChargeInfo->grandTotalAmount = $orderChargeInfo->grandTotalAmount + $discountAmount;
					$orderSurcharges->remove($orderSurcharge);
				}
			}
			SessionUtil::set("orderSurcharge",$orderSurcharges);
			SessionUtil::set("orderChargeInfo",$orderChargeInfo);
		}
	}
}