<?php

namespace common\workflow\shopping_cart_update\tasks;

use core\workflow\ContextBase;
use core\workflow\Task;
use core\utils\SessionUtil;
use common\persistence\base\vo\OrderChargeInfoVo;
use core\BaseArray;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\persistence\base\vo\OrderVo;

class PrepareSessionCartTask implements Task{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \core\workflow\Task::execute()
	 * $context params : discountCode, products, customer, feldErrors, orderChargeInfo, orderSurcharge;
	 * New $context params : discount = DiscountCouponVo;
	 */
	public function execute(ContextBase &$context){
		if(is_null(SessionUtil::get("listOrderProduct"))){
			SessionUtil::set("listOrderProduct", new BaseArray(OrderProductExtendVo::class));
		}
		if(is_null(SessionUtil::get("orderChargeInfo"))){
			$orderChargeInfo = new OrderChargeInfoVo();
			$orderChargeInfo->subTotalAmount = 0;
			$orderChargeInfo->grandTotalAmount = 0;
			SessionUtil::set("orderChargeInfo", $orderChargeInfo);
		}
		if(is_null(SessionUtil::get("orderSurcharge"))){
			SessionUtil::set("orderSurcharge", new BaseArray(OrderSurchargeExtendVo::class));
		}
		if(is_null(SessionUtil::get("order"))){
			SessionUtil::set("order", new OrderVo());
		}
	}
	
}