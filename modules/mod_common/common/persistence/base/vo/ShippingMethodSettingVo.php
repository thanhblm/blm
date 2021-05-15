<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ShippingMethodSettingVo extends BaseVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'setting_info' => 'settingInfo',
			'shipping_method_id' => 'shippingMethodId'
		);
	}
	public $settingInfo;
	public $shippingMethodId;
}