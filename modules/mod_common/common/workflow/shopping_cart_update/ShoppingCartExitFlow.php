<?php

namespace common\workflow\shopping_cart_update;

use core\workflow\ContextBase;
use core\workflow\ExitFlow;
use core\utils\SessionUtil;
use common\persistence\base\vo\CartInfoVo;
use common\services\order\CartInfoService;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use frontend\service\CartHelper;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\product\ProductHomeService;
use common\helper\LocalizationHelper;

class ShoppingCartExitFlow extends ExitFlow {
	public function process(ContextBase &$context) {
		if(is_null(SessionUtil::get("sessionId"))){
			$sessionId = session_id();
			SessionUtil::set("sessionId", $sessionId);
		}
		
		$orderChargeInfo = SessionUtil::get("orderChargeInfo");
		$orderSurcharges = SessionUtil::get("orderSurcharge");
		$listOrderProduct = SessionUtil::get("listOrderProduct");
		$orderVo = SessionUtil::get("order");
		
		$orderTotalVos = CartHelper::generateOrderTotalList($orderSurcharges, $listOrderProduct, $orderVo);
		//recaculate for  "orderChargeInfo" match order total
		
		$orderChargeInfo = new OrderChargeInfoVo();
		$orderChargeInfo->subTotalAmount = $orderTotalVos["subtotal"]->value;
		
		if (isset($orderTotalVos["shipping"])){
			$orderChargeInfo->shippingAmount = $orderTotalVos["shipping"]->value;
		}else{
			$orderChargeInfo->shippingAmount = 0;
		}
		
		if (isset($orderTotalVos["taxtotal"])){
			$orderChargeInfo->taxAmount = $orderTotalVos["taxtotal"]->value;
		}else{
			$orderChargeInfo->taxAmount = 0;
		}
		
		if (isset($orderTotalVos["coupon"])){
			$orderChargeInfo->discountAmount = $orderTotalVos["coupon"]->value;
		}else{
			$orderChargeInfo->discountAmount = 0;
		}
		
		$orderChargeInfo->grandTotalAmount = $orderTotalVos["total"]->value;
		
		
		SessionUtil::set("orderChargeInfo", $orderChargeInfo);
		
		$infoArray = array(
				"orderChargeInfo" => $orderChargeInfo,
				"orderSurcharges" => $orderSurcharges,
				"listOrderProduct" => $listOrderProduct,
				'order' => $orderVo
		);
		
		$sessionId = SessionUtil::get("sessionId");
		$cartInfoVo = new CartInfoVo();
		$cartInfoSv = new CartInfoService();
		$cartInfoVo->sessionId = $sessionId;
		$cartInfoVos = $cartInfoSv->getCartInfoByFilter($cartInfoVo);
		$isInsert = true;
		foreach ($cartInfoVos as $cartInfoTmpVo){
			if (AppUtil::isEmptyString($cartInfoTmpVo->orderId)){
				$isInsert = false;
				$cartInfoVo = $cartInfoTmpVo; 
				break;
			}
		}
		if ($isInsert){
			$cartInfoVo->crDate = date("Y-m-d H:i:s");
			$cartInfoVo->crBy = 0;
			$cartInfoVo->info = JsonUtil::encode($infoArray);
			$cartId = $cartInfoSv->addCartInfo($cartInfoVo);
			//SessionUtil::set("cart.transaction.id", AppUtil::generateCartTxnId($cartId));
		}else{
			$cartInfoVo->info = JsonUtil::encode($infoArray);
			$cartInfoSv->updateCartInfo($cartInfoVo);
		}
	}
}