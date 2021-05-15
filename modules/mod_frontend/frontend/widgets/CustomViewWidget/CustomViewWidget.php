<?php
namespace frontend\widgets;
use common\utils\FileUtil;

class CustomViewWidget
{
    public $widgetContentInfo;
    public $widgetContentLangs;
    public $languageCode;

    /**
     * __construct of widget
     */
    function __construct($widgetContentInfo, $widgetContentLangs = array(), $languageCode = "en")
    {
        $this->widgetContentInfo = $widgetContentInfo;
        $this->widgetContentLangs = $widgetContentLangs;
        $this->languageCode = $languageCode;
    }

    /**
     * View widget in frontend
     */
    public function view()
    {
        $setting = json_decode($this->widgetContentInfo ['setting'], true);
        FileUtil::loadWidgetView($this->widgetContentInfo, $setting);
    }
}