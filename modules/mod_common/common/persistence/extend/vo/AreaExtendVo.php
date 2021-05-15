<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\AreaCategoryVo;

class AreaExtendVo extends AreaCategoryVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["name"] = "name";
		$this->resultMap ["area_description"] = "areaDescription";
	}
	public $name;
	public $areaDescription;
}






