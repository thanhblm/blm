<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\AttributeVo;

class AttributeExtendVo extends AttributeVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["attr_group_name"] = "attrGroupName";
		$this->resultMap ["category_name"] = "categoryName";
	}
	public $attrGroupName;
	public $categoryName;
}