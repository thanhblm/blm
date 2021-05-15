<?php

namespace common\services\home;

use api\controllers\ControllerHelper;
use common\helper\LocalizationHelper;
use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\dao\OrderChargeInfoBaseDao;
use common\persistence\base\dao\OrderHistoryBaseDao;
use common\persistence\base\dao\OrderProductBaseDao;
use common\persistence\base\dao\OrderSurchargeBaseDao;
use common\persistence\base\dao\OrderTotalBaseDao;
use common\persistence\base\dao\PaymentTxnBaseDao;
use common\persistence\base\dao\PriceLevelBaseDao;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderSurchargeVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\extend\dao\ProductHomeExtendDao;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\base\BaseService;
use common\services\bulk_discount\BulkDiscountProductService;
use common\services\customer\CustomerService;
use common\services\order\CartInfoService;
use common\services\payment\PaymentMethodService;
use common\services\shipping\ShippingMethodService;
use common\utils\StringUtil;
use core\database\SqlMapClient;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\service\CartHelper;
use common\utils\ObjectUtil;
use common\utils\DateUtil;
use core\utils\RequestUtil;
use frontend\service\OrderHelper;

class CartService extends BaseService {
	public function __construct($context = array()) {
		parent::__construct ( $context );
	}
	public function insertOrder(OrderVo $order) {
		$sqlMapClient = new SqlMapClient ( $this->context );
		$orderDao = new OrderBaseDao ( $this->context, $sqlMapClient );
		$orderChargeInfoDao = new OrderChargeInfoBaseDao ( $this->context, $sqlMapClient );
		$orderSurchargeDao = new OrderSurchargeBaseDao ( $this->context, $sqlMapClient );
		$orderProductDao = new OrderProductBaseDao ( $this->context, $sqlMapClient );
		$orderHistoryDao = new OrderHistoryBaseDao ( $this->context, $sqlMapClient );
		$paymentTxnDao = new PaymentTxnBaseDao ( $this->context, $sqlMapClient );
		$orderTotalDao = new OrderTotalBaseDao ( $this->context, $sqlMapClient );
		$cartInfoVo = null;
		$sqlMapClient->startTransaction ();
		try {
			$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
			$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
			$orderTotalVos = CartHelper::generateOrderTotalList ( $orderSurcharges, $listOrderProduct, $order );
			$shippingMethodName = "";
			$shippingMethodId = "";
			$shippingMethodInfo = "";
			$shippingMethodVo = new ShippingMethodVo ();
			$shippingMethodSv = new ShippingMethodService ();
			
			$shippingMethodId = $order->shippingMethod;
			$shippingMethodVo->id = $shippingMethodId;
			$shippingMethodVo = $shippingMethodSv->selectBykey ( $shippingMethodVo );
			if (isset ( $shippingMethodVo )) {
				if (isset ( $shippingMethodVo->name )) {
					$shippingMethodName = $shippingMethodVo->name;
				}
			}
			if (! is_null ( $order->shippingMethodItem )) {
				$shippingMethodInfo = $order->shippingMethodItem;
				if (! is_null ( JsonUtil::base64Decode ( $shippingMethodInfo ) )) {
					$shippingMethodInfo = JsonUtil::base64Decode ( $shippingMethodInfo );
				}
			}
			// Backup Shipping Method Id
			$shippingMethodOld = $order->shippingMethod;
			
			// Backup Shipping Info
			$shippingMethodItemOld = $order->shippingMethodItem;
			if (CartHelper::isFreeShipping($orderSurcharges, $listOrderProduct, $order)) {
				$order->shippingMethod = "Free Shipping";
				$order->shippingMethodItem = "Free Shipping";
			} else {
				$order->shippingMethod = $shippingMethodName;
				$order->shippingMethodItem = StringUtil::loadShippingMethodName ( $shippingMethodInfo, $shippingMethodId );
			}
			$counponCode = "";
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				if ("coupon" === $orderSurcharge->surchargeType) {
					$counponCode = $orderSurcharge->surchargeCode;
				}
			}
			$order->couponCode = $counponCode;
			// Get Shipping Name
			$paymentMethodName = "";
			$paymentMethodId = "";
			$paymentMethodVo = new PaymentMethodVo ();
			$paymentMethodSv = new PaymentMethodService ();
			if (isset ( $order->paymentMethod )) {
				$paymentMethodId = $order->paymentMethod;
			}
			$paymentMethodVo->id = $paymentMethodId;
			$paymentMethodVo = $paymentMethodSv->selectBykey ( $paymentMethodVo );
			if (! is_null ( $paymentMethodVo )) {
				$paymentMethodName = $paymentMethodVo->name;
			}
			
			// Backup Payment method id
			$paymentMethodOld = $order->paymentMethod;
			
			$order->paymentMethod = $paymentMethodName;
			ObjectUtil::setCrMd ( $order );
			$order->crDate = DateUtil::getCurrentDT();
			$orderId = $orderDao->insertDynamic ( $order );
			$order->id = $orderId;
			$orderChargeInfo = SessionUtil::get ( "orderChargeInfo" );
			$orderChargeInfo->orderId = $orderId;
			$orderChargeInfoDao->insertDynamic ( $orderChargeInfo );
			
			$counponCode = "";
			$discountAmount = 0;
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				if ("bulk_discount" === $orderSurcharge->surchargeType) {
					$discountAmount += $orderSurcharge->amount;
				}
				if ("price_level" === $orderSurcharge->surchargeType) {
					$discountAmount += $orderSurcharge->amount;
				}
				if ("counpon" === $orderSurcharge->surchargeType) {
					$counponCode = $orderSurcharge->surchargeCode;
				}
				$orderSurchargeVo = new OrderSurchargeVo ();
				AppUtil::copyProperties ( $orderSurcharge, $orderSurchargeVo );
				$orderSurchargeVo->orderId = $orderId;
				$orderSurchargeDao->insertDynamic ( $orderSurchargeVo );
			}
			
