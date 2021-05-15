<?php
namespace backend\widgets;
use common\utils\FileUtil;

class TextWidget
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
     * Display input from in admin side
     */
    public function form()
    {
        FileUtil::loadWidgetForm($this->widgetContentInfo, $this->widgetContentLangs);
    }
}