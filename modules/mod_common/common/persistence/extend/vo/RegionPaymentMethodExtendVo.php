<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\RegionPaymentMethodVo;

class RegionPaymentMethodExtendVo extends RegionPaymentMethodVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["payment_method_name"] = "paymentMethodName";
	}
	public $paymentMethodName;
}