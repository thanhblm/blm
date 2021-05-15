<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\CategoryVo;

class CategoryExtendVo extends CategoryVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["cr_by_name"] = "crByName";
		$this->resultMap ["md_by_name"] = "mdByName";
	}
	public $crByName;
	public $mdByName;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
}






