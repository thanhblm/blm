<?php

namespace common\vo\region\shipping_method\zone_table;

use core\BaseArray;

class ZoneTableSettingVo {
	public $status;
	public $currency;
	public $shippingCosts;
	public $handlingFee;
	public $taxClass;
	public function __construct() {
		$this->shippingCosts = new BaseArray ( ZoneTableShippingCostVo::class );
	}
}