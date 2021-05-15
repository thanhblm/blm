<?php

namespace common\workflow\shopping_cart_update\tasks;

use common\helper\AddressHelper;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\base\vo\TaxShippingZoneVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\persistence\extend\vo\TaxRateInfoExtendVo;
use common\persistence\extend\vo\TaxShippingZoneInfoExtendVo;
use common\services\address\AddressService;
use common\services\customer\CustomerService;
use common\services\product\ProductService;
use common\services\tax\TaxRateInfoService;
use common\services\tax_shipping_zone\TaxShippingZoneService;
use common\utils\StringUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\common\Constants;
use core\utils\AppUtil;
use core\config\ApplicationConfig;
use frontend\controllers\ControllerHelper;
use common\config\RegionEnum;
use common\services\address\StateService;
use common\persistence\base\vo\StateVo;
use common\services\country\CountryService;
use common\persistence\base\vo\CountryVo;
use frontend\service\OrderHelper;

class TaxRateValid implements Task {
	
	/**
	 * Task3 Valid Discount Coupon from Sessions orderSurcharge
	 *
	 * {@inheritDoc}
	 *
	 * @see \core\workflow\Task::execute() $context params : ProductHomeExtendVo product->id, quantity
	 *      1. Sessions: BaseArray(OrderSurchargeExtendVo::class) orderSurcharge ,
	 *      2. Sessions: OrderChargeInfoVo orderChargeInfo ,
	 *      3. Sessions: BaseArray(OrderProductExtendVo::class) listOrderProduct,
	 *      4. Sessions: LoginUserInfoMo get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )
	 *      Result if pass: $context->set("discount", $discountCoupon);
	 */
	public function execute(ContextBase &$context) {
		$quantity = $context->get ( "quantity" );
		$products = SessionUtil::get ( "listOrderProduct" );
		$orderChargeInfo = SessionUtil::get ( "orderChargeInfo" );
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$order = SessionUtil::get ( "order" );
		if(!is_null($order) && !is_null($order->shippingMethodItem)){
			if(!is_null(JsonUtil::base64Decode($order->shippingMethodItem))){
				$shippingInfo = JsonUtil::base64Decode($order->shippingMethodItem);
				$context->set("shippingCost", $shippingInfo->cost);
			}
			
		}
		$taxRateOld = 0;
		$orderPriceSubTotal = 0;
		if(!is_null($orderSurcharges) && !empty($orderSurcharges->getArray())){
			foreach ( $orderSurcharges->getArray () as $orderSurcharge ) {
				if ("tax_rate" == $orderSurcharge->surchargeType) {
					$taxRateOld += $orderSurcharge->amount;
				}
				if ("shipping" == $orderSurcharge->surchargeType) {
					$taxRateOld += $orderSurcharge->amount;
				}
			}
		}
		
		$context->set("taxAmountOld", $taxRateOld);
		if (is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			return true;
		} else {
			$customerVo = new CustomerVo ();
			$customerSv = new CustomerService ();
			$productVo = new ProductVo ();
			$productSv = new ProductService ();
			$addressShippingVo = new AddressVo ();
			$addressBillingVo = new AddressVo ();
			$addressSv = new AddressService ();
			$taxShippingZoneSv = new TaxShippingZoneService ();
			
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerVo = $customerSv->selectByKey ( $customerVo );
			
			$hasProductTax = true;
			$regionId = ControllerHelper::getRegionId();
			
			if ($regionId == RegionEnum::USA && !AppUtil::isEmptyString($customerVo->resellerCertNo)){
				$hasProductTax = false;
			}else if ($regionId == RegionEnum::OUTSIDE_USA && !AppUtil::isEmptyString($customerVo->vatNo)){
				$hasProductTax = false;
			}
			\DatoLogUtil::devInfo($regionId. "  vs  ". $customerVo->vatNo . " vs " . RegionEnum::OUTSIDE_USA);
			$addressShippingVo->id = $customerVo->defaultShippingAddressId;
			$addressShippingVo = $addressSv->selectByKey ( $addressShippingVo );
			
			if (is_null ( $addressShippingVo )) {
				// Is Guest Checkout
				$addressShippingVo = OrderHelper::buildShippingAddressFromOrder();
				if (is_null ( $addressShippingVo )) {
					return true;
				}
			}
			
			$addressBillingVo->id = $customerVo->defaultBillingAddressId;
			$addressBillingVo = $addressSv->selectByKey ( $addressBillingVo );
			
			if(is_null ( $addressBillingVo)){
				$addressBillingVo = OrderHelper::buildBillingAddressFromOrder();
			}
			
			foreach ( $products->getArray () as $product ) {
				$orderPriceSubTotal = $orderPriceSubTotal + $product->price;
			}
			
			$taxRateShipping = 0;
			$taxRateBilling = 0;
			// Prepare taxable goods
			$productTaxRate = ApplicationConfig::get("tax.rate.taxable.goods"); // Tax goood
			$taxRateInfoVo = new TaxRateInfoExtendVo ();
			$taxRateInfoVo->taxRateId = $productTaxRate;
			$taxRateInfoSv = new TaxRateInfoService ();
			$listTaxRateInfo = $taxRateInfoSv->selectByFilterWithPriority ( $taxRateInfoVo );
			$taxRatePer = 0;
			
			
			
			foreach ( $listTaxRateInfo as $taxRateInfo ) {
				$taxShippingZoneId = $taxRateInfo->taxShippingZoneId;
				$zoneMatch = $taxRateInfo->zoneMatch;
				$rate = 0;
				if ("dynamic" === $taxRateInfo->type) {
					if ("us-wa"===$taxRateInfo->dynamicRate){
						$addressVo = new AddressVo();
						if ("shipping" === $zoneMatch){
							$addressVo = $addressShippingVo;
						}
						if("billing" === $zoneMatch){
							$addressVo = $addressBillingVo;
						}
						if($addressVo->country == "411" && $addressVo->state == "4006"){
							$result = AddressHelper::getWashingtonTax($addressVo->address, $addressVo->city, $addressVo->postalCode);
							if ($result["status"]){
								$rate = $result["rate"] * 100;
								$taxRateBilling = StringUtil::calculatePerPrice ( $rate, $orderPriceSubTotal);
								$orderSurchargeExtendVo= new OrderSurchargeExtendVo ();
								if ($hasProductTax){
									$taxRatePer = $taxRatePer + $rate;
									$orderSurchargeExtendVo->amount = $taxRateBilling;
								}else{
									$orderSurchargeExtendVo->amount = 0;
								}
								$orderSurchargeExtendVo->surchargeType = "tax_rate";
								$orderSurchargeExtendVo->data = JsonUtil::encode( $taxRateInfo );
								$orderSurchargeExtendVo->surchargeId = $taxRateInfo->id;
								$orderSurchargeExtendVo->surchargeCode = $taxRateInfo->name;
								if($rate > 0){
									$orderSurcharges->add ( $orderSurchargeExtendVo);
								}
							}
						}
					}
				}else{
					$priority = $taxRateInfo->priority;
					$taxShippingZoneVo = new TaxShippingZoneVo ();
					$taxShippingZoneVo->id = $taxShippingZoneId;
					$taxShippingZoneVo = $taxShippingZoneSv->getTaxShippingZoneByKey ( $taxShippingZoneVo );
					$exclusive = $taxShippingZoneVo->exclusive;
					$taxShippingZoneInfoExtendVo = new TaxShippingZoneInfoExtendVo ();
					$taxShippingZoneInfoExtendVo->taxShippingZoneId = $taxShippingZoneVo->id;
					$listTaxShippingZoneInfo = $taxShippingZoneSv->getTaxShippingZoneInfoById ( $taxShippingZoneInfoExtendVo );
					
					
					$hasMatch = false;
					foreach ( $listTaxShippingZoneInfo as $taxShippingZoneInfo ) {
						// Khop Shipping Address.
						$match = false;
						if ("shipping" === $zoneMatch){
							$match = $taxShippingZoneInfo->countryId === $addressShippingVo->country;
							$match = empty ( $taxShippingZoneInfo->stateId ) ? $match : $match && $taxShippingZoneInfo->stateId === $addressShippingVo->state;
						}else if ("billing" === $zoneMatch){
							$match = $taxShippingZoneInfo->countryId === $addressBillingVo->country;
							$match = empty ( $taxShippingZoneInfo->stateId ) ? $match : $match && $taxShippingZoneInfo->stateId === $addressBillingVo->state;
						} else {
							continue;
						}
						if ($match) {
							$hasMatch = true;
							break;
						}
					}
					if ($hasMatch && "no" === $exclusive){
						$rate = AppUtil::defaultIfEmpty($taxRateInfo->rate,0);
					}
					if (!$hasMatch && "yes" === $exclusive){
						$rate = AppUtil::defaultIfEmpty($taxRateInfo->rate,0);
					}
					
					$taxRateBilling = StringUtil::calculatePerPrice ( $rate, $orderPriceSubTotal);
					$orderSurchargeExtendVo= new OrderSurchargeExtendVo ();
					if ($hasProductTax){
						$taxRatePer = $taxRatePer + $rate;
						$orderSurchargeExtendVo->amount = $taxRateBilling;
					}else{
						$orderSurchargeExtendVo->amount = 0;
					}
					$orderSurchargeExtendVo->surchargeType = "tax_rate";
					$orderSurchargeExtendVo->data = JsonUtil::encode( $taxRateInfo );
					$orderSurchargeExtendVo->surchargeId = $taxRateInfo->id;
					$orderSurchargeExtendVo->surchargeCode = $taxRateInfo->name;
					
					if($rate <= 0){
						$orderSurchargeExtendVo = null;
					}
					if ($hasMatch && "no" === $exclusive && !is_null($orderSurchargeExtendVo)){
						$orderSurcharges->add ( $orderSurchargeExtendVo);
					}
					if (!$hasMatch && "yes" === $exclusive && !is_null($orderSurchargeExtendVo)){
						$orderSurcharges->add ( $orderSurchargeExtendVo);
					}
				
				}
				\DatoLogUtil::devInfo("  taxname: ". $taxRateInfo->name. " rate: ". $rate . " hasProductTax:". $hasProductTax);
			}
			//toantq : only correct if product have set taxable goods, need to correct it late
			foreach ( $products->getArray () as $product ) {
				$product->tax = $taxRatePer;
			}
			
			SessionUtil::set("listOrderProduct", $products);
			// Shipping tax
			if(!is_null($context->get("shippingCost"))){
				$productTaxRate = 1; //TaxShipping
				$taxRateInfoVo = new TaxRateInfoExtendVo ();
				$taxRateInfoVo->taxRateId = $productTaxRate;
				$taxRateInfoSv = new TaxRateInfoService ();
				$listTaxRateInfo = $taxRateInfoSv->selectByFilterWithPriority ( $taxRateInfoVo );
				foreach ( $listTaxRateInfo as $taxRateInfo ) {
					$taxShippingZoneId = $taxRateInfo->taxShippingZoneId;
					$zoneMatch = $taxRateInfo->zoneMatch;
					$rate = 0;
					if ("dynamic" === $taxRateInfo->type) {
						if ("us-wa"===$taxRateInfo->dynamicRate){
							$addressVo = new AddressVo();
							if ("shipping" === $zoneMatch){
								$addressVo = $addressShippingVo;
							}
							if("billing" === $zoneMatch){
								$addressVo = $addressBillingVo;
							}
							if($addressVo->country == "411" && $addressVo->state == "4006"){
								$result = AddressHelper::getWashingtonTax($addressVo->address, $addressVo->city, $addressVo->postalCode);
								if ($result["status"]){
									$rate = $result["rate"];
									$taxRateBilling = StringUtil::calculatePerPrice ( $rate, $context->get("shippingCost"));
									$orderSurchargeExtendVo= new OrderSurchargeExtendVo ();
									$orderSurchargeExtendVo->amount = $taxRateBilling;
									$orderSurchargeExtendVo->surchargeType = "shipping";
									$orderSurchargeExtendVo->data = JsonUtil::encode( $taxRateInfo );
									$orderSurchargeExtendVo->surchargeId = $taxRateInfo->id;
									$orderSurchargeExtendVo->surchargeCode = $taxRateInfo->name;
									if($rate > 0){
										$orderSurcharges->add ( $orderSurchargeExtendVo);
									}
								}
							}
						}
					}else{
						$priority = $taxRateInfo->priority;
						$taxShippingZoneVo = new TaxShippingZoneVo ();
						$taxShippingZoneVo->id = $taxShippingZoneId;
						$taxShippingZoneVo = $taxShippingZoneSv->getTaxShippingZoneByKey ( $taxShippingZoneVo );
						
						$exclusive = $taxShippingZoneVo->exclusive;
						
						$taxShippingZoneInfoExtendVo = new TaxShippingZoneInfoExtendVo ();
						$taxShippingZoneInfoExtendVo->taxShippingZoneId = $taxShippingZoneVo->id;
						$listTaxShippingZoneInfo = $taxShippingZoneSv->getTaxShippingZoneInfoById ( $taxShippingZoneInfoExtendVo );
						
						
						$hasMatch = false;
						foreach ( $listTaxShippingZoneInfo as $taxShippingZoneInfo ) {
							// Khop Shipping Address.
							$match = false;
							if ("shipping" === $zoneMatch){
								$match = $taxShippingZoneInfo->countryId === $addressShippingVo->country;
								$match = empty ( $taxShippingZoneInfo->stateId ) ? $match : $match && $taxShippingZoneInfo->stateId === $addressShippingVo->state;
							}else if ("billing" === $zoneMatch){
								$match = $taxShippingZoneInfo->countryId === $addressBillingVo->country;
								$match = empty ( $taxShippingZoneInfo->stateId ) ? $match : $match && $taxShippingZoneInfo->stateId === $addressBillingVo->state;
							} else {
								continue;
							}
							if ($match) {
								$hasMatch = true;
								break;
							}
						}
						
						if ($hasMatch && "no" === $exclusive ){
							$rate = AppUtil::defaultIfEmpty($taxRateInfo->rate,0);
						}
						if (!$hasMatch && "yes" === $exclusive){
							$rate = AppUtil::defaultIfEmpty($taxRateInfo->rate,0);
						}
						
						$taxRateBilling = StringUtil::calculatePerPrice ( $rate, $context->get("shippingCost"));
						$orderSurchargeExtendVo= new OrderSurchargeExtendVo ();
						$orderSurchargeExtendVo->amount = $taxRateBilling;
						$orderSurchargeExtendVo->surchargeType = "shipping";
						$orderSurchargeExtendVo->data = JsonUtil::encode( $taxRateInfo );
						$orderSurchargeExtendVo->surchargeId = $taxRateInfo->id;
						$orderSurchargeExtendVo->surchargeCode = $taxRateInfo->name;
						if($rate <= 0){
							$orderSurchargeExtendVo = null;
						}
						
						if ($hasMatch && "no" === $exclusive && !is_null($orderSurchargeExtendVo)){
							$orderSurcharges->add ( $orderSurchargeExtendVo);
						}
						if (!$hasMatch && "yes" === $exclusive && !is_null($orderSurchargeExtendVo)){
							$orderSurcharges->add ( $orderSurchargeExtendVo);
						}
					}
					\DatoLogUtil::devInfo("  taxname: ". $taxRateInfo->name. " rate: ". $rate);
				}
			}
			SessionUtil::set ( "orderSurcharge", $orderSurcharges );
		}
	}
}