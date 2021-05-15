<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\WidgetContentVo;

class WidgetContentExtendVo extends WidgetContentVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["widget_name"] = "widgetName";
		$this->resultMap ["widget_description"] = "widgetDescription";
		$this->resultMap ["widget_controller"] = "widgetController";
        $this->resultMap ["widget_field_check"] = "widgetFieldCheck";
		$this->resultMap ["widget_icon"] = "widgetIcon";
		$this->resultMap ["widget_cat_id"] = "widgetCatId";
		$this->resultMap ["widget_cat_name"] = "widgetCatName";
		$this->resultMap ["grid_widget_id"] = "gridWidgetId";
		$this->resultMap ["grid_widget_status"] = "gridWidgetStatus";
		$this->resultMap ["grid_widget_order"] = "gridWidgetOrder";
	}
	public $widgetName;
	public $widgetDescription;
	public $widgetController;
    public $widgetFieldCheck;
	public $widgetIcon;
	public $widgetCatId;
	public $widgetCatName;
	public $gridWidgetId; // map to gridWidget
	public $gridWidgetStatus; // map to gridWidget
	public $gridWidgetOrder; // map to gridWidget
}