<?php

namespace common\persistence\extend\vo;



use common\persistence\base\vo\OrderSurchargeVo;

class OrderSurchargeExtendVo extends OrderSurchargeVo{
	public function __construct() {
		parent::__construct ();
	}
	public $surchargeCode;
}