<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\WidgetContentLangVo;

class WidgetContentLangExtendVo extends WidgetContentLangVo {
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