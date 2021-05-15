<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\WidgetVo;

class WidgetExtendVo extends WidgetVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["widget_cat_name"] = "widgetCatName";
		$this->resultMap ["widget_cat_description"] = "widgetCatDescription";
	}
	public $widgetCatName;
	public $widgetCatDescription;
}