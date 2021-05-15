<?php

namespace common\vo\region\shipping_method\flat_rate;

use core\BaseArray;

class FlatRateSettingVo {
	public $status;
	public $currency;
	public $shippingMethods;
	public $handlingFee;
	public $taxClass;
	public $shippingZone;
	public function __construct() {
		$this->shippingMethods = new BaseArray ( FlatRateShippingMethodVo::class );
	}
}