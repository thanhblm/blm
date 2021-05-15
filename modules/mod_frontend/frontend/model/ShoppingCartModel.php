<?php

namespace frontend\model;

use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use core\BaseArray;

class ShoppingCartModel {
	public $order;
	public $products;
	public $cart;
	public $histories;
	public $orderTotals;
	public $shippingMethodId;
	public $shippingMethodInfo;
	// Order total variables.
	public $subTotal;
	public $discount;
	public $taxTotal;
	public $shipping;
	public $coupon;
	public $total;
	public function __construct() {
		$this->order = new OrderVo ();
		$this->products = new BaseArray ( OrderProductVo::class );
		$this->cart = new CartInfoVo ();
		$this->histories = new BaseArray ( OrderHistoryVo::class );
		$this->orderTotals = new BaseArray ( OrderTotalVo::class );
	}
}