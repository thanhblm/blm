<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\EmailTemplateLangVo;

class EmailTemplateLangExtendVo extends EmailTemplateLangVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["code"] = "code";
		$this->resultMap ["name"] = "name";
		$this->resultMap ["flag"] = "flag";
	}
	public $code;
	public $name;
	public $flag;
}