<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\BulkDiscountVo;

class BulkDiscountExtendVo extends BulkDiscountVo{
	
	public function __construct() {
		parent::__construct ();
	}
	public $productId;
	public $dateNow;
	public $productQuantity;
}