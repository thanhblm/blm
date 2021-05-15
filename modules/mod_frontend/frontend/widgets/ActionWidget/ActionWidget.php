<?php

namespace frontend\widgets;

use core\Lang;
use core\utils\ActionUtil;

class ActionWidget
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
        if(!empty($setting['action'])) {
            echo "<!-- load action {$setting['action']} -->";
            echo "<div data-content-action = '".$setting['action']."' class='text-center'> ".Lang::get('Loading...')." </div>";
        }
        else{
            \DatoLogUtil::error ( "Not found action in setting" );
        }
    }
}