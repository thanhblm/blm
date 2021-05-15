<?php

namespace common\workflow\shopping_cart_update\tasks;

use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\services\attribute\ProductAttributeService;
use common\services\home\CartService;
use core\BaseArray;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use common\persistence\extend\vo\ProductHomeExtendVo;

class ShoppingCartUpdate implements Task{
	/**
	 * Task2 Check Bulk Discount And Update Shopping Cart
	 * {@inheritDoc}
	 * @see \core\workflow\Task::execute()
	 * $context params : ProductHomeExtendVo product->id, quantity
	 * 		1. Sessions:  BaseArray(OrderSurchargeExtendVo::class)  orderSurcharge , 
	 * 		2. Sessions:  OrderChargeInfoVo orderChargeInfo , 
	 * 		3. Sessions:  BaseArray(OrderProductExtendVo::class) listOrderProduct,
	 * 		4. Sessions:  LoginUserInfoMo get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )
	 */
	public function execute(ContextBase &$context){
		$cartSv = new CartService();
		$product = $context->get("product");
		$quantity = $context->get("quantity");
		$productAttributeVo = $context->get("productAttribute");
		$listOrderProduct = SessionUtil::get("listOrderProduct");
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$orderVo = SessionUtil::get("order");
		if(!is_null($orderSurcharges) && !empty($orderSurcharges->getArray())){
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				if ("price_level" == $orderSurcharge->surchargeType) {
					$orderSurcharges->remove ( $orderSurcharge );
				}
				if ("bulk_discount" == $orderSurcharge->surchargeType) {
					$orderSurcharges->remove ( $orderSurcharge );
				}
				if ("tax_rate" == $orderSurcharge->surchargeType) {
					$orderSurcharges->remove ( $orderSurcharge );
				}
				if ("shipping" == $orderSurcharge->surchargeType) {
					$orderSurcharges->remove ( $orderSurcharge );
				}
			}
			SessionUtil::set("orderSurcharge", $orderSurcharges);
		}
		$productAttributeSv = new ProductAttributeService();
		if(AppUtil::isEmptyString($quantity)){
			if(!is_null($listOrderProduct) && !empty($listOrderProduct->getArray())){
				foreach ($listOrderProduct->getArray() as $orderProduct){
					if(isset($orderProduct->productAttributeId)){
						$productAttrFilterVo = new ProductAttributeVo();
						$productAttrFilterVo->id = $orderProduct->productAttributeId;
						$productAttributeVo = $productAttributeSv->selectByKey($productAttrFilterVo);
					}
					$product = new ProductHomeExtendVo(); 
					$product->id = $orderProduct->productId;

					$cartSv->shoppingCartUpdate(0, $product, $productAttributeVo);
				}
			}
		}else{
			$cartSv->shoppingCartUpdate($quantity, $product, $productAttributeVo);
		}
		
	}
}