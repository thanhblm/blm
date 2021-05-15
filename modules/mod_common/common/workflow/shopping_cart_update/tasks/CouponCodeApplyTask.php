<?php

namespace common\workflow\shopping_cart_update\tasks;

use common\persistence\base\vo\CustomerVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\services\customer\CustomerService;
use common\utils\StringUtil;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\common\Constants;

class CouponCodeApplyTask implements Task{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \core\workflow\Task::execute()
	 * $context params : discountCode, products, customer, feldErrors, orderChargeInfo, orderSurcharge;
	 * New $context params : discount = DiscountCouponVo;
	 */
	public function execute(ContextBase &$context){
		if(AppUtil::isEmptyString($context->get("discountCode"))){
			return true;
		}
		
		if(!is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)) && SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId != 0){
			$customerVo = new CustomerVo();
			$customerVo->id = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId;
			$customerSv= new CustomerService();
			$customerVo = $customerSv->selectByKey($customerVo);
			
			if("0" != $customerVo->priceLevelId){
				return true;
			}
		}
		$orderSurcharges = SessionUtil::get("orderSurcharge");
		// Get Amout Discount from old discountcode;
		foreach ($orderSurcharges->getArray() as $orderSurcharge){
			if("coupon" == $orderSurcharge->surchargeType){
				$orderSurcharges->remove($orderSurcharge);
			}
		}
		$products = SessionUtil::get("listOrderProduct")->getArray();
		$priceApplyDiscount = 0;
		if(!is_null($context->get("onlyForProduct"))){
			$listProductId = $context->get("onlyForProduct");
			if(count($listProductId) > 0){
				foreach ($listProductId as $productId){
					foreach ($products as $product){
						if($productId == $product->productId){
							$priceApplyDiscount += $product->price;
						}
					}
				}
			}
		}
		
		$discount = $context->get("discount");
		$orderChargeInfo = SessionUtil::get("orderChargeInfo");
		$newGrandTotalAmount = $orderChargeInfo->subTotalAmount;
		
		if($priceApplyDiscount == 0){
			$priceApplyDiscount = $newGrandTotalAmount;
		}
		
		$orderChargeInfo->discountAmount = StringUtil::calculatePerPrice($discount->discount, $priceApplyDiscount);
		
		$orderSurchargeVo = new OrderSurchargeExtendVo();
		$orderSurchargeVo->surchargeCode = $context->get("discountCode");
		$orderSurchargeVo->surchargeType = "coupon";
		$orderSurchargeVo->surchargeId = $discount->id;
		$orderSurchargeVo->amount = $orderChargeInfo->discountAmount;
		$orderSurchargeVo->data = JsonUtil::encode($discount);
		$orderSurcharges->add($orderSurchargeVo);
		
		SessionUtil::set("orderSurcharge", $orderSurcharges);
		SessionUtil::set("orderChargeInfo", $orderChargeInfo);
	}
	
}