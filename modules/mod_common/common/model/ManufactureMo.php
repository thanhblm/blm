<?php

namespace common\model;

use common\persistence\base\vo\ManufactureVo;

class ManufactureMo extends ManufactureVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["cr_name"] = "crName";
		$this->resultMap ["md_name"] = "mdName";
	}
	public $crName;
	public $mdName;
}