<?php
namespace frontend\widgets;
use common\utils\FileUtil;
use core\utils\RequestUtil;

class ImageWidget
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
        //get setting
        if (isset ($this->widgetContentInfo ['widgetContentLanguages'] [$this->languageCode])) {
            $settingLanguage = $this->widgetContentInfo ['widgetContentLanguages'] [$this->languageCode]->setting;
            $widgetFieldCheck = $this->widgetContentInfo['widgetFieldCheck'];
            if ($settingLanguage[$widgetFieldCheck] != 0) {
                $setting = $settingLanguage;
            } else {
                $setting = json_decode($this->widgetContentInfo ['setting'], true);
            }
        } else {
            $setting = json_decode($this->widgetContentInfo ['setting'], true);
        }

        // send data
        $widgetData = array();
        RequestUtil::set('widgetData', $widgetData);

        // load view
        FileUtil::loadWidgetView($this->widgetContentInfo, $setting);
    }
}