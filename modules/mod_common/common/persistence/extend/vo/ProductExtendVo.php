<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\ProductVo;

class ProductExtendVo extends ProductVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["prices"] = "prices";
	}
	public $prices;
}






