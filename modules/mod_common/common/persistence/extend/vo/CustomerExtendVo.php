<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\CustomerVo;

class CustomerExtendVo extends CustomerVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["account_type_name"] = "accountTypeName";
		$this->resultMap ["price_level_name"] = "priceLevelName";
		$this->resultMap ["customer_type_name"] = "customerTypeName";
	}
	public $priceLevelName;
	public $accountTypeName;
	public $customerTypeName;
}