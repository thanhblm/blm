<?php

namespace layout\widgets;

use common\template\extend\SelectInput;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $widgetContentLangs)
$widgetId = $widgetContentInfo->widgetId;
$widgetData = RequestUtil::get ( 'widgetData' );
?>
<div class="form-body" style="margin-left: 15px; margin-right: 15px;">
	<?php
	// get $setting
	$setting = ($widgetContentInfo->setting || $widgetContentInfo->setting != '') ? json_decode ( $widgetContentInfo->setting, true ) : array ();
	// set setting default
	$setting ['content'] = (isset ( $setting ['content'] )) ? $setting ['content'] : '';
	
	$text = new TextArea ( 'textarea_fluid' );
	$text->name = "widgetContentVo[setting][content]";
	$text->label = Lang::get ( "Content" );
	$text->class = "html_widget_content";
    $text->value = htmlentities($setting ['content']);
	$text->render ();
	?>
</div>