<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\DiscountCouponProductVo;

class DiscountCouponProductExtendVo extends DiscountCouponProductVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap['name']='name';
	}
	public $name;
	
}








