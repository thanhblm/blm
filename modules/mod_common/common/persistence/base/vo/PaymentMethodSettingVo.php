<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PaymentMethodSettingVo extends BaseVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'setting_info' => 'settingInfo',
			'payment_method_id' => 'paymentMethodId'
		);
	}
	public $settingInfo;
	public $paymentMethodId;
}