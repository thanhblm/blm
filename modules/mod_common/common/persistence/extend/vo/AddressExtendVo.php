<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\AddressVo;

class AddressExtendVo extends AddressVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["country_name"] = "countryName";
		$this->resultMap ["state_name"] = "stateName";
	}
	public $countryName;
	public $stateName;
}