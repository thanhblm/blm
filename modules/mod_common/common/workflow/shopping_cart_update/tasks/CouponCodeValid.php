<?php

namespace common\workflow\shopping_cart_update\tasks;

use common\persistence\base\vo\DiscountCouponProductVo;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\base\vo\OrderSurchargeVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\DiscountCouponExtendVo;
use common\services\discount_coupon\DiscountCouponService;
use common\services\order\OrderService;
use common\services\order\OrderSurchargeService;
use common\services\product\ProductService;
use core\Lang;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use core\utils\AppUtil;
use frontend\common\Constants;
use common\persistence\extend\vo\OrderExtendVo;
use common\persistence\base\vo\CustomerVo;
use common\services\customer\CustomerService;
use frontend\controllers\ControllerHelper;

class CouponCodeValid implements Task{
	
	/**
	 * Task3 Valid Discount Coupon from Sessions orderSurcharge
	 * {@inheritDoc}
	 * @see \core\workflow\Task::execute()
	 * $context params : ProductHomeExtendVo product->id, quantity
	 * 		1. Sessions:  BaseArray(OrderSurchargeExtendVo::class)  orderSurcharge , 
	 * 		2. Sessions:  OrderChargeInfoVo orderChargeInfo , 
	 * 		3. Sessions:  BaseArray(OrderProductExtendVo::class) listOrderProduct,
	 * 		4. Sessions:  LoginUserInfoMo get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )
	 * Result if pass: $context->set("discount", $discountCoupon);
	 */
	public function execute(ContextBase &$context){
		$fieldErrors = array();
		$orderSurcharges = SessionUtil::get("orderSurcharge");
		$orderChargeInfo = SessionUtil::get("orderChargeInfo");
		$dicountCode = "";
// Get Discount Coupon From Session
		if(!is_null($orderSurcharges) && !empty($orderSurcharges->getArray())){
			foreach ($orderSurcharges->getArray() as $orderSurcharge){
				if("coupon" == $orderSurcharge->surchargeType){
					$dicountCode = $orderSurcharge->surchargeCode;
					$orderSurcharges->remove($orderSurcharge);
				}
			}
			$orderSurcharges = SessionUtil::set("orderSurcharge", $orderSurcharges);
		}
		
		if(!is_null($context->get("isValidDiscount"))){

			if(AppUtil::isEmptyString($context->get("discountCode"))){
				$fieldErrors["discountCode"][] = Lang::get("Discount code can't be empty");
				$context->set("fieldErrors", $fieldErrors);
				return  false;
			}else{
				if(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId != 0 && !is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
					$customerVo = new CustomerVo();
					$customerVo->id = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId;
					$customerSv= new CustomerService();
					$customerVo = $customerSv->selectByKey($customerVo);
					if("0" != $customerVo->priceLevelId ){
						$fieldErrors["discountCode"][] = Lang::getWithFormat("Sorry {0} can't use discount coupon", SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->firstName);
						$context->set("fieldErrors", $fieldErrors);
						return true;
					}
				}
				$dicountCode = $context->get("discountCode");
			}
			
		}
		$context->set("discountCode", $dicountCode);
		if(AppUtil::isEmptyString($dicountCode)){
			return true;
		}
		$discountCouponVo = new DiscountCouponExtendVo();
		$discountCouponVo->code = $context->get("discountCode");
		$discountCouponVo->status = 'active';
		$discountCouponSv = new DiscountCouponService();
// Check Code Existed DB
		if(0 == $discountCouponSv->countDiscountCouponByFilter($discountCouponVo)){
			$fieldErrors["discountCode"][] = Lang::getWithFormat("Sorry, we cannot find discount code {0}. Please try with another discount code",$context->get("discountCode"));
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		$discountCouponVo->validFromTo = date ( 'Y-m-d H:i:s' );
		$discountCouponVo->validToFrom = date ( 'Y-m-d H:i:s' );
		$discountCoupons = $discountCouponSv->getDiscountCouponByProduct($discountCouponVo);
		
// Check Code expired Valid From To
		if(count($discountCoupons)==0){
			$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} has expired ",$context->get("discountCode"));
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		
		if(count($discountCoupons) == 1){
			$discountCoupon = $discountCoupons[0];
		}else{
			// Error Exits >=2 discount code
			$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} has invalid in system ",$context->get("discountCode"));
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		
		if($discountCoupon->usePerCustomer > 0 && SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId == 0){
			$fieldErrors["discountCode"][] = Lang::get("This discount coupon can only be used by registered customer. Please login or register a new account");
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		
		$orderSurchargeVo = new OrderSurchargeVo();
		$orderSurchargeVo->surchargeId = $discountCoupon->id;
		$orderSurchargeVo->surchargeType = "coupon";
		$orderSurchargeSv = new OrderSurchargeService();
		$orderSurchargeNewVos = $orderSurchargeSv->selectByFilter($orderSurchargeVo);
// Check Code Limit From Order Surcharge
		if($orderSurchargeSv->countByFilter($orderSurchargeVo) >= $discountCoupon->maxUse && $discountCoupon->maxUse > 0){
			$orderVo = new OrderExtendVo();
			$orderVo->id = $orderSurchargeNewVos[0]->orderId;
			$orderSv = new OrderService();
			$orderExtendVo = $orderSv->getOrderVoByKey($orderVo);
			if($orderExtendVo->orderStatusId == 1 || $orderExtendVo->orderStatusId == 2){
				$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} has limited ",$context->get("discountCode"));
				$context->set("fieldErrors", $fieldErrors);
				return  false;
			}
		}
		$orderSurcharges = $orderSurchargeSv->selectByFilter($orderSurchargeVo);
		$usePerCustomer = 0;
		$customer = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
		$userId = 0;
		if(!is_null($customer)){
			$userId = AppUtil::defaultIfEmpty($customer->userId,0);
		}
		 
		$orderSv = new OrderService();
		$orderVoForCheckCustomer = new OrderVo();

		$orderVoForCheckCustomer->customerId = $userId;
		
		$orderVoForCheckCustomer->couponCode = $dicountCode;
		$usePerCustomer = $orderSv->getCountOrdersByCustomerAndCouponCode($orderVoForCheckCustomer);
		
		/* foreach ($orderSurcharges as $orderSurcharge){
			$orderVo = new OrderExtendVo();
			$orderVo->id = $orderSurcharge->orderId;
			$orderSv = new OrderService();
			$orderExtendVo = $orderSv->getOrderVoByKey($orderVo);
			if(isset($orderExtendVo)){
				if($userId == $orderExtendVo->customerId && ($orderExtendVo->orderStatusId == 1 || $orderExtendVo->orderStatusId == 2)){
					$usePerCustomer = $usePerCustomer + 1;
				}
			}
			
		} */
		
// Check min Grand total
		if($orderChargeInfo->grandTotalAmount < $discountCoupon->minOrderTotal && $discountCoupon->minOrderTotal > 0){
			$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} required grand total > {1}",$context->get("discountCode"), ControllerHelper::showProductPrice($discountCoupon->minOrderTotal));
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		
		$userPerProduct = $discountCoupon->userPerProduct;
		$discountCouponProductVo = new DiscountCouponProductVo();
		$discountCouponProductVo->discountCouponId = $discountCoupon->id;
		$discountCouponProductSv = new DiscountCouponService();
		$discountCouponProductVos = $discountCouponProductSv->getAllDiscountCouponProduct($discountCouponProductVo);
		$products = SessionUtil::get("listOrderProduct")->getArray();

// Check Code Limit From Order Surcharge
		if($usePerCustomer >= $discountCoupon->usePerCustomer && $discountCoupon->usePerCustomer > 0){
			$fieldErrors["discountCode"][] = Lang::get("Sorry, you can no longer use this discount coupon as you have reached the usage limit of it");
			$context->set("fieldErrors", $fieldErrors);
			return  false;
		}
		
		$userPerProduct = $discountCoupon->userPerProduct;
		$discountCouponProductVo = new DiscountCouponProductVo();
		$discountCouponProductVo->discountCouponId = $discountCoupon->id;
		
		$discountCouponProductSv = new DiscountCouponService();
		$discountCouponProductVos = $discountCouponProductSv->getAllDiscountCouponProduct($discountCouponProductVo);
		
		$products = SessionUtil::get("listOrderProduct")->getArray();
// Check userPerProduct with type only_for_following
		if("only_for_following" == $userPerProduct){
			$listProductId = array();
			$totalOrderProduct = count($products);
			$totalDiscountProduct = 0;
			foreach ($discountCouponProductVos as $discountCouponProduct){
				$totalDiscountProduct = $totalDiscountProduct + 1;
				foreach ($products as $product){
					if("product" == $discountCouponProduct->itemType && $discountCouponProduct->itemId == $product->productId){
						$totalOrderProduct = $totalOrderProduct - 1;
						array_push($listProductId, $product->productId);
					} elseif("category" == $discountCouponProduct->itemType){
						$productVo = new ProductVo();
						$productVo->id = $product->productId;
						$productSv = new ProductService();
						$productVo = $productSv->getProductByKey($productVo);
						if($productVo->categoryId == $discountCouponProduct->itemId){
							$totalOrderProduct = $totalOrderProduct - 1;
							array_push($listProductId, $product->productId);
						}
					}
				}
			}
			
			//if(count($products) != $totalDiscountProduct || $totalOrderProduct > 0 ){
			if($totalOrderProduct == count($products)){
				$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} requied list product map list couponproduct",$context->get("discountCode"));
				$context->set("fieldErrors", $fieldErrors);
				return  false;
			}else {
				$context->set("onlyForProduct", $listProductId);
			}
		}elseif("any_following" == $userPerProduct){
			$totalOrderProduct = count($products);
			$totalDiscountProduct = 0;
			foreach ($discountCouponProductVos as $discountCouponProduct){
				$totalDiscountProduct = $totalDiscountProduct + 1;
				foreach ($products as $product){
					if(("product" == $discountCouponProduct->itemType) && ($discountCouponProduct->itemId == $product->productId)){
						$totalOrderProduct = $totalOrderProduct - 1;
					}elseif("category" == $discountCouponProduct->itemType){
						$productVo = new ProductVo();
						$productVo->id = $product->productId;
						$productSv = new ProductService();
						$productVo = $productSv->getProductByKey($productVo);
						if($productVo->categoryId == $discountCouponProduct->itemId){
							$totalOrderProduct = $totalOrderProduct - 1;
						}
					}
				}
			}
			if($totalOrderProduct == count($products)){
				$fieldErrors["discountCode"][] = Lang::getWithFormat("{0} can only be applied to a certain product",$context->get("discountCode"));
				$context->set("fieldErrors", $fieldErrors);
				return  false;
			}
		}
		
		$context->set("discount", $discountCoupon);
	}
	
}