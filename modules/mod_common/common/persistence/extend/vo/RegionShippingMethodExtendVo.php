<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\RegionShippingMethodVo;

class RegionShippingMethodExtendVo extends RegionShippingMethodVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["shipping_method_name"] = "shippingMethodName";
	}
	public $shippingMethodName;
}