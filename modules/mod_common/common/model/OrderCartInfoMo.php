<?php

namespace common\model;

use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use core\BaseArray;

class OrderCartInfoMo extends CartInfoVo {
	public function __construct() {
		parent::__construct ();
		$this->orderVo = new OrderVo();
		$this->orderTotalVos = new BaseArray(OrderTotalVo::class);
		$this->orderProductExtendVos = new BaseArray(OrderProductExtendVo::class);
	}
	public $orderVo; // OrderVo()
	public $orderTotalVos; // BaseArray(OrderTotalVo::class)
	public $orderProductExtendVos; // BaseArray(OrderProductExtendVo::class)
}