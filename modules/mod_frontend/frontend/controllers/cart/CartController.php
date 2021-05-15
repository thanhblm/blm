<?php

namespace frontend\controllers\cart;

use common\config\CookieEnum;
use common\helper\CookieHelper;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\extend\vo\OrderSurchargeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\attribute\ProductAttributeService;
use common\services\home\CartService;
use common\services\product\ProductHomeService;
use core\BaseArray;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\controllers\FrontendController;

class CartController extends FrontendController{
	public $productQuantity;
	public $product;
	public $orderProduct;
	public $productSv;
	public $cartSv;
	public $orderChargeInfo;
	public $orderSurcharge;
	public $discountCode;
	public $productAttribute;

	function __construct(){
		parent::__construct();
		$this->productSv = new ProductHomeService ();
		$this->product = new ProductHomeExtendVo ();
		$this->productAttribute = new ProductAttributeVo();
		$this->orderProduct = new OrderProductExtendVo ();
		$this->orderChargeInfo = new OrderChargeInfoVo ();
		$this->cartSv = new CartService ();
	}

	public function updateLanguage(){
		return null;
	}

	public function checkoutView(){
		$this->discountCode = "";
		$orderSurcharges = SessionUtil::get("orderSurcharge");
		if (!is_null($orderSurcharges)) {
			foreach ($orderSurcharges->getArray() as $orderSurcharge) {
				if ("coupon" == $orderSurcharge->surchargeType) {
					$this->discountCode = $orderSurcharge->surchargeCode;
				}
			}
		}

		$context = new ContextBase ();

		//Affiliate cookie set
		$cookieDiscountCode = CookieHelper::getCookie(CookieEnum::DISCOUNT_CODE);
		if (AppUtil::isEmptyString($this->discount) && !AppUtil::isEmptyString($cookieDiscountCode)) {
			$this->discountCode = $cookieDiscountCode;
			$context->set("isValidDiscount", true);
		} elseif (!AppUtil::isEmptyString($this->discount)) {
			$this->discountCode = $this->discount;
			$context->set("isValidDiscount", true);
		}

		$context->set("discountCode", $this->discountCode);
		WorkflowManager::Instance()->execute("shopping_cart_update", $context);
		$actionErrors = $context->get("actionErrors");
		$fieldErrors = $context->get("fieldErrors");
		foreach ($actionErrors as $actionError) {
			$this->addActionError($actionError);
		}
		foreach ($fieldErrors as $field => $errorMessage) {
			$this->addFieldError($field, $errorMessage [0]);
		}
		return "success";
	}

	public function updateShoppingCart(){
		$productAttributeSv = new ProductAttributeService();
		$productAttributeVo = $productAttributeSv->selectByKey($this->productAttribute);
		$context = new ContextBase ();
		$context->set("quantity", $this->productQuantity);
		$context->set("product", $this->product);
		$context->set("productAttribute", $productAttributeVo);
		WorkflowManager::Instance()->execute("shopping_cart_update", $context);

		$actionErrors = $context->get("actionErrors");
		$fieldErrors = $context->get("fieldErrors");
		foreach ($actionErrors as $actionError) {
			$this->addActionError($actionError);
		}
		foreach ($fieldErrors as $field => $errorMessage) {
			$this->addFieldError($field, $errorMessage [0]);
		}
		return "success";
	}

	public function reload(){
		return "success";
	}
}