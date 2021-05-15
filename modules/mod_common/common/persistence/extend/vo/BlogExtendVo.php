<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\BlogVo;

class BlogExtendVo extends BlogVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["cr_by_name"] = "crByName";
		$this->resultMap ["md_by_name"] = "mdByName";
		$this->resultMap ["url"] = "url";
		$this->resultMap ["language_code"] = "languageCode";
        $this->resultMap ["category_name"] = "categoryName";
	}
	public $crByName;
	public $url;
	public $languageCode;
	public $mdByName;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $categoryName;
}






