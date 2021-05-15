<?php

namespace frontend\service;

use common\config\Attributes;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\order\CartInfoService;
use common\services\payment\PaymentMethodService;
use common\services\product\ProductHomeService;
use common\services\shipping\ShippingMethodService;
use common\utils\StringUtil;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\controllers\ControllerHelper;
use frontend\model\ShoppingCartModel;
use common\services\home\CartService;
use common\config\RegionEnum;
use frontend\common\Constants;

class CartHelper {
	public static function updateShoppingCart(ShoppingCartModel $shoppingCart) {
		$context = new ContextBase ();
		$context->set ( Attributes::SHOPPING_CART, $shoppingCart );
		WorkflowManager::Instance ()->execute ( "wfp_update_shopping_cart", $context );
		ErrorHelper::throwExceptionWhenError ( $context, "Error when update shopping cart" );
		return $context->get ( Attributes::SHOPPING_CART );
	}
	public static function generateOrderTotalListByCartInfo(CartInfoVo $cartInfoVo, $freeShipAmount = 200) {
		$arrayCartInfo = JsonUtil::decode ( $cartInfoVo->info );
		$orderSurcharges = $arrayCartInfo ["orderSurcharges"];
		$orderProductVos = $arrayCartInfo ["listOrderProduct"];
		$orderVo = $arrayCartInfo ["order"];
		return self::generateOrderTotalList ( $orderSurcharges, $orderProductVos, $orderVo, $freeShipAmount );
	}
	public static function isFreeShipping($orderSurcharges, $orderProductVos, $orderVo, $freeShipAmount = 200) {
		$freeShipAmount = 200;
		$orderTotalDiscountVo = null;
		$orderTotalSubTotalVo = null;
		$orderTotalCouponVo = null;
		$orderTotalTaxTotalVo = null;
		$orderTotalShippingTaxVo = null;
		$orderTotalSaleTaxVo = null;
		$orderTotalShippingVo = null;
		$orderTotalGrandTotalVo = null;
		$regionVo = ControllerHelper::getRegion ();
		if (! is_null ( $regionVo )) {
			if (! is_null ( $regionVo->freeShippingAmount ) && $regionVo->freeShippingAmount > 0) {
				$freeShipAmount = $regionVo->freeShippingAmount;
			}
		}
		if (! is_null ( $orderSurcharges ) && ! empty ( $orderSurcharges->getArray () )) {
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				switch ($orderSurcharge->surchargeType) {
					case "price_level" :
						if (is_null ( $orderTotalDiscountVo )) {
							$orderTotalDiscountVo = new OrderTotalVo ();
							$orderTotalDiscountVo->type = "discount";
							$orderTotalDiscountVo->title = "Cart Discount";
							$orderTotalDiscountVo->subtitle = "";
							$orderTotalDiscountVo->value = 0;
						}
						$orderTotalDiscountVo->value += $orderSurcharge->amount;
						break;
					case "bulk_discount" :
						if (is_null ( $orderTotalDiscountVo )) {
							$orderTotalDiscountVo = new OrderTotalVo ();
							$orderTotalDiscountVo->type = "discount";
							$orderTotalDiscountVo->title = "Cart Discount";
							$orderTotalDiscountVo->subtitle = "";
							$orderTotalDiscountVo->value = 0;
						}
						$orderTotalDiscountVo->value += $orderSurcharge->amount;
						break;
					case "coupon" :
						if (is_null ( $orderTotalCouponVo )) {
							$orderTotalCouponVo = new OrderTotalVo ();
							$orderTotalCouponVo->type = "coupon";
							$orderTotalCouponVo->title = "Discount Coupon";
							$orderTotalCouponVo->subtitle = $orderSurcharge->surchargeCode;
							$orderTotalCouponVo->value = 0;
						}
						$orderTotalCouponVo->value += $orderSurcharge->amount;
						break;
					case "shipping" :
						if (is_null ( $orderTotalShippingTaxVo )) {
							$orderTotalShippingTaxVo = new OrderTotalVo ();
							$orderTotalShippingTaxVo->type = "taxtotal";
							$orderTotalShippingTaxVo->title = "";
							$orderTotalShippingTaxVo->subtitle = "";
							$orderTotalShippingTaxVo->value = 0;
						}
						$orderTotalShippingTaxVo->value += $orderSurcharge->amount;
						$orderTotalShippingTaxVo->title .= $orderSurcharge->surchargeCode . "@@";
						break;
					case "tax_rate" :
						if (is_null ( $orderTotalSaleTaxVo )) {
							$orderTotalSaleTaxVo = new OrderTotalVo ();
							$orderTotalSaleTaxVo->type = "taxtotal";
							$orderTotalSaleTaxVo->title = "";
							$orderTotalSaleTaxVo->subtitle = "";
							$orderTotalSaleTaxVo->value = 0;
						}
						$orderTotalSaleTaxVo->value += $orderSurcharge->amount;
						$orderTotalSaleTaxVo->title .= $orderSurcharge->surchargeCode . "@@";
						break;
				}
			}
		}
		
