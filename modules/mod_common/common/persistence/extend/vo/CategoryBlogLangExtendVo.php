<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\CategoryBlogLangVo;

class CategoryBlogLangExtendVo extends CategoryBlogLangVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["code"] = "code";
		$this->resultMap ["language_name"] = "languageName";
		$this->resultMap ["flag"] = "flag";
	}
	public $code;
	public $languageName;
	public $flag;
}






