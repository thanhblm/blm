<?php
namespace frontend\widgets;
use common\utils\FileUtil;
use core\utils\RequestUtil;
use core\utils\AppUtil;
use frontend\controllers\ControllerHelper;

class HtmlWidget
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
            if ($settingLanguage[$widgetFieldCheck] != '') {
                $setting = $settingLanguage;
            } else {
                $setting = json_decode($this->widgetContentInfo ['setting'], true);
            }
        } else {
            $setting = json_decode($this->widgetContentInfo ['setting'], true);
        }

        //build $setting['content']
        $pattern = "/{.*?}/";
        $formats = array ();
        $replaceMap = array ();
		if (preg_match_all ( $pattern, $setting ['content'], $matches )) {
        	$formats = $matches [0];
        	foreach ($formats as $format){
        		$math = substr ( $format, 1, strlen ( $format ) - 2 );
        		$exp = explode(',', $math);
        		if(isset($exp[1])){
	        		$type = trim($exp[0]);
	        		$data = trim($exp[1]);
	        		switch ($type){
	        			case 'link':
	        				$replaceMap [$format] = ControllerHelper::getFriendlyUrl($data);
	        				break;
	        		}
        		}
        	}
        	$setting ['content'] = AppUtil::replaceByMap ( $replaceMap, $setting ['content'] );
        }
        
        // send data
        $widgetData = array();
        RequestUtil::set('widgetData', $widgetData);

        // load view
        FileUtil::loadWidgetView($this->widgetContentInfo, $setting);
    }
}