		$orderTotalSubTotalVo = new OrderTotalVo ();
		$orderTotalSubTotalVo->type = "subtotal";
		$orderTotalSubTotalVo->title = "Subtotal";
		$orderTotalSubTotalVo->subtitle = "";
		$orderTotalSubTotalVo->value = 0;
		
		if (is_null ( $orderProductVos ) || empty ( $orderProductVos->getArray () )) {
			return $result;
		}
		
		foreach ( $orderProductVos->getArray () as $orderProduct ) {
			$orderTotalSubTotalVo->value += $orderProduct->basePrice * $orderProduct->quantity;
		}
		if (! is_null ( $orderTotalDiscountVo )) {
			$orderTotalSubTotalVo->value = $orderTotalSubTotalVo->value - $orderTotalDiscountVo->value;
		}
		// begin calculate for free shipping by subtotal - coupon discount
		$couponAmount = 0;
		if (! is_null ( $orderTotalCouponVo )) {
			$couponAmount = $orderTotalCouponVo->value;
		}
		// dertermine free shipping
		if ($orderTotalSubTotalVo->value - $couponAmount >= $freeShipAmount) {
			return true;
		}
		return false;
	}
	public static function generateOrderTotalList($orderSurcharges, $orderProductVos, $orderVo, $freeShipAmount = 200) {
		$freeShipAmount = 200;
		$result = array ();
		$orderTotalDiscountVo = null;
		$orderTotalSubTotalVo = null;
		$orderTotalCouponVo = null;
		$orderTotalTaxTotalVo = null;
		$orderTotalShippingTaxVo = null;
		$orderTotalSaleTaxVo = null;
		$orderTotalShippingVo = null;
		$orderTotalGrandTotalVo = null;
		$regionVo = ControllerHelper::getRegion ();
		if (! is_null ( $regionVo )) {
			if (! is_null ( $regionVo->freeShippingAmount ) && $regionVo->freeShippingAmount > 0) {
				$freeShipAmount = $regionVo->freeShippingAmount;
			}
		}
		if (! is_null ( $orderSurcharges ) && ! empty ( $orderSurcharges->getArray () )) {
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				switch ($orderSurcharge->surchargeType) {
					case "price_level" :
						if (is_null ( $orderTotalDiscountVo )) {
							$orderTotalDiscountVo = new OrderTotalVo ();
							$orderTotalDiscountVo->type = "discount";
							$orderTotalDiscountVo->title = "Cart Discount";
							$orderTotalDiscountVo->subtitle = "";
							$orderTotalDiscountVo->value = 0;
						}
						$orderTotalDiscountVo->value += $orderSurcharge->amount;
						break;
					case "bulk_discount" :
						if (is_null ( $orderTotalDiscountVo )) {
							$orderTotalDiscountVo = new OrderTotalVo ();
							$orderTotalDiscountVo->type = "discount";
							$orderTotalDiscountVo->title = "Cart Discount";
							$orderTotalDiscountVo->subtitle = "";
							$orderTotalDiscountVo->value = 0;
						}
						$orderTotalDiscountVo->value += $orderSurcharge->amount;
						break;
					case "coupon" :
						if (is_null ( $orderTotalCouponVo )) {
							$orderTotalCouponVo = new OrderTotalVo ();
							$orderTotalCouponVo->type = "coupon";
							$orderTotalCouponVo->title = "Discount Coupon";
							$orderTotalCouponVo->subtitle = $orderSurcharge->surchargeCode;
							$orderTotalCouponVo->value = 0;
						}
						$orderTotalCouponVo->value += $orderSurcharge->amount;
						break;
					case "shipping" :
						if (is_null ( $orderTotalShippingTaxVo )) {
							$orderTotalShippingTaxVo = new OrderTotalVo ();
							$orderTotalShippingTaxVo->type = "taxtotal";
							$orderTotalShippingTaxVo->title = "";
							$orderTotalShippingTaxVo->subtitle = "";
							$orderTotalShippingTaxVo->value = 0;
						}
						$orderTotalShippingTaxVo->value += $orderSurcharge->amount;
						$orderTotalShippingTaxVo->title .= $orderSurcharge->surchargeCode . "@@";
						break;
					case "tax_rate" :
						if (is_null ( $orderTotalSaleTaxVo )) {
							$orderTotalSaleTaxVo = new OrderTotalVo ();
							$orderTotalSaleTaxVo->type = "taxtotal";
							$orderTotalSaleTaxVo->title = "";
							$orderTotalSaleTaxVo->subtitle = "";
							$orderTotalSaleTaxVo->value = 0;
						}
						$orderTotalSaleTaxVo->value += $orderSurcharge->amount;
						$orderTotalSaleTaxVo->title .= $orderSurcharge->surchargeCode . "@@";
						break;
				}
			}
		}
		
		$orderTotalSubTotalVo = new OrderTotalVo ();
		$orderTotalSubTotalVo->type = "subtotal";
		$orderTotalSubTotalVo->title = "Subtotal";
		$orderTotalSubTotalVo->subtitle = "";
		$orderTotalSubTotalVo->value = 0;
		
		if (is_null ( $orderProductVos ) || empty ( $orderProductVos->getArray () )) {
			return $result;
		}
		
		foreach ( $orderProductVos->getArray () as $orderProduct ) {
			$orderTotalSubTotalVo->value += $orderProduct->basePrice * $orderProduct->quantity;
		}
		if (! is_null ( $orderTotalDiscountVo )) {
			$orderTotalSubTotalVo->value = $orderTotalSubTotalVo->value - $orderTotalDiscountVo->value;
		}
		
		// @TODO: Modify for free shipping later
		
		if (! AppUtil::isEmptyString ( $orderVo->shippingMethodItem )) {
			$shippingMethodItemVo = JsonUtil::base64Decode ( $orderVo->shippingMethodItem );
			if (! is_null ( $shippingMethodItemVo )) {
				$shippingMethodName = "";
				$shippingMethodId = "";
				$shippingMethodInfo = "";
				$shippingMethodVo = new ShippingMethodVo ();
				$shippingMethodSv = new ShippingMethodService ();
				
				$shippingMethodId = $orderVo->shippingMethod;
				$shippingMethodVo->id = $shippingMethodId;
				$shippingMethodVo = $shippingMethodSv->selectBykey ( $shippingMethodVo );
				if (isset ( $shippingMethodVo )) {
					if (isset ( $shippingMethodVo->name )) {
						$shippingMethodName = $shippingMethodVo->name;
					}
				}
				// Backup Shipping Method Id
				$shippingMethodOld = $orderVo->shippingMethod;
				
				$orderTotalShippingVo = new OrderTotalVo ();
				$orderTotalShippingVo->type = "shipping";
				$orderTotalShippingVo->title = $shippingMethodName;
				$orderTotalShippingVo->subtitle = StringUtil::loadShippingMethodName ( $shippingMethodItemVo, $shippingMethodId );
				if ($shippingMethodItemVo->cost == 0) {
					$orderTotalShippingVo->title = "Free Shipping";
					$orderTotalShippingVo->subtitle = "Free Shipping";
				}
				$orderTotalShippingVo->value = $shippingMethodItemVo->cost;
			}
		}
		// begin calculate for free shipping by subtotal - coupon discount
		$couponAmount = 0;
		if (! is_null ( $orderTotalCouponVo )) {
			$couponAmount = $orderTotalCouponVo->value;
		}
		// end calculate for free shipping by subtotal - coupon discount
		// calculate for taxtotal
		$orderTotalTaxTotalVo = new OrderTotalVo ();
		$orderTotalTaxTotalVo->type = "taxtotal";
		$orderTotalTaxTotalVo->title = "";
		$orderTotalTaxTotalVo->subtitle = "";
		$orderTotalTaxTotalVo->value = 0;
		
		if (! is_null ( $orderTotalSaleTaxVo )) {
			$orderTotalTaxTotalVo->value = $orderTotalSaleTaxVo->value;
			$orderTotalTaxTotalVo->title = $orderTotalSaleTaxVo->title;
		}
		
		if (! is_null ( $orderTotalShippingTaxVo )) {
			$orderTotalTaxTotalVo->value += $orderTotalShippingTaxVo->value;
			$orderTotalTaxTotalVo->title .= $orderTotalShippingTaxVo->title;
		}
		
		if ($orderTotalTaxTotalVo->value < 0 || AppUtil::isEmptyString ( $orderTotalSaleTaxVo->title )) {
			$orderTotalTaxTotalVo = null;
		}
		
		$orderTotalGrandTotalVo = new OrderTotalVo ();
		$orderTotalGrandTotalVo->type = "total";
		$orderTotalGrandTotalVo->title = "Total";
		$orderTotalGrandTotalVo->subtitle = "";
		$orderTotalGrandTotalVo->value = $orderTotalSubTotalVo->value + (is_null ( $orderTotalShippingVo ) ? 0 : $orderTotalShippingVo->value) + (is_null ( $orderTotalTaxTotalVo ) ? 0 : $orderTotalTaxTotalVo->value) - (is_null ( $orderTotalCouponVo ) ? 0 : $orderTotalCouponVo->value);
		if (! is_null ( $orderTotalDiscountVo )) {
			$result [$orderTotalDiscountVo->type] = $orderTotalDiscountVo;
		}
		if (! is_null ( $orderTotalSubTotalVo )) {
			$result [$orderTotalSubTotalVo->type] = $orderTotalSubTotalVo;
		}
		if (! is_null ( $orderTotalCouponVo )) {
			$result [$orderTotalCouponVo->type] = $orderTotalCouponVo;
		}
		if (! is_null ( $orderTotalTaxTotalVo )) {
			$orderTotalTaxTotalVo->title = substr ( $orderTotalTaxTotalVo->title, 0, strlen ( $orderTotalTaxTotalVo->title ) - 2 );
			$result [$orderTotalTaxTotalVo->type] = $orderTotalTaxTotalVo;
		}
		if (! is_null ( $orderTotalShippingVo )) {
			$result [$orderTotalShippingVo->type] = $orderTotalShippingVo;
		}
		if (! is_null ( $orderTotalGrandTotalVo )) {
			$result [$orderTotalGrandTotalVo->type] = $orderTotalGrandTotalVo;
		}
		return $result;
	}
	public static function getCartInfoVoBySessionId($sessionId, $orderId = null) {
		$cartInfoVo = new CartInfoVo ();
		$cartInfoSv = new CartInfoService ();
		$cartInfoVo->sessionId = $sessionId;
		$cartInfoVo->orderId = $orderId;
		$cartInfoVos = $cartInfoSv->getCartInfoByFilter ( $cartInfoVo );
		foreach ( $cartInfoVos as $cartInfoVo ) {
			if ($cartInfoVo->orderId == $orderId) {
				break;
			}
		}
		return $cartInfoVo;
	}
	public static function getCartInfoVoById($cartId) {
		$cartInfoVo = new CartInfoVo ();
		$cartInfoSv = new CartInfoService ();
		$cartInfoVo->id = $cartId;
		$cartInfoVo = $cartInfoSv->getCartInfoByKey ( $cartInfoVo );
		return $cartInfoVo;
	}
	public static function getCartInfoVoByOrderId($orderId) {
		$cartInfoVo = new CartInfoVo ();
		$cartInfoSv = new CartInfoService ();
		$cartInfoVo->orderId = $orderId;
		$cartInfoVos = $cartInfoSv->getCartInfoByFilter ( $cartInfoVo );
		if (! empty ( $cartInfoVos ) && count ( $cartInfoVos ) > 0) {
			$cartInfoVo = $cartInfoVos [0];
		}
		return $cartInfoVo;
	}
	public static function getOrderVoByInfo($info) {
		$obj = null;
		if (! empty ( $info )) {
			$decodeObj = JsonUtil::decode ( $info );
			$obj = $decodeObj->order;
			if (! ($obj instanceof OrderVo)) {
				$tObj = new OrderVo ();
				AppUtil::perfectCopyProperties ( $obj, $tObj );
				$obj = $tObj;
			}
		}
		return $obj;
	}
	public static function getOrderChargeInfoVoByInfo($info) {
		$obj = null;
		if (! empty ( $info )) {
			$decodeObj = JsonUtil::decode ( $info );
			$obj = $decodeObj->orderChargeInfo;
			if (! ($obj instanceof OrderChargeInfoVo)) {
				$tObj = new OrderChargeInfoVo ();
				AppUtil::perfectCopyProperties ( $obj, $tObj );
				$obj = $tObj;
			}
		}
		return $obj;
	}
	public static function getOrderSurchargeVo($info) {
		$obj = null;
		if (! empty ( $info )) {
			$decodeObj = JsonUtil::decode ( $info );
			$obj = $decodeObj->orderSurcharges;
		}
		return $obj;
	}
	public static function getListOrderProductByInfo($info) {
		$objList = null;
		if (! empty ( $info )) {
			$decodeObj = JsonUtil::decode ( $info );
			$objList = $decodeObj->listOrderProduct;
			// if (! empty ( $objList ) && count ( $objList ) > 0)
			// if (! ($objList [0] instanceof OrderProductVo))
			// $objList = null;
		}
		return $objList;
	}
	public static function clearCartSession() {
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId == 0) {
			SessionUtil::remove ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		}
		
		SessionUtil::remove ( "order" );
		SessionUtil::remove ( "orderChargeInfo" );
		SessionUtil::remove ( "orderSurcharge" );
		SessionUtil::remove ( "listOrderProduct" );
		SessionUtil::remove ( "sessionId" );
		SessionUtil::remove ( "responseVo" );
		SessionUtil::remove ( "payment_redirect_url" );
		// clear everything relate to cart session
		SessionUtil::remove ( "cartInfo" );
		SessionUtil::remove ( "orderHistory" );
	}
	public static function updateOrderProductName() {
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		$orderVo = SessionUtil::get ( "order" );
		if (is_null ( $listOrderProduct ) || is_null ( $orderVo )) {
			return;
		}
		if ($orderVo->languageCode !== SessionUtil::get ( "language.default.code" )) {
			foreach ( $listOrderProduct->getArray () as $orderProduct ) {
				$productVo = new ProductHomeExtendVo ();
				$productSv = new ProductHomeService ();
				$productVo->id = $orderProduct->productId;
				$productVo->languageCode = ControllerHelper::getLangCode ();
				$productVo->currencyCode = ControllerHelper::getCurrencyCode ();
				$productVo->regionId = ControllerHelper::getRegionId ();
				$productVo = $productSv->getProductHomeById ( $productVo );
				$orderProduct->name = $productVo->name;
			}
		}
	}
	public static function updateOrderVo($orderVo) {
		$sessionOrderVo = AppUtil::cloneObj ( $orderVo );
		$shippingMethodName = "";
		$shippingMethodId = "";
		$shippingMethodInfo = "";
		$shippingMethodVo = new ShippingMethodVo ();
		$shippingMethodSv = new ShippingMethodService ();
		
		$shippingMethodId = $sessionOrderVo->shippingMethod;
		$shippingMethodVo->id = $shippingMethodId;
		$shippingMethodVo = $shippingMethodSv->selectBykey ( $shippingMethodVo );
		if (isset ( $shippingMethodVo )) {
			if (isset ( $shippingMethodVo->name )) {
				$shippingMethodName = $shippingMethodVo->name;
			}
		}
		if (! is_null ( $sessionOrderVo->shippingMethodItem )) {
			$shippingMethodInfo = $sessionOrderVo->shippingMethodItem;
			if (! is_null ( JsonUtil::base64Decode ( $shippingMethodInfo ) )) {
				$shippingMethodInfo = JsonUtil::base64Decode ( $shippingMethodInfo );
			}
		}
		// Backup Shipping Method Id
		$shippingMethodOld = $sessionOrderVo->shippingMethod;
		
		// Backup Shipping Info
		$shippingMethodItemOld = $sessionOrderVo->shippingMethodItem;
		if (isset ( $orderTotalVos ["shipping"] ) && $orderTotalVos ["shipping"]->title == "Free Shipping") {
			$orderTotalShippingVo = $orderTotalVos ["shipping"];
			$sessionOrderVo->shippingMethod = $orderTotalShippingVo->title;
			$sessionOrderVo->shippingMethodItem = $orderTotalShippingVo->subtitle;
		} else {
			$sessionOrderVo->shippingMethod = $shippingMethodName;
			$sessionOrderVo->shippingMethodItem = StringUtil::loadShippingMethodName ( $shippingMethodInfo, $shippingMethodId );
		}
		// Get Shipping Name
		$paymentMethodName = "";
		$paymentMethodId = "";
		$paymentMethodVo = new PaymentMethodVo ();
		$paymentMethodSv = new PaymentMethodService ();
		if (isset ( $sessionOrderVo->paymentMethod )) {
			$paymentMethodId = $sessionOrderVo->paymentMethod;
		}
		$paymentMethodVo->id = $paymentMethodId;
		$paymentMethodVo = $paymentMethodSv->selectBykey ( $paymentMethodVo );
		if (! is_null ( $paymentMethodVo )) {
			$paymentMethodName = $paymentMethodVo->name;
		}
		
		// Backup Payment method id
		$paymentMethodOld = $sessionOrderVo->paymentMethod;
		
		$sessionOrderVo->paymentMethod = $paymentMethodName;
		
		return $sessionOrderVo;
	}
	public static function updateCartInfoVoByOrderVo(CartInfoVo $cartInfoVo, OrderVo $orderVo) {
		$info = $cartInfoVo->info;
		// $order = self::getOrderVoByInfo ( $info );
		$order = $orderVo;
		$orderChargeInfo = self::getOrderChargeInfoVoByInfo ( $info );
		$orderSurcharges = self::getOrderSurchargeVo ( $info );
		$listOrderProduct = self::getListOrderProductByInfo ( $info );
		
		$infoArray = array (
				"orderChargeInfo" => $orderChargeInfo,
				"orderSurcharges" => $orderSurcharges,
				"listOrderProduct" => $listOrderProduct,
				"order" => $order 
		);
		$cartInfoVo->orderId = $order->id;
		$cartInfoVo->info = JsonUtil::encode ( $infoArray );
		$cartInfoSv = new CartInfoService ();
		$cartInfoSv->updateCartInfo ( $cartInfoVo );
		return $cartInfoVo;
	}
	public static function createCartInfoVoFromPrevCart($sessionId, $orderId = null) {
// 		\DatoLogUtil::debug ( '+ createCartInfoVoFromPrevCart +' );
// 		\DatoLogUtil::debug ( "sessionId: $sessionId orderId: $orderId" );
		$cartInfoVo = new CartInfoVo ();
		$cartInfoVo = self::getCartInfoVoBySessionId ( $sessionId, $orderId );
		$info = $cartInfoVo->info;
		$orderVo = self::getOrderVoByInfo ( $info );
		$orderChargeInfo = self::getOrderChargeInfoVoByInfo ( $info );
		$orderSurcharges = self::getOrderSurchargeVo ( $info );
		$listOrderProduct = self::getListOrderProductByInfo ( $info );
		$orderChargeInfo->orderId = null;
		$orderVo->id = null;
		$infoArray = array (
				"orderChargeInfo" => $orderChargeInfo,
				"orderSurcharges" => $orderSurcharges,
				"listOrderProduct" => $listOrderProduct,
				"order" => $orderVo 
		);
		$cartInfoVo->id = null;
		$cartInfoVo->orderId = $order->id;
		$cartInfoVo->info = JsonUtil::encode ( $infoArray );
		$cartInfoSv = new CartInfoService ();
		$cartInfoSv->addCartInfo ( $cartInfoVo );
// 		\DatoLogUtil::debug ( '- createCartInfoVoFromPrevCart -' );
		return $cartInfoVo;
	}
}