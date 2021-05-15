<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\BulkDiscountProductVo;

class BulkDiscountProductExtendVo extends BulkDiscountProductVo {
	public $productName;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["product_name"] = "productName";
	}
}