<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\DiscountCouponVo;

class DiscountCouponExtendVo extends DiscountCouponVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["cr_by_name"] = "crByName";
		$this->resultMap ["md_by_name"] = "mdByName";
	}
	public $discountFrom;
	public $discountTo;
	public $minOrderTotalFrom;
	public $minOrderTotalTo;
	public $maxUseFrom;
	public $maxUseTo;
	public $usePerCustomerFrom;
	public $usePerCustomerTo;
	public $validFromFrom;
	public $validFromTo;
	public $validToFrom;
	public $validToTo;
	public $crByName;
	public $mdByName;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $applicableProducts;
}






