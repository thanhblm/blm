<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;
use common\persistence\base\vo\AddressVo;

class PrepareShippingAndBillingAddress implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		// Prepare shipping address.
		$shippingAddress = new AddressVo();
		$shippingAddress->firstName = $shoppingCart->order->shipFirstName;
		$shippingAddress->lastName = $shoppingCart->order->shipLastName;
		$shippingAddress->email = $shoppingCart->order->shipEmail;
		$shippingAddress->phone = $shoppingCart->order->shipPhone;
		$shippingAddress->address = $shoppingCart->order->shipAddress;
		$shippingAddress->city = $shoppingCart->order->shipCity;
		$shippingAddress->postalCode = $shoppingCart->order->shipZipcode;
		$shippingAddress->state = $shoppingCart->order->shipStateCode;
		$shippingAddress->country = $shoppingCart->order->shipCountryCode;
		$context->set ( Attributes::SHIPPING_ADDRESS, $shippingAddress );
		// Prepare billing address.
		$billingAddress = new AddressVo ();
		$billingAddress->firstName = $shoppingCart->order->billFirstName;
		$billingAddress->lastName = $shoppingCart->order->billLastName;
		$billingAddress->email = $shoppingCart->order->billEmail;
		$billingAddress->phone = $shoppingCart->order->billPhone;
		$billingAddress->address = $shoppingCart->order->billAddress;
		$billingAddress->city = $shoppingCart->order->billCity;
		$billingAddress->postalCode = $shoppingCart->order->billZipcode;
		$billingAddress->state = $shoppingCart->order->billStateCode;
		$billingAddress->country = $shoppingCart->order->billCountryCode;
		$context->set ( Attributes::BILLING_ADDRESS, $billingAddress );
	}
}