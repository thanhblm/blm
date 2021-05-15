<?php
namespace backend\widgets;
use common\utils\FileUtil;
use core\config\ModuleConfig;
use core\utils\RequestUtil;
use core\utils\RouteUtil;

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
     * Display input from in admin side
     */
    public function form()
    {
        $mod = 'mod_frontend';
        $controller = $this->widgetContentInfo->widgetController;
        $modulePath = ModuleConfig::getModuleConfig ( $mod ) ['MODULE_PATH'];
        $dir = $modulePath . DS . str_replace ( 'mod_', '', $mod ) . DS . "widgets" . DS . $controller . DS . 'view';
        $fileList = scandir($dir, SCANDIR_SORT_ASCENDING);
        $customerViewList = array();
        foreach ($fileList as $k => $v){
            if($v != '..' & $v != '.' & $v != 'view.php'){
                $customerViewList[$v] = $v;
            }
        }

        // send data
        $widgetData = array();
        RequestUtil::set('customerViewList', $customerViewList);

        FileUtil::loadWidgetForm($this->widgetContentInfo, $this->widgetContentLangs);
    }
}