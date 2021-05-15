<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\TaxShippingZoneInfoVo;

class TaxShippingZoneInfoExtendVo extends TaxShippingZoneInfoVo {
	public function __construct() {
		parent::__construct ();
		$this->tableMap ["state_name"] = "stateName";
		$this->tableMap ["country_name"] = "countryName";
	}
	public $stateName;
	public $countryName;
	public $stateList;
}






