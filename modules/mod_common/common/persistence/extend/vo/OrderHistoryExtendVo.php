<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\OrderHistoryVo;

class OrderHistoryExtendVo extends OrderHistoryVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["order_status_name"] = "orderStatusName";
	}
	public $orderStatusName;
	
}