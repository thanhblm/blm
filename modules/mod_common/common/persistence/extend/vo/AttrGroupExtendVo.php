<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\AttrGroupVo;
use common\persistence\base\vo\AttributeVo;
use core\BaseArray;

class AttrGroupExtendVo extends AttrGroupVo {
	public function __construct() {
		parent::__construct ();
		$this->listAttr = new BaseArray(AttributeVo::class);
		//$this->resultMap ["country_name"] = "countryName";
	}
	public $listAttr;
}