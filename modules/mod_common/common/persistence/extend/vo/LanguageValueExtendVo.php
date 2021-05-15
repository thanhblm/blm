<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\LanguageValueVo;

class LanguageValueExtendVo extends LanguageValueVo {
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
	public $newLanguageCode;
}