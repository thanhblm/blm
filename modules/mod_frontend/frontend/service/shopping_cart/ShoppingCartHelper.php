<?php

namespace frontend\service\shopping_cart;

use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\product\ProductHomeService;
use core\BaseArray;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\model\ShoppingCartModel;
use frontend\service\CartHelper;

class ShoppingCartHelper {
	public static function create() {
		self::init ();
	}
	public static function clear() {
		SessionUtil::remove ( Constants::SESSION_SHOPPING_CART );
	}
	public static function addProduct(OrderProductVo $product) {
		$shoppingCartModel = self::getShoppingCart ();
		$products = $shoppingCartModel->products;
		if (empty ( $products->getArray () )) {
			$products->add ( $product );
		} else {
			// Search product.
			$foundProduct = null;
			foreach ( $products->getArray () as $item ) {
				if ($item->productId == $product->productId) {
					$foundProduct = $item;
					break;
				}
			}
			// If found -> increase quantity.
			if (! is_null ( $foundProduct )) {
				$foundProduct->quantity += $product->quantity;
				// Remove the product if it's quantity is less then zero.
				if (0 >= $foundProduct->quantity) {
					$products->remove ( $foundProduct );
				}
			} else {
				// If not found -> add to product líst.
				$products->add ( $product );
			}
		}
		self::update ();
	}
	public static function removeProduct(OrderProductVo $product) {
		$shoppingCartModel = self::getShoppingCart ();
		if (empty ( $shoppingCartModel->products->getArray () )) {
		} else {
			foreach ( $shoppingCartModel->products->getArray () as $item ) {
				if ($item->productId === $product->productId) {
					$shoppingCartModel->products->remove ( $item );
					break;
				}
			}
		}
		self::update ();
	}
	public static function updateShipping(RegionShippingMethodVo $regionShippingMethod, AddressVo $shippingAddress) {
		$shoppingCartModel = self::getShoppingCart ();
		$order = $shoppingCartModel->order;
		// Update region shipping method.
		$order->shippingMethodId = $regionShippingMethod->shippingMethodId;
		$order->shippingMethodInfo = $regionShippingMethod->settingInfo;
		// Update shipping address.
		$order->shipFirstName = $shippingAddress->firstName;
		$order->shipLastName = $shippingAddress->lastName;
		$order->shipEmail = $shippingAddress->email;
		$order->shipPhone = $shippingAddress->phone;
		$order->shipAddress = $shippingAddress->address;
		$order->shipCity = $shippingAddress->city;
		$order->shipZipCode = $shippingAddress->postalCode;
		$order->shipStateCode = $shippingAddress->state;
		$order->shipCountry = $shippingAddress->country;
		// Recalculate charges.
		self::update ();
	}
	public static function updatePayment(RegionPaymentMethodVo $regionPaymentMethod, AddressVo $billingAddress) {
		$shoppingCartModel = self::getShoppingCart ();
		$order = $shoppingCartModel->order;
		// Update region payment method.
		$order->paymentMethodId = $regionPaymentMethod->paymentMethodId;
		$order->paymentMethodInfo = $regionPaymentMethod->settingInfo;
		// Update billing address.
		$order->billFirstName = $billingAddress->firstName;
		$order->billLastName = $billingAddress->lastName;
		$order->billEmail = $billingAddress->email;
		$order->billPhone = $billingAddress->phone;
		$order->billAddress = $billingAddress->address;
		$order->billCity = $billingAddress->city;
		$order->billZipCode = $billingAddress->postalCode;
		$order->billStateCode = $billingAddress->state;
		$order->billCountry = $billingAddress->country;
		self::update ();
	}
	public static function getShoppingCart() {
		if (is_null ( SessionUtil::get ( Constants::SESSION_SHOPPING_CART ) )) {
			self::init ();
		}
		return SessionUtil::get ( Constants::SESSION_SHOPPING_CART );
	}
	public static function getShowShoppingCart() {
		if (is_null ( SessionUtil::get ( Constants::SESSION_SHOPPING_CART ) )) {
			self::init ();
		}
		$shoppingCartModel = SessionUtil::get ( Constants::SESSION_SHOPPING_CART );
		$result = array ();
		// Update name of all order product follow the language.
		$orderProducts = $shoppingCartModel->products->getArray ();
		$productHomeService = new ProductHomeService ();
		foreach ( $orderProducts as $orderProduct ) {
			$filter = new ProductHomeExtendVo ();
			$filter->id = $orderProduct->productId;
			$filter->languageCode = ControllerHelper::getLangCode ();
			$filter->currencyCode = ControllerHelper::getCurrencyCode ();
			$productHomeExtendVo = $productHomeService->getProductHomeById ( $filter );
			$orderProductExtendVo = new OrderProductExtendVo ();
			AppUtil::copyProperties ( $orderProduct, $orderProductExtendVo );
			AppUtil::copyProperties ( $productHomeExtendVo, $orderProductExtendVo );
			$orderProductExtendVo->productImage = $productHomeExtendVo->images;
			$result [] = $orderProductExtendVo;
		}
		return $result;
	}
	public static function changeLanguage() {
		$shoppingCartModel = self::getShoppingCart ();
		// Update name of all order product follow the language.
		$orderProducts = $shoppingCartModel->products->getArray ();
		$productHomeService = new ProductHomeService ();
		foreach ( $orderProducts as $orderProduct ) {
			$filter = new ProductHomeExtendVo ();
			$filter->id = $orderProduct->productId;
			$filter->languageCode = ControllerHelper::getLangCode ();
			$filter->currencyCode = ControllerHelper::getCurrencyCode ();
			$productHomeExtendVo = $productHomeService->getProductHomeById ( $filter );
			if (! is_null ( $productHomeExtendVo )) {
				$orderProduct->name = $productHomeExtendVo->name;
			}
		}
	}
	public static function updateCouponCode($couponCode) {
		$shoppingCartModel = self::getShoppingCart ();
		$shoppingCartModel->order->couponCode = $couponCode;
		self::update ();
	}
	public static function changeRegion() {
	}
	public static function checkout() {
		self::save ();
	}
	private static function init() {
		$shoppingCartModel = new ShoppingCartModel ();
		// Create new order.
		$order = new OrderVo ();
		$loginCustomer = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		$order->customerId = is_null ( $loginCustomer ) ? 0 : $loginCustomer->userId;
		$order->orderStatusId = is_null ( ApplicationConfig::get ( Constants::ORDER_STATUS_DEFAULT ) ) ? 0 : ApplicationConfig::get ( Constants::ORDER_STATUS_DEFAULT );
		$order->shippingStatusId = is_null ( ApplicationConfig::get ( Constants::SHIPPING_STATUS_DEFAULT ) ) ? 0 : ApplicationConfig::get ( Constants::SHIPPING_STATUS_DEFAULT );
		$order->currencyCode = ControllerHelper::getCurrencyCode ();
		$order->regionId = ControllerHelper::getRegionId ();
		$order->languageCode = ControllerHelper::getLangCode ();
		$shoppingCartModel->order = $order;
		// Create new order total.
		$orderTotals = new BaseArray ( OrderTotalVo::class );
		$shoppingCartModel->orderTotals = $orderTotals;
		// Init value for order total variables.
		$shoppingCartModel->subTotal = 0;
		$shoppingCartModel->discount = 0;
		$shoppingCartModel->taxTotal = 0;
		$shoppingCartModel->shipping = 0;
		$shoppingCartModel->coupon = 0;
		$shoppingCartModel->total = 0;
		// Create new product list.
		$products = new BaseArray ( OrderProductVo::class );
		$shoppingCartModel->products = $products;
		// Create new cart info.
		$cartInfo = new CartInfoVo ();
		$cartInfo->sessionId = SessionUtil::getId ();
		$shoppingCartModel->cart = $cartInfo;
		SessionUtil::set ( Constants::SESSION_SHOPPING_CART, $shoppingCartModel );
	}
	private static function update() {
		// Clone shopping cart.
		$shoppingCart = AppUtil::cloneObj ( self::getShoppingCart () );
		// Update shopping cart.
		$updateShoppingCart = CartHelper::updateShoppingCart ( $shoppingCart );
		// Set updated shopping cart to the session if successfully.
		SessionUtil::set ( Constants::SESSION_SHOPPING_CART, $updateShoppingCart );
	}
	private static function save() {
	}
}