			$arraySort = array (
					"discount" => "Cart Discount",
					"subtotal" => "Subtotal",
					"coupon" => "Discount",
					"taxtotal" => "",
					"shipping" => "Shipping",
					"total" => "Grand Total" 
			);
			foreach ( $arraySort as $key => $value ) {
				if (! isset ( $orderTotalVos [$key] )) {
					continue;
				}
				$orderTotalVo = $orderTotalVos [$key];
				$orderTotalVo->orderId = $orderId;
				$orderTotalVo->title = str_replace ( "@@", "+", $orderTotalVo->title );
				$orderTotalDao->insertDynamic ( $orderTotalVo );
			}
			
			foreach ( $listOrderProduct->getArray () as $orderProduct ) {
				$orderProductVo = new OrderProductVo ();
				AppUtil::copyProperties ( $orderProduct, $orderProductVo );
				$orderProductVo->orderId = $orderId;
				$orderProductVo->basePrice = $orderProductVo->basePrice;
				$orderProductDao->insertDynamic ( $orderProductVo );
			}
			
			$order4DbVo = AppUtil::cloneObj ( $order );
			$order->paymentMethod = $paymentMethodOld;
			$order->shippingMethod = $shippingMethodOld;
			$order->shippingMethodItem = $shippingMethodItemOld;
			
			$infoArray = array (
					"orderChargeInfo" => $orderChargeInfo,
					"orderSurcharges" => $orderSurcharges,
					"listOrderProduct" => $listOrderProduct,
					"order" => $order 
			);
			\DatoLogUtil::debug ( $order );
			SessionUtil::set ( "order", $order );
			SessionUtil::set ( "orderChargeInfo", $orderChargeInfo );
			$sessionId = SessionUtil::get ( "sessionId" );
			$cartInfoVo = new CartInfoVo ();
			$cartInfoSv = new CartInfoService ();
			$cartInfoVo->sessionId = $sessionId;
			$cartInfoVos = $cartInfoSv->getCartInfoByFilter ( $cartInfoVo );
			
