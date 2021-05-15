<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\ContactVo;

class ContactExtendVo extends ContactVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["country_name"] = "countryName";
	}
	public $countryName;
	public $crDateFrom;
	public $crDateTo;
}