<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\SeoInfoLangVo;

class BlogSeoExtendVo extends SeoInfoLangVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap["flag"] = "flag";
		$this->resultMap ["language_name"] = "languageName";
	}
	public $flag;
	public $languageName;
}