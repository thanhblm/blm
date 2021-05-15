<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\TaxRateInfoVo;

class ShippingZoneTaxInfoVo extends TaxRateInfoVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["tax_shipping_zone_name"] = "taxShippingZoneName";
		$this->resultMap ["exclusive"] = "exclusive";
		$this->resultMap ["country_id"] = "countryId";
		$this->resultMap ["state_id"] = "stateId";
	}
	public $taxShippingZoneName;
	public $exclusive;
	public $countryId;
	public $stateId;
}