			$isInsert = true;
			foreach ( $cartInfoVos as $cartInfoTmpVo ) {
				if (AppUtil::isEmptyString ( $cartInfoTmpVo->orderId )) {
					$isInsert = false;
					$cartInfoVo = $cartInfoTmpVo;
					break;
				}
			}
			
			if (! $isInsert) {
				$cartInfoVo->info = JsonUtil::encode ( $infoArray );
				$cartInfoVo->orderId = $orderId;
				\DatoLogUtil::debug ( $cartInfoVo );
				$cartInfoSv->updateCartInfo ( $cartInfoVo );
			}
			
			// $orderHistorVo = new OrderHistoryVo ();
			// $orderHistorVo->crBy = $order->crBy;
			// $orderHistorVo->crDate = $order->crDate;
			// $orderHistorVo->status = $orderHistory->status;
			// $orderHistorVo->orderId = $order->id;
			// $orderHistorVo->description = $orderHistory->description;
			// $orderHistorVo->cusNotified = $orderHistory->cusNotified;
			
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
		
		return $cartInfoVo;
	}
	public function updateOrder() {
		try {
			
			$sqlMapClient = new SqlMapClient ( $this->context );
			$orderDao = new OrderBaseDao ( $this->context, $sqlMapClient );
			$orderHistoryDao = new OrderHistoryBaseDao ( $this->context, $sqlMapClient );
			$sqlMapClient->startTransaction ();
			$order = RequestUtil::get ( 'order' );
			// update order status
			// insert order history
			$orderHistorVo = new OrderHistoryVo ();
			$orderHistorVo->crBy = $order->crBy;
			$orderHistorVo->crDate = $order->crDate;
			$orderHistorVo->status = $order->status;
			$orderHistorVo->orderId = $order->id;
			$orderHistorVo->description = "Status Update";
			$orderHistorVo->cusNotified = "no";
			$orderHistoryDao->insertDynamic ( $orderHistorVo );
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
		
		return $cartInfoVo;
	}
	public function shoppingCartUpdate($quantity, ProductHomeExtendVo $product, ProductAttributeVo $productAttributeVo = null) {
		$quantity = intval ( $quantity );
		$productOrderFilter = new OrderProductExtendVo ();
		$productOrderFilter->productId = $product->id;
		$foundProduct = $this->updateQuantityCart ( $productOrderFilter, $quantity, $productAttributeVo );
		// if isUpdate = true : reUpdate Price with bulkdiscount
		// if isUpdate = false : insert new product to cart with bulkDiscount
		if (! is_null ( $foundProduct ) && $foundProduct->quantity > 0) {
			$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
			$orderProductNew = AppUtil::cloneObj ( $foundProduct );
			$productUpdate = AppUtil::cloneObj ( $product );
			$productUpdate->id = $orderProductNew->productId;
			$productUpdate->price = $orderProductNew->basePrice;
			$productUpdate->name = $orderProductNew->name;
			$productUpdate->images = $orderProductNew->productImage;
			$this->removeProductFromSessionById ( $foundProduct->productId );
			if ($orderProductNew->quantity > 0) {
				$this->addOrderProduct ( $productUpdate, $orderProductNew, $orderProductNew->quantity, $productAttributeVo );
			}
		} elseif (! $foundProduct && $quantity > 0) {
			$orderProduct = new OrderProductExtendVo ();
			$this->addOrderProduct ( $product, $orderProduct, $quantity, $productAttributeVo );
		}
	}
	private function removeProductFromSessionById($productId) {
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		if (! empty ( $listOrderProduct->getArray () )) {
			foreach ( $listOrderProduct->getArray () as $product ) {
				if ($product->productId == $productId) {
					$listOrderProduct->remove ( $product );
					break;
				}
			}
		}
	}
	private function addOrderProduct(ProductHomeExtendVo $productUpdate, OrderProductExtendVo $orderProduct, $quantityProduct, ProductAttributeVo $productAttributeVo = null) {
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		$productHomeDao = new ProductHomeExtendDao ();
		$productExtendVo = new ProductHomeExtendVo ();
		$productExtendVo->id = $productUpdate->id;
		$productExtendVo->currencyCode = LocalizationHelper::getCurrencyCode ();
		$productExtendVo->languageCode = LocalizationHelper::getLangCode ();
		$productExtendVo = $productHomeDao->getProductHomeById ( $productExtendVo );
		$orderProduct->productId = $productUpdate->id;
		$orderProduct->name = $productUpdate->name;
		$orderProduct->basePrice = floatval ( $productExtendVo->basePrice );
		if($productAttributeVo != null){
			$orderProduct->productAttributeId = $productAttributeVo->id;
			$orderProduct->basePrice = $productAttributeVo->price;
		}
		$orderProduct->price = $orderProduct->basePrice * $quantityProduct;
		$orderProduct->quantity = intval ( $quantityProduct );
		$orderProduct->productImage = $productUpdate->images;
		$orderProduct->languageCode = $productExtendVo->languageCode;
		$orderProduct->seoKeywords = $productExtendVo->seoKeywords;
		$orderProduct->seoDescription = $productExtendVo->seoDescription;
		$orderProduct->seoTitle = $productExtendVo->seoTitle;
		$orderProduct->seoUrl = $productExtendVo->seoUrl;
		$orderProduct->productCode = $productExtendVo->code;
		$orderProduct->symbol = $productExtendVo->symbol;
		$discount = 0;
		$discountPriceLevel = 0;
		$discountBulk = 0;
		$bulkDiscount = $this->getBulkDiscount ( $orderProduct );
		if (isset ( $bulkDiscount->discount )) {
			$discountBulk = $bulkDiscount->discount;
		}
		$customerPriceLevel = $this->isCustomerPriceLevel ();
		if (! is_null ( $customerPriceLevel )) {
			$priceLevelVo = new PriceLevelVo ();
			$priceLevelDao = new PriceLevelBaseDao ();
			$priceLevelVo->id = $customerPriceLevel->priceLevelId;
			$priceLevel = $priceLevelDao->selectByKey ( $priceLevelVo );
			$discountPriceLevel = $priceLevel->value;
		}
		
		if ($discountPriceLevel >= $discountBulk) {
			$discount = $discountPriceLevel;
		} else {
			$discount = $discountBulk;
		}
		$orderProduct->discount = $discount;
		if ($discount > 0) {
			$orderProduct->price = $orderProduct->basePrice - StringUtil::calculatePerPrice ( $discount, $orderProduct->basePrice );
			
			if ($quantityProduct > 0) {
				$orderProduct->price = $orderProduct->price * $quantityProduct;
			}
			
			$orderSurcharge = new OrderSurchargeExtendVo ();
			
			if ($discountPriceLevel >= $discountBulk) {
				$orderSurcharge->surchargeType = "price_level";
			} else {
				$orderSurcharge->surchargeType = "bulk_discount";
			}
			
			$orderSurcharge->surchargeCode = $orderProduct->productId;
			$orderSurcharge->amount = StringUtil::calculatePerPrice ( $discount, $orderProduct->basePrice * $quantityProduct );
			$orderSurcharge->surchargeId = $bulkDiscount->id;
			$orderSurcharge->data = json_encode ( $bulkDiscount );
			$orderSurcharges->add ( $orderSurcharge );
		}
		$listOrderProduct->add ( $orderProduct );
		SessionUtil::set ( "orderSurcharge", $orderSurcharges );
		SessionUtil::set ( "listOrderProduct", $listOrderProduct );
	}
	private function getBulkDiscount(OrderProductExtendVo $orderProduct) {
		$bulkDiscount = new BulkDiscountVo ();
		if ($this->isCustomerRetail ()) {
			$buldkDiscountProductSv = new BulkDiscountProductService ();
			$bulkDiscountExtendVo = new BulkDiscountExtendVo ();
			$bulkDiscountExtendVo->productId = $orderProduct->productId;
			$bulkDiscountExtendVo->productQuantity = $orderProduct->quantity;
			$bulkDiscountExtendVo->status = "active";
			$bulkDiscountExtendVo->dateNow = date ( "Y-m-d H:i:s" );
			$bulkDiscountExtendVo->order_by = "discount DESC";
			$bulkDiscountExtendVo->start_record = 0;
			$bulkDiscountExtendVo->end_record = 1;
			$bulkDiscountVo = $buldkDiscountProductSv->getBulkDiscountByProduct ( $bulkDiscountExtendVo );
			if (isset ( $bulkDiscountVo )) {
				$bulkDiscount = $bulkDiscountVo;
			}
		}
		return $bulkDiscount;
	}
	private function isCustomerRetail() {
		if (! is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) ) && !ControllerHelper::isGuestLogin() ) {
			$customerVo = new CustomerVo ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerVo->priceLevelId = 0;
			$customerSv = new CustomerService ();
			$customer = $customerSv->selectByKey ( $customerVo );
			if (! is_null ( $customer )) {
				return true;
			}
		} else {
			return true;
		}
		return false;
	}
	private function isCustomerPriceLevel() {
		if (! is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			$customerVo = new CustomerVo ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerSv = new CustomerService ();
			$customer = $customerSv->selectByKey ( $customerVo );
			if (! is_null ( $customer ) && ($customer->priceLevelId != 0)) {
				return $customer;
			}
		}
		return null;
	}
	
	/**
	 *
	 * @param OrderProductExtendVo $objectFilter        	
	 * @param unknown $quantity        	
	 * @return true: Update Quantity
	 *         false: Insert new product
	 */
	private function updateQuantityCart(OrderProductExtendVo $objectFilter, $quantity, ProductAttributeVo $productAttributeVo = null) {
		$arrayObj = SessionUtil::get ( "listOrderProduct" );
		$foundProduct = null;
		if (empty ( $arrayObj->getArray () )) {
			return $foundProduct;
		}
		foreach ( $arrayObj->getArray () as $product ) {
			$newOrderProduct = AppUtil::cloneObj ( $product );
			if ($product->productId == $objectFilter->productId) {
				$basePriceProduct = ($product->basePrice);
				if($productAttributeVo != null){
					$basePriceProduct = $productAttributeVo->price;
					$newOrderProduct->productAttributeId = $productAttributeVo->id;
				}
				$newOrderProduct->quantity = ($product->quantity + intval ( $quantity ));
				$newOrderProduct->basePrice = $basePriceProduct;
				$newOrderProduct->price = $basePriceProduct * $quantity;
				if ($newOrderProduct->quantity > 0) {
					$arrayObj->add ( $newOrderProduct );
				} else {
					$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
					foreach ( $orderSurcharges->getArray () as $orderSurchargeRemove ) {
						if ("bulk_discount" == $orderSurchargeRemove->surchargeType && $orderSurchargeRemove->surchargeCode == $objectFilter->productId) {
							$orderSurcharges->remove ( $orderSurchargeRemove );
						}
						if ("price_level" == $orderSurchargeRemove->surchargeType && $orderSurchargeRemove->surchargeCode == $objectFilter->productId) {
							$orderSurcharges->remove ( $orderSurchargeRemove );
						}
					}
				}
				$arrayObj->remove ( $product );
				$foundProduct = $newOrderProduct;
				return $foundProduct;
			}
		}
		return $foundProduct;
	}
}