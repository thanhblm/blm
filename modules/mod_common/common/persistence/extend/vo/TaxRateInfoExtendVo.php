<?php

namespace common\persistence\extend\vo;


use common\persistence\base\vo\TaxRateInfoVo;

class TaxRateInfoExtendVo extends TaxRateInfoVo{
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["shipping_zone_name"] = "shippingZoneName";
	}
	public $shippingZoneName;
}






