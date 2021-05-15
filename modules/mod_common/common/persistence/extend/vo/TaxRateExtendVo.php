<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\TaxRateVo;

class TaxRateExtendVo extends TaxRateVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["count_tax_info"] = "countTaxInfo";
	}
	public $countTaxInfo;